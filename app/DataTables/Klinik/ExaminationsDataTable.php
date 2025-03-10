<?php

    namespace App\DataTables\Klinik;

    use App\Models\Klinik\Examination;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class ExaminationsDataTable extends DataTable
    {
        /**
         * Build DataTable class.
         *
         * @param mixed $query Results from query() method.
         * @return \Yajra\DataTables\DataTableAbstract
         */

        public function dataTable($query)
        {
            $query = $query->where('appointment_status',null)->orWhere('appointment_status',1)->orderBy('created_at', 'desc');

		return datatables()
                ->eloquent($query)
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->addColumn('examination_code', function (Examination $model) {
                    return $model->examination_code;
                })
                ->addColumn('service', function (Examination $model) {
                    return $model->service_category->name ?? "-";
                })
                ->addColumn('name', function (Examination $model) {
		    return $model->user->name ?? "-";
                })
                ->addColumn('register_date', function (Examination $model) {
                    return $model->created_at;
                })
                ->addColumn('status', function (Examination $model) {
                    return $model->status;
                })
                ->addColumn('jenis_pasien', function (Examination $model) {
                    $jenisPasien = $model->jenis_pasien->nama ?? "Umum";
                    return "Pasien ".$jenisPasien;
                })
                ->addColumn('action', function (Examination $model) {
                    return view('pages.klinik.examinations._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \App\Models\Klinik\Examination $model
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(Examination $model)
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
                ->setTableId('examinations-table')
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
                Column::make('examination_code')->title(__('Examination Code'))->searchable(true),
                Column::make('jenis_pasien')->title(__('Jenis Pasien'))->searchable(true),
                Column::make('service')->title(__('Service'))->searchable(true),
                Column::make('name')->title(__('Name'))->searchable(true),
                Column::make('register_date')->title(__('Examination Date'))->searchable(true),
                Column::make('status')->title(__('Status'))->searchable(true),
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
            return 'Examinations_' . date('YmdHis');
        }
    }
