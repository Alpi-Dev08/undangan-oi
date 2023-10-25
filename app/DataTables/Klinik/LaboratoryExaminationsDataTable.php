<?php

    namespace App\DataTables\Klinik;

    use App\Models\Klinik\LaboratoryExamination;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class LaboratoryExaminationsDataTable extends DataTable
    {
        /**
         * Build DataTable class.
         *
         * @param mixed $query Results from query() method.
         * @return \Yajra\DataTables\DataTableAbstract
         */
        public function dataTable($query)
        {
            $query = $query->whereRelation('examination', 'deleted_at', '=', null);
            $query = $query->orderBy('created_at', 'desc');


            return datatables()
                ->eloquent($query)
                ->filter(function ($query) {
                    if (request()->has('search')) {
                        $search = request()->get('search');
                        $query->where('laboratory_name', 'like', "%" . $search['value'] . "%");
                    }
                })
                ->rawColumns(['action','file','code'])
                ->addIndexColumn()
                ->addColumn('laboratory_name', function (LaboratoryExamination $model) {
                    return $model->laboratory_name;
                })
                ->addColumn('patient', function (LaboratoryExamination $model) {
                    return $model->examination->user->name;
                })
                ->addColumn('register_date', function (LaboratoryExamination $model) {
                    return $model->created_at;
                })
                ->addColumn('file', function (LaboratoryExamination $model) {
                    if($model->file){
                        return view('pages.klinik.laboratoryexaminations._download', compact('model'));
                    } else {
                        return view('pages.klinik.laboratoryexaminations._download', compact('model'));
                    }
                })
                ->addColumn('action', function (LaboratoryExamination $model) {
                    return view('pages.klinik.laboratoryexaminations._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \App\Models\Hms\LaboratoryExamination $model
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(LaboratoryExamination $model)
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
                ->setTableId('laboratoryexaminations-table')
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

        /**
         * Get columns.
         *
         * @return array
         */
        protected function getColumns()
        {
            return [
                Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false),
                Column::make('patient')->title(__('Patient'))->searchable(true),
                Column::make('laboratory_name')->title(__('Laboratory'))->searchable(true),
                Column::make('register_date')->title(__('Laboratory Registration Date'))->searchable(true),
                Column::make('file')->title(__('Result'))->searchable(false),
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
            return 'LaboratoryExaminations_' . date('YmdHis');
        }
    }
