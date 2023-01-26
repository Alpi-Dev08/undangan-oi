<?php

    namespace App\DataTables\Klinik;

    use App\Models\Klinik\Package;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class PackagesDataTable extends DataTable
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
                    }
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->addColumn('name', function (Package $model) {
                    return $model->name;
                })
                ->addColumn('price', function (Package $model) {
                    return $model->price;
                })
                ->addColumn('description',function (Package $model) {
                    return $model->description;
                })
                ->addColumn('status',function (Package $model) {
                    return $model->is_active ? "Active" : "Inactive";
                })
                ->addColumn('action', function (Package $model) {
                    return view('pages.klinik.packages._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \Package $model
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(Package $model)
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
                ->setTableId('packages-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->orderBy(1,'asc')
                ->stateSave(false)
                ->responsive()
                ->autoWidth(true)
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
                Column::make('price')->title(__('price'))->searchable(true),
                Column::make('description')->title(__('Description'))->searchable(true),
                Column::make('status')->title(__('Status'))->searchable(true),
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->addClass('text-center')
                    ->responsivePriority(-1)
            ];
        }

        /**
         * Get filename for export.
         *
         * @return string
         */
        protected function filename() : string
        {
            return 'Packages_' . date('YmdHis');
        }
    }
