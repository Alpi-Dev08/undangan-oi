<?php

namespace App\DataTables\Klinik;

use App\Models\Klinik\Drug;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DrugsDataTable extends DataTable
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
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $search = request()->get('search');
                    $query->where('name', 'like', '%'.$search['value'].'%')
                        ->orWhereRelation('unit', 'name', 'like', '%'.$search['value'].'%');
                }
            })
            ->rawColumns(['action','kfa_code'])
            ->addIndexColumn()
            ->addColumn('unit', function (Drug $model) {
		if($model->unit){
			return $model->unit->name;
		}
                return "-";
            })
            ->addColumn('name', function (Drug $model) {
                return $model->name;
            })
            ->addColumn('price', function (Drug $model) {
                return $model->price;
            })
            ->addColumn('stock', function (Drug $model) {
                return $model->stock;
            })
            ->addColumn('kfa_code', function (Drug $model) {
                if ($model->kfa_code) {
                    return '<a href="'.route('drugs.detail', ['drug' => $model->id]).'" class="badge badge-light-primary" title="Lihat detail: '.e($model->kfa_code).'">'.e($model->kfa_code).'</a>';
                }
                return '<span class="badge badge-light-warning">✗</span>';
            })
            ->addColumn('action', function (Drug $model) {
                return view('pages.klinik.drugs._action', compact('model'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \Drug  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Drug $model)
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
            ->setTableId('drugs-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc')
            ->stateSave(false)
            ->responsive()
            ->autoWidth(true)
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
            Column::make('unit')->title(__('Drug Unit'))->searchable(true),
            Column::make('name')->title(__('Name'))->searchable(true),
            Column::make('price')->title(__('Price'))->searchable(true),
            Column::make('stock')->title(__('Stock'))->searchable(true),
            Column::make('kfa_code')->title(__('KFA'))->searchable(false),
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
        return 'Drugs_'.date('YmdHis');
    }
}
