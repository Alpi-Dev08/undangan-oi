<?php

    namespace App\DataTables\Klinik;

    use App\Models\Klinik\Transaction;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class TransactionsDataTable extends DataTable
    {
        /**
         * Build DataTable class.
         *
         * @param mixed $query Results from query() method.
         * @return \Yajra\DataTables\DataTableAbstract
         */
        public function dataTable($query)
        {
            $query = $query->whereRelation('examination', 'deleted_at', '=', null);
	    $query = $query->whereHas(
                'examination', function($q){
                $q->where('appointment_status', '1')->orWhere('appointment_status',null);
            })->orderBy('created_at', 'desc');
            return datatables()
                ->eloquent($query)
                ->filter(function ($query) {
                    if (request()->has('search')) {
                        $search = request()->get('search');
                        $query->where('invoice_number', 'like', "%" . $search['value'] . "%");
                    }
                })
                ->rawColumns(['action','invoice_number'])
                ->addIndexColumn()
                ->addColumn('invoice_number', function (Transaction $model) {
                    if(isset($model->examination->user->name)){
                        return $model->invoice_number . '<br>' . $model->examination->user->name;
                    }
                    return $model->invoice_number;
                })
                ->addColumn('amount', function (Transaction $model) {
                    return $model->amount;
                })
                ->addColumn('status', function (Transaction $model) {
                    return $model->status;
                })
                ->addColumn('action', function (Transaction $model) {
                    return view('pages.klinik.transactions._action', compact('model'));
                });
        }

        /**
         * Get query source of dataTable.
         *
         * @param \App\Models\Klinik\Transaction $model
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function query(Transaction $model)
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
                ->setTableId('transactions-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
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
                Column::make('invoice_number')->title(__('Invoice Number'))->searchable(true),
                Column::make('amount')->title(__('Amount'))->searchable(true),
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
            return 'Transactions_' . date('YmdHis');
        }
    }
