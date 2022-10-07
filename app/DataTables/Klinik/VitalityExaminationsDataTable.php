<?php

    namespace App\DataTables\Klinik;

    use App\Models\Klinik\VitalityExamination;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class VitalityExaminationsDataTable extends DataTable
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
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->addColumn('weight', function (VitalityExamination $model) {
                    return $model->weight;
                })
                ->addColumn('height', function (VitalityExamination $model) {
                    return $model->height;
                })
                ->addColumn('blood_preasure', function (VitalityExamination $model) {
                    return $model->blood_preasure;
                })
                ->addColumn('heart_rate', function (VitalityExamination $model) {
                    return $model->heart_rate;
                })
                ->addColumn('respiratory_rate', function (VitalityExamination $model) {
                    return $model->respiratory_rate;
                })
                ->addColumn('temperature', function (VitalityExamination $model) {
                    return $model->temperature;
                })
                ->addColumn('oxygen_saturation', function (VitalityExamination $model) {
                    return $model->oxygen_saturation;
                })
                ->addColumn('body_mas_index', function (VitalityExamination $model) {
                    return $model->body_mas_index;
                })
                ->addColumn('ideal_weight', function (VitalityExamination $model) {
                    return $model->ideal_weight;
                })
                ->addColumn('body_fat', function (VitalityExamination $model) {
                    return $model->body_fat;
                })
                ->addColumn('bmi_conclusion', function (VitalityExamination $model) {
                    return $model->bmi_conclusion;
                })
                ->addColumn('action', function (VitalityExamination $model) {
                    return view('pages.klinik.vitalityexaminations._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \VitalityExamination $model
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(VitalityExamination $model)
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
                ->setTableId('vitalityexaminations-table')
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
                Column::make('weight')->searchable(true),
                Column::make('height')->searchable(true),
                Column::make('blood_preasure')->searchable(true),
                Column::make('heart_rate')->searchable(true),
                Column::make('respiratory_rate')->searchable(true),
                Column::make('temperature')->searchable(true),
                Column::make('oxygen_saturation')->searchable(true),
                Column::make('body_mass_index')->searchable(true),
                Column::make('ideal_weight')->searchable(true),
                Column::make('body_fat')->searchable(true),
                Column::make('bmi_conclusion')->searchable(true),
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
            return 'VitalityExaminations_' . date('YmdHis');
        }
    }
