<?php

namespace App\DataTables\Klinik;

use App\Models\Klinik\PersonalDiseaseHistory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PersonalDiseaseHistoryDataTable extends DataTable
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
            ->addColumn('code', function (PersonalDiseaseHistory $model) {
                return $model->code;
            })
            ->addColumn('name', function (PersonalDiseaseHistory $model) {
                return $model->name;
            })
            ->addColumn('code_system', function (PersonalDiseaseHistory $model) {
                return $model->code_system;
            })
            ->addColumn('value_set', function (PersonalDiseaseHistory $model) {
                return $model->value_set;
            })
            ->addColumn('action', function (PersonalDiseaseHistory $model) {
                return view('pages.klinik.personal_disease_history._action', compact('model'));
            });
    }

    public function query(PersonalDiseaseHistory $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('personal-disease-history-table')
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
            Column::make('value_set')->title(__('Value Set'))->searchable(true),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center')
                  ->responsivePriority(-1),
        ];
    }

    protected function filename() : string
    {
        return 'PersonalDiseaseHistory_' . date('YmdHis');
    }
}
