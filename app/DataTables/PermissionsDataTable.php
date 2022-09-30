<?php

    namespace App\DataTables;

    use App\Models\PermissionGroup;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class PermissionsDataTable extends DataTable
    {
        /**
         * Build DataTable class.
         *
         * @param mixed $query Results from query() method.
         * @return \Yajra\DataTables\DataTableAbstract
         */
        public function dataTable($query)
        {
            return datatables()
                ->eloquent($query)
                ->rawColumns(['action','role'])
                ->addIndexColumn()
                ->addColumn('name', function (PermissionGroup $model) {
                    return $model->name;
                })
                ->addColumn('role', function (PermissionGroup $model){
                    $role =  $model->roles($model);
                    return view('pages.permissions._checkbox', compact('role'));
                })
                ->addColumn('action', function (PermissionGroup $model) {
                    return view('pages.permissions._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \App\Models\PermissionGroup $model
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(PermissionGroup $model)
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
                ->setTableId('permissions-table')
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
                Column::make('name')->title('Name'),
                Column::make('role')->title('Assign To'),
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
            return 'Permissions_' . date('YmdHis');
        }
    }
