<?php

    namespace App\DataTables\Klinik;

    use App\Models\JenisPasien;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class JenisPasienDataTable extends DataTable
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
                        $query->where(function ($q) use ($search) {
                            $q->where('nama', 'like', "%" . $search['value'] . "%")
                              ->orWhere('keterangan', 'like', "%" . $search['value'] . "%");
                        });
                    }
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->addColumn('nama', function (JenisPasien $model) {
                    return $model->nama;
                })
                ->addColumn('keterangan', function (JenisPasien $model) {
                    return $model->keterangan;
                })
                ->addColumn('action', function (JenisPasien $model) {
                    return view('pages.klinik.jenis_pasien._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \JenisPasien $model
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(JenisPasien $model)
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
                        ->setTableId('jenispasien-table')
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
                Column::make('nama')->title(__('Jenis Pasien'))->searchable(true),
                Column::make('keterangan')->title(__('Keterangan'))->searchable(true),
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
            return 'JenisPasien_' . date('YmdHis');
        }
    }
