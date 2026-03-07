<?php

namespace App\DataTables\Masters;

use App\Models\Master\Fitur;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FiturDataTable extends DataTable
{
    /**
     * Build DataTable.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)

            ->filter(function ($query) {
                if (request()->has('search')) {
                    $search = request()->get('search')['value'] ?? null;

                    if ($search) {
                        $query->where('nama_fitur', 'like', "%{$search}%")
                              ->orWhere('kode_fitur', 'like', "%{$search}%");
                    }
                }
            })

            ->addIndexColumn()

            ->addColumn('action', function (Fitur $model) {
                return view('pages.masters.fitur._action', compact('model'));
            })

            ->rawColumns(['action']);
    }

    /**
     * Query source.
     */
    public function query(Fitur $model)
    {
        return $model->newQuery();
    }

    /**
     * HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('fitur-table')
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

            Column::make('kode_fitur')
                ->title('Kode Fitur'),

            Column::make('nama_fitur')
                ->title('Nama Fitur'),

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
        return 'Fitur_' . date('YmdHis');
    }
}