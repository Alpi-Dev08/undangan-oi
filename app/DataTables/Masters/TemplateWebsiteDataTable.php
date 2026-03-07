<?php

namespace App\DataTables\Masters;

use App\Models\Master\Template;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TemplateWebsiteDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)

            /*
            |--------------------------------------------------------------------------
            | Relasi
            |--------------------------------------------------------------------------
            */

            ->addColumn('nama_jenis', function (Template $template) {
                return optional($template->jenis)->nama_jenis ?? '-';
            })

            ->addColumn('nama_kategori', function (Template $template) {
                return optional($template->kategori)->nama_kategori ?? '-';
            })

            /*
            |--------------------------------------------------------------------------
            | Folder (Slug)
            |--------------------------------------------------------------------------
            */

            ->addColumn('folder', function (Template $template) {
                return $template->slug;
            })

            /*
            |--------------------------------------------------------------------------
            | Preview Image
            |--------------------------------------------------------------------------
            */

            ->addColumn('preview', function (Template $template) {

                if (!$template->preview_image) {
                    return '<span class="text-muted">No Image</span>';
                }

                $url = asset('storage/' . $template->preview_image);

                return '
                    <a href="'.$url.'" target="_blank">
                        <img src="'.$url.'"
                             width="60"
                             class="rounded border">
                    </a>
                ';
            })

            /*
            |--------------------------------------------------------------------------
            | Demo Button (Pakai Accessor demo_url)
            |--------------------------------------------------------------------------
            */

            ->addColumn('demo', function (Template $template) {

                return '
                    <a href="'.$template->demo_url.'"
                       target="_blank"
                       class="btn btn-sm btn-light-primary">
                       Demo
                    </a>
                ';
            })

            /*
            |--------------------------------------------------------------------------
            | Status Badge
            |--------------------------------------------------------------------------
            */

            ->addColumn('status_label', function (Template $template) {

                return $template->status === 'aktif'
                    ? '<span class="badge badge-light-success">Aktif</span>'
                    : '<span class="badge badge-light-danger">Nonaktif</span>';
            })

            ->addIndexColumn()

            /*
            |--------------------------------------------------------------------------
            | Action
            |--------------------------------------------------------------------------
            */

            ->addColumn('action', function (Template $model) {
                return view('pages.masters.template_web._action', compact('model'));
            })

            ->rawColumns([
                'preview',
                'demo',
                'status_label',
                'action'
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Query
    |--------------------------------------------------------------------------
    */

    public function query(Template $model)
    {
        return $model->newQuery()
            ->with(['jenis', 'kategori'])
            ->where('jenis_id', 3)
            ->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | HTML Builder
    |--------------------------------------------------------------------------
    */

    public function html()
    {
        return $this->builder()
            ->setTableId('template_web-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc')
            ->responsive()
            ->autoWidth(false)
            ->parameters([
                'scrollX' => true,
                'drawCallback' => 'function() { KTMenu.createInstances(); }',
            ])
            ->addTableClass('align-middle table-row-dashed fs-6 gy-5');
    }

    /*
    |--------------------------------------------------------------------------
    | Columns
    |--------------------------------------------------------------------------
    */

    protected function getColumns()
    {
        return [

            Column::make('DT_RowIndex')
                ->title('No')
                ->orderable(false)
                ->searchable(false),

            Column::make('nama_template')
                ->title('Nama Template'),

            Column::make('nama_jenis')
                ->title('Jenis')
                ->orderable(false),

            Column::make('nama_kategori')
                ->title('Kategori')
                ->orderable(false),

            Column::make('folder')
                ->title('Folder'),

            Column::make('preview')
                ->title('Preview')
                ->orderable(false)
                ->searchable(false),

            Column::make('demo')
                ->title('Demo')
                ->orderable(false)
                ->searchable(false),

            Column::make('status_label')
                ->title('Status')
                ->orderable(false)
                ->searchable(false),

            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Template_' . date('YmdHis');
    }
}