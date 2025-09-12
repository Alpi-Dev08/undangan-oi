<?php

namespace App\DataTables\Klinik;

use App\Models\Klinik\SkriningExamination;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SkriningExaminationsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->rawColumns(['action', 'file', 'code'])
            ->addIndexColumn()
            ->addColumn('patient', function (SkriningExamination $model) {
                return $model->first_name . ' ' . $model->last_name;
            })
            ->addColumn('skrining_type', function (SkriningExamination $model) {
                return $model->skriningexaminationtype ? $model->skriningexaminationtype->name : '-';
            }) 
            ->addColumn('skrining_location', function (SkriningExamination $model) {
                return $model->location ? $model->location->name : '-';
            })
            ->addColumn('tanggal_skrining', function (SkriningExamination $model) {
                return $model->examination_date;
            })
            ->addColumn('gender', function (SkriningExamination $model) {
                return $model->gender ? $model->gender->name : '-';
            })
            ->addColumn('file', function (SkriningExamination $model) {
                return view('pages.klinik.skriningexaminations._download', compact('model'));
            })
            ->addColumn('action', function (SkriningExamination $model) {
                return view('pages.klinik.skriningexaminations._action', compact('model'));
            })
            ->filter(function ($query) {
                $location = request('location');
                $date = request('date'); // konsisten pakai 'date'

                if (!empty($location)) {
                    $query->where('location_id', $location);
                }
                if (!empty($date)) {
                    $query->whereDate('examination_date', $date);
                }
            });
    }

    /**
     * Query data.
     */
    public function query(SkriningExamination $model)
    {
        $query = $model->newQuery()->with(['skriningexaminationtype', 'gender', 'location'])
        ->orderBy('created_at', 'desc');

        $request = request();
        if ($request->has('location') && $request->location != '') {
            $query->where('location_id', $request->location);
        }
        if ($request->has('date') && $request->date != '') { // konsisten pakai 'date'
            $query->whereDate('examination_date', $request->date);
        } 

        return $query;
    }

    /**
     * Table HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('skriningexaminations-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive()
            ->autoWidth(false)
            ->parameters([
                'scrollX' => true,
                'drawCallback' => 'function() { KTMenu.createInstances(); }',
            ])
            ->addTableClass('align-middle table-row-dashed fs-6 gy-5');
    }

    /**
     * Define table columns.
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('NO')->orderable(false)->searchable(false),
            Column::make('patient')->title(__('NAME'))->searchable(true),
            Column::make('tanggal_skrining')->title(__('EXAMINATION DATE'))->searchable(true),
            Column::make('skrining_location')->title(__('EXAMINATION LOCATION'))->searchable(true),
            Column::make('file')->title(__('RESULT'))->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->responsivePriority(-1),
        ];
    }

    /**
     * Filename untuk export.
     */
    protected function filename(): string
    {
        return 'SkriningExaminations_' . date('YmdHis');
    }
}
