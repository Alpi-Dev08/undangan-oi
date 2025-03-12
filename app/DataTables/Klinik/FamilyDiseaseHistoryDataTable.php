<?php

namespace App\DataTables\Klinik;

use App\Models\Klinik\FamilyDiseaseHistory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FamilyDiseaseHistoryDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $search = request()->get('search');
                    $query->where(function ($q) use ($search) {
                        $q->where('code', 'like', "%" . $search['value'] . "%")
                          ->orWhere('name', 'like', "%" . $search['value'] . "%")
                          ->orWhere('code_system', 'like', "%" . $search['value'] . "%")
                          ->orWhere('value_set', 'like', "%" . $search['value'] . "%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->addColumn('code', function (FamilyDiseaseHistory $model) {
                return $model->code;
            })
            ->addColumn('name', function (FamilyDiseaseHistory $model) {
                return $model->name;
            })
            ->addColumn('code_system', function (FamilyDiseaseHistory $model) {
                return $model->code_system;
            })
            ->addColumn('value_set', function (FamilyDiseaseHistory $model) {
                return $model->value_set;
            })
            ->addColumn('action', function (FamilyDiseaseHistory $model) {
                return view('pages.klinik.family_disease_histories._action', compact('model'));
            });
    }

    public function query(FamilyDiseaseHistory $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('family-disease-histories-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1,'asc')
                    ->stateSave(false)
                    ->responsive()
                    ->autoWidth(false)
                    ->parameters([
                        'scrollX'      => true,
                        'drawCallback' => 'function() { KTMenu.createInstances(); }',
                    ])
                    ->addTableClass('align-middle table-row-dashed fs-6 gy-5');
    }

    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false),
            Column::make('code')->title(__('Code'))->searchable(true),
            Column::make('name')->title(__('Name'))->searchable(true),
            Column::make('code_system')->title(__('Code System'))->searchable(true),
            Column::make('value_set')->title(__('Source Code'))->searchable(true),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center')
                  ->responsivePriority(-1),
        ];
    }

    protected function filename() : string
    {
        return 'FamilyDiseaseHistory_' . date('YmdHis');
    }
}
