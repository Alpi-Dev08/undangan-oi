<?php

    namespace App\DataTables;

    use App\Models\User;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class NakesDataTable extends DataTable
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
                $q->where('name', 'nakes');
            });
            return datatables()
                ->eloquent($query)
                ->rawColumns(['first_name','action'])
                ->addIndexColumn()
                ->editColumn('first_name', function (User $model) {
                    return view('pages.users._avatar', compact('model'));
                })
                ->editColumn('email', function (User $model) {
                    return $model->email;
                })
                ->addColumn('phone', function (User $model) {
                    return $model->info->phone;
                })
                ->addColumn('action', function (User $model) {
                    return view('pages.klinik.healthprofesionals._action', compact('model'));
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
                ->setTableId('users-table')
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
                Column::make('first_name')->title(__('Name')),
                Column::make('email'),
                Column::make('phone'),
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
            return 'Users_' . date('YmdHis');
        }
    }
