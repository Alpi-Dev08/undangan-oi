<?php

namespace App\DataTables\Masters;

use App\Models\Master\RelationshipStatus;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RelationshipStatusesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $search = request()->get('search');
                    $query->where('name', 'like', "%" . $search['value'] . "%");
                }
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->addColumn('name', function (RelationshipStatus $model) {
                return $model->name;
            })
            ->addColumn('action', function (RelationshipStatus $model) {
                return view('pages.masters.relationshipstatuses._action', compact('model'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Master\RelationshipStatus $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RelationshipStatus $model)
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
            ->setTableId('relationshipstatuses-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc')
            ->stateSave(false)
            ->responsive()
            ->autoWidth(false)
            ->parameters([
                'scrollX'      => true,
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
            Column::make('name')->title(__('Name'))->searchable(true),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->responsivePriority(-1),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() : string
    {
        return 'RelationshipStatuses_' . date('YmdHis');
    }
}
