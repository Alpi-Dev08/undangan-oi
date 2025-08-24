<?php

    namespace App\DataTables\Klinik;

    use App\Models\Klinik\Icdten;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class IcdtenDataTable extends DataTable
    {
        /**
         * Build DataTable class.
         *
         * @param mixed $query Results from query() method.
         * @return \Yajra\DataTables\DataTableAbstract
         */
        public function dataTable($query)
        {
            $query = $query->whereNotNull('code');
            return datatables()
                ->eloquent($query)
                ->filter(function ($query) {
                    if (request()->has('search')) {
                        $search = request()->get('search');
                        $query->where(function ($q) use ($search) {
                            $q->where('code', 'like', "%" . $search['value'] . "%")
                              ->orWhere('name', 'like', "%" . $search['value'] . "%");
                        });
                    }
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->addColumn('name', function (Icdten $model) {
                    return $model->name;
                })
                ->addColumn('action', function (Icdten $model) {
                    return view('pages.klinik.icdten._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \Icdten $model
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(Icdten $model)
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
                        ->setTableId('icdten-table')
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
                Column::make('code')->title(__('Code'))->searchable(true),
                Column::make('name')->title(__('Name'))->searchable(true),
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
            return 'Icdten_' . date('YmdHis');
        }
    }
