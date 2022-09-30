<?php

    namespace App\DataTables\Masters;

    use App\Models\Master\District;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class DistrictsDataTable extends DataTable
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
                            ->orWhere('area_code', 'like', "%" . $search['value'] . "%")
                            ->orWhereRelation('country','name', 'like', "%" . $search['value'] . "%")
                            ->orWhereRelation('province','name', 'like', "%" . $search['value'] . "%")
                            ->orWhereRelation('city','name', 'like', "%" . $search['value'] . "%");
                    }
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->addColumn('area_code', function (District $model) {
                    return $model->area_code;
                })
                ->addColumn('country', function (District $model) {
                    return $model->country->name;
                })
                ->addColumn('province', function (District $model) {
                    return $model->province->name;
                })
                ->addColumn('city', function (District $model) {
                    return $model->city->name;
                })
                ->addColumn('name', function (District $model) {
                    return $model->name;
                })
                ->addColumn('action', function (District $model) {
                    return view('pages.masters.districts._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \District $model
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(District $model)
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
                ->setTableId('districts-table')
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
                Column::make('area_code')->title(__('Area Code'))->searchable(true),
                Column::make('country')->title(__('Country'))->searchable(true),
                Column::make('province')->title(__('Province'))->searchable(true),
                Column::make('city')->title(__('City'))->searchable(true),
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
            return 'Districts_' . date('YmdHis');
        }
    }
