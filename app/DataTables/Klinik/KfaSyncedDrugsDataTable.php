<?php

namespace App\DataTables\Klinik;

use App\Models\Klinik\Drug;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KfaSyncedDrugsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Drug $drug) {
                return '<button class="btn btn-sm btn-info view-btn" data-kfa-code="' . $drug->kfa_code . '">Lihat Detail</button>';
            })
            ->editColumn('price', function (Drug $drug) {
                return 'Rp ' . number_format($drug->price, 0, ',', '.');
            })
            ->editColumn('kfa_code', function (Drug $drug) {
                return $drug->kfa_code ? '<span class="badge badge-light-success">✓ ' . $drug->kfa_code . '</span>' : '<span class="badge badge-light-warning">✗</span>';
            })
            ->rawColumns(['action', 'kfa_code']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Klinik\Drug  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Drug $model)
    {
        return $model->newQuery()
            ->whereNotNull('kfa_code')
            ->select(['id', 'name', 'kfa_code', 'price', 'stock']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('kfa-synced-drugs-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->responsive()
            ->autoWidth(true)
            ->parameters([
                'scrollX' => true,
                'processing' => true,
                'serverSide' => true,
                'searching' => true,
                'lengthChange' => true,
                'pageLength' => 10,
                'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, "All"]]
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
            Column::make('name')->title('Nama Obat'),
            Column::make('kfa_code')->title('Kode KFA'),
            Column::make('price')->title('Harga'),
            Column::make('stock')->title('Stok'),
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
        return 'KfaSyncedDrugs_' . date('YmdHis');
    }
}