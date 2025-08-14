<?php

namespace App\DataTables\Klinik;

use App\Models\Klinik\SkriningExaminationLocation;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LocationExaminationsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->addColumn('action', function (SkriningExaminationLocation $model) {
                // buat tombol edit/hapus, jika perlu
                return view('pages.klinik.locationexaminations._action', compact('model'));
            });
    }

    /**
     * Query data.
     */
    public function query(SkriningExaminationLocation $model)
    {
        return $model->newQuery();
    }

    /**
     * Table HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('locationexaminations-table')
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
     * Define table columns.
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false),
            Column::make('name')->title('Location')->searchable(true),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->responsivePriority(-1),
        ];
    }

    /**
     * Filename untuk export.
     */
    protected function filename(): string 
    {
        return 'LocationExaminations_' . date('YmdHis');
    }
}
