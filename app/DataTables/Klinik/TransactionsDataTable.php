<?php

namespace App\DataTables\Klinik;

use App\Models\Klinik\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TransactionsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = $query->whereHas(
            'examination', function ($q) {
                $q->where('appointment_status', '1')->orWhere('appointment_status', null);
            })
            ->with(['examination.user'])
            ->orderBy('created_at', 'desc');

        return datatables()
            ->eloquent($query)
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $search = request()->get('search');
                    $query->where('invoice_number', 'like', '%'.$search['value'].'%');
                }
            })
            ->rawColumns(['action', 'invoice_number', 'amount'])
            ->addIndexColumn()
            ->addColumn('invoice_number', function (Transaction $model) {
                if (isset($model->examination->user->name)) {
                    return $model->invoice_number.'<br>'.$model->examination->examination_code.'<br>'.$model->examination->user->name;
                }

                return $model->invoice_number;
            })
            ->addColumn('amount', function (Transaction $model) {
                // Hitung total resep dari examination (gabungkan Prescription terbaru dan resep JSON lama)
                // Log setiap tahap perhitungan agar mudah ditelusuri.
                $total_resep = 0.0;
                try {
                    DB::beginTransaction();

                    if ($model->examination) {
                        // Prioritas: prescription terbaru berdasarkan resep_date
                        try {
                            $latestPrescription = $model->examination
                                ->prescriptions()
                                ->with(['items.drug'])
                                ->orderByDesc('resep_date')
                                ->first();
                                if ($latestPrescription) {
                                    Log::info('TransactionsDataTable: prescription terbaru dimuat', [
                                        'transaction_id' => $model->id,
                                        'prescription_id' => $latestPrescription->id,
                                        'items_count' => $latestPrescription->items->count(),
                                    ]);
                                } else {
                                    Log::info('TransactionsDataTable: tidak ada prescription terbaru', [
                                        'transaction_id' => $model->id,
                                    ]);
                                }
                        } catch (\Throwable $e) {
                            $latestPrescription = null;
                            Log::warning('TransactionsDataTable: gagal memuat prescription terbaru', [
                                'transaction_id' => $model->id,
                                'error' => $e->getMessage(),
                            ]);
                        }

                        if ($latestPrescription && $latestPrescription->items && $latestPrescription->items->count()) {
                            foreach ($latestPrescription->items as $item) {
                                $price = null;
                                if ($item->relationLoaded('drug') && $item->drug) {
                                    $price = $item->drug->price;
                                } elseif (!empty($item->drug_id)) {
                                    // Fallback ke helper lama bila ada
                                    $drug = function_exists('getObat') ? getObat($item->drug_id) : null;
                                    $price = $drug->price ?? null;
                                }


                                $quantity = is_numeric($item->qty) ? (float) $item->qty : 0.0;
                                if ($price !== null) {
                                    $total_resep += $quantity * (float) $price;
                                    Log::info('TransactionsDataTable: akumulasi resep dari prescription', [
                                        'transaction_id' => $model->id,
                                        'subtotal_resep' => (float) $total_resep,
                                        'price' => (float) $price,
                                        'quantity' => (float) $quantity,
                                    ]);
                                }
                            }
                        }

                        // Fallback: dukung data lama yang disimpan di examination->resep (JSON/string)
                        if ($model->examination->resep) {
                            $resepRaw = $model->examination->resep;
                            $resep = is_string($resepRaw) ? json_decode($resepRaw ?: '{}') : (is_array($resepRaw) ? (object) $resepRaw : null);
                            if ($resep && isset($resep->obat) && is_array($resep->obat)) {
                                $obat = $resep->obat;
                                $qty = $resep->qty ?? [];
                                foreach ($obat as $key => $value) {
                                    $drug = function_exists('getObat') ? getObat($value) : null;
                                    if ($drug && isset($drug->name)) {
                                        $quantity = isset($qty[$key]) && is_numeric($qty[$key]) ? (float) $qty[$key] : 0.0;
                                        $price = isset($drug->price) ? (float) $drug->price : 0.0;
                                        $total_resep += $quantity * $price;
                                        Log::info('TransactionsDataTable: akumulasi resep dari JSON lama', [
                                            'transaction_id' => $model->id,
                                            'subtotal_resep' => (float) $total_resep,
                                            'price' => (float) $price,
                                            'quantity' => (float) $quantity,
                                        ]);
                                    }
                                }
                            }
                        }
                    }

                    DB::commit();
                } catch (\Throwable $e) {
                    DB::rollBack();
                    Log::error('TransactionsDataTable: gagal menghitung total resep', [
                        'transaction_id' => $model->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                // Tampilkan amount asli + total resep
                $total_amount = (float) $model->amount + (float) $total_resep;

                Log::debug('TransactionsDataTable: total amount dihitung', [
                    'transaction_id' => $model->id,
                    'amount_asli' => (float) $model->amount,
                    'total_resep' => (float) $total_resep,
                    'total_amount' => (float) $total_amount,
                ]);

                return 'Rp ' . number_format($total_amount, 0, ',', '.') . ',-';
            })
            ->addColumn('status', function (Transaction $model) {
                return $model->status;
            })
            ->addColumn('action', function (Transaction $model) {
                return view('pages.klinik.transactions._action', compact('model'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaction $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('transactions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->stateSave(false)
            ->responsive()
            ->autoWidth(false)
            ->parameters([
                'scrollX' => true,
                'drawCallback' => 'function() { KTMenu.createInstances(); }',
            ])
            ->addTableClass('align-middle table-row-dashed fs-6 gy-5');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false),
            Column::make('invoice_number')->title(__('Invoice Number'))->searchable(true),
            Column::make('amount')->title(__('Total Amount'))->searchable(true),
            Column::make('status')->title(__('Status'))->searchable(true),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->responsivePriority(-1),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Transactions_'.date('YmdHis');
    }
}
