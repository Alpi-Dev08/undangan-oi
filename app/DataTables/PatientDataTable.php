<?php

    namespace App\DataTables;

    use App\Models\User;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class PatientDataTable extends DataTable
    {
        /**
         * Build DataTable class.
         *
         * @param mixed $query Results from query() method.
         * @return \Yajra\DataTables\DataTableAbstract
         */
        public function dataTable($query)
        {
            $query = $query->whereHas(
                'roles', function($q){
                $q->where('name', 'patient');
            });
            return datatables()
                ->eloquent($query)
                ->filter(function ($query) {
                    if (request()->has('search')) {
                        $search = request()->get('search');
                        $query->where('first_name', 'like', "%" . $search['value'] . "%")
                        ->where('last_name', 'like', "%" . $search['value'] . "%")
                        ->where('phone', 'like', "%" . $search['value'] . "%")
                        ->orWhereRelation('patient', 'patient_code', 'like', "%" . $search['value'] . "%");
                    }
                })
                ->rawColumns(['first_name','action'])
                ->addIndexColumn()
                ->editColumn('patient_id', function (User $model) {
                    return $model->patient->patient_code;
                })
                ->editColumn('his_number', function (User $model) {
                    return $model->patient->his_number ?? "";
                })
                ->editColumn('first_name', function (User $model) {
                    return $model->name;
                })
                ->addColumn('phone', function (User $model) {
                    return $model->phone;
                })
                ->addColumn('birthday', function (User $model) {
                    return $model->info->date_of_birth;
                })
                ->addColumn('action', function (User $model) {
                    return view('pages.klinik.patients._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \App\Models\User $model
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(User $model)
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
                ->setTableId('patients-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->orderBy(0,'asc')
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
                Column::make('patient_id')->title(__('Patient ID')),
                Column::make('his_number')->title(__('HIS Number')),
                Column::make('first_name')->title(__('Name')),
                Column::make('phone'),
                Column::make('birthday')->title(__('Birthday')),
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
            return 'Patients_' . date('YmdHis');
        }
    }
