<?php

namespace App\DataTables\Masters;

use App\Models\Master\Paket;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaketDataTable extends DataTable
{
    /**
     * Build DataTable.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)

            ->addColumn('nama_jenis', function (Paket $paket) {
                return $paket->jenis->nama_jenis ?? '-';
            })

            ->filter(function ($query) {
                if (request()->has('search')) {
                    $search = request()->get('search')['value'] ?? null;

                    if ($search) {
                        $query->where('nama_paket', 'like', "%{$search}%")
                              ->orWhere('harga', 'like', "%{$search}%")
                              ->orWhereHas('jenis', function ($q) use ($search) {
                                  $q->where('nama_jenis', 'like', "%{$search}%");
                              });
                    }
                }
            })

            ->editColumn('harga', function (Paket $paket) {
                return 'Rp ' . number_format($paket->harga, 0, ',', '.');
            })

            ->addIndexColumn()

            ->addColumn('action', function (Paket $model) {
                return view('pages.masters.paket._action', compact('model'));
            })

            ->rawColumns(['action']);
    }

    /**
     * Query source.
     */
    public function query(Paket $model)
    {
        return $model->newQuery()->with('jenis');
    }

    /**
     * HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('paket-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc')
            ->responsive()
            ->autoWidth(false)
            ->parameters([
                'scrollX'      => true,
                'drawCallback' => 'function() { KTMenu.createInstances(); }',
            ])
            ->addTableClass('align-middle table-row-dashed fs-6 gy-5');
    }

    /**
     * Columns.
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')
                ->title('No')
                ->orderable(false)
                ->searchable(false),

            Column::make('nama_jenis')
                ->title('Jenis Undangan'),

            Column::make('nama_paket')
                ->title('Nama Paket'),

            Column::make('harga')
                ->title('Harga'),

            Column::make('masa_aktif_hari')
                ->title('Masa Aktif (Hari)'),

            Column::make('deskripsi')
                ->title('Deskripsi'),

            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->responsivePriority(-1),
        ];
    }

    /**
     * Filename export.
     */
    protected function filename(): string
    {
        return 'Paket_' . date('YmdHis');
    }
}