<?php

    namespace App\DataTables\Klinik;

    use App\Models\Klinik\Healthcare;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class HealthcaresDataTable extends DataTable
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
                ->filter(function ($query) {
                    if (request()->has('search')) {
                        $search = request()->get('search');
                        $query->where('name', 'like', "%" . $search['value'] . "%");
                        $query->orWhere('email', 'like', "%" . $search['value'] . "%");
                        $query->orWhere('phone', 'like', "%" . $search['value'] . "%");
                        $query->orWhere('address', 'like', "%" . $search['value'] . "%");
                    }
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->addColumn('name', function (Healthcare $model) {
                    return $model->name;
                })
                ->addColumn('email', function (Healthcare $model) {
                    return $model->email;
                })
                ->addColumn('phone', function (Healthcare $model) {
                    return $model->phone;
                })
                ->addColumn('address', function (Healthcare $model) {
                    return $model->address;
                })
                ->addColumn('action', function (Healthcare $model) {
                    return view('pages.klinik.healthcares._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \App\Models\Klinik\Healthcare $model
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(Healthcare $model)
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
                ->setTableId('healthcares-table')
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
                Column::make('name')->title(__('Name'))->searchable(true),
                Column::make('email')->title(__('Email'))->searchable(true),
                Column::make('phone')->title(__('Phone'))->searchable(true),
                Column::make('address')->title(__('Address'))->searchable(true),
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
            return 'Healthcares_' . date('YmdHis');
        }
    }
