<?php

namespace App\DataTables\Masters;

use App\Models\Master\TemplateVideo;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TemplateVideoDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)

            ->addColumn('nama_jenis', function (TemplateVideo $model) {
                return $model->jenis->nama_jenis ?? '-';
            })

            ->addColumn('nama_kategori', function (TemplateVideo $model) {
                return $model->kategori->nama_kategori ?? '-';
            })

            ->editColumn('preview_image', function (TemplateVideo $model) {

                if (!$model->preview_image) {
                    return '-';
                }

                $image = asset('storage/' . $model->preview_image);
                $demoUrl = route('masters.demo.template_video', $model->slug);

                return '
                    <div class="d-flex align-items-center gap-2">
                        <img src="'.$image.'" width="60" class="rounded border">

                        <a href="'.$demoUrl.'" target="_blank"
                           class="btn btn-sm btn-light-primary">
                           Demo
                        </a>
                    </div>
                ';
            })

            ->addColumn('harga_label', function (TemplateVideo $model) {
                return $model->harga == 0
                    ? '<span class="badge badge-light-success">Gratis</span>'
                    : 'Rp ' . number_format($model->harga, 0, ',', '.');
            })

            ->addIndexColumn()

            ->addColumn('action', function ($model) {
                return view('pages.masters.template_video._action', compact('model'));
            })

            ->rawColumns([
                'preview_image',
                'harga_label',
                'action'
            ]);
    }

    public function query(TemplateVideo $model)
    {
        return $model->newQuery()->with(['jenis', 'kategori']);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('template_video-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->responsive()
            ->autoWidth(false);
    }

    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false),
            Column::make('nama_jenis')->title('Jenis Undangan'),
            Column::make('nama_kategori')->title('Kategori'),
            Column::make('nama_template')->title('Nama Template'),
            Column::make('preview_image')->title('Preview Template'),
            Column::make('harga_label')->title('Harga'),
            Column::computed('action')->title('Aksi')->addClass('text-center'),
        ];
    }
}