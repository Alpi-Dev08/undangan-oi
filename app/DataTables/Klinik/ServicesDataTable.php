<?php

    namespace App\DataTables\Klinik;

    use App\Models\Klinik\Service;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class ServicesDataTable extends DataTable
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
                        $query->where('name', 'like', "%" . $search['value'] . "%")
                            ->orWhereRelation('category','name', 'like', "%" . $search['value'] . "%");
                    }
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->addColumn('category', function (Service $model) {
                    return $model->category->name ?? "";
                })
                ->addColumn('name', function (Service $model) {
                    return $model->name;
                })
                ->addColumn('price', function (Service $model) {
                    return $model->price;
                })
                ->addColumn('action', function (Service $model) {
                    return view('pages.klinik.services._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \Service $model
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(Service $model)
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
                ->setTableId('services-table')
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
                Column::make('category')->title(__('Service Category'))->searchable(true),
                Column::make('name')->title(__('Name'))->searchable(true),
                Column::make('price')->title(__('price'))->searchable(true),
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
            return 'Services_' . date('YmdHis');
        }
    }
