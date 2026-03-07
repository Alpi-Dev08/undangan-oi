<?php

namespace App\DataTables\Masters;

use App\Models\Master\Kategori;
use App\Models\Master\Jenis;
use App\Models\Master\Template;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
 
class TemplateVideoDataTable extends DataTable
{
    /**
     * Build DataTable.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)

            ->addColumn('nama_jenis', function (Template $template) {
                return $template->jenis->nama_jenis ?? '-';
            })

            ->addColumn('nama_kategori', function (Template $template) {
                return $template->kategori->nama_kategori ?? '-';
            })

            ->addColumn('status_label', function (Template $template) {
                return $template->status == 'aktif'
                    ? '<span class="badge badge-light-success">Aktif</span>'
                    : '<span class="badge badge-light-danger">Nonaktif</span>';
            })

            ->filter(function ($query) {
                if (request()->has('search')) {
                    $search = request()->get('search')['value'] ?? null;

                    if ($search) {
                        $query->where('nama_template', 'like', "%{$search}%")
                              ->orWhereHas('jenis', function ($q) use ($search) {
                                  $q->where('nama_jenis', 'like', "%{$search}%");
                              })
                              ->orWhereHas('kategori', function ($q) use ($search) {
                                  $q->where('nama_kategori', 'like', "%{$search}%");
                              });
                    }
                }
            })

            ->addIndexColumn()

            ->addColumn('action', function (Template $model) {
                return view('pages.masters.template_video._action', compact('model'));
            })

            ->rawColumns(['status_label', 'action']);
    }

    /**
     * Query source.
     */
    public function query(Template $model)
    {
        return $model->newQuery()
            ->with(['jenis', 'kategori'])
            ->where('jenis_id', 4)
            ->whereHas('kategori', function ($q) {
                $q->where('jenis_id', 4);
            });

    }

    /**
     * HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('template-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc')
            ->responsive()
            ->autoWidth(false)
            ->parameters([
                'scrollX'      => true,
                'drawCallback' => 'function() { KTMenu.createInstances(); }',
            ])
            ->addTableClass('align-middle table-row-dashed fs-6 gy-5');
    }

    /**
     * Columns.
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
                ->title('Jenis'),

            Column::make('nama_kategori')
                ->title('Kategori'),

            Column::make('preview_image')
                ->title('Preview'),

            Column::make('status_label')
                ->title('Status')
                ->orderable(false)
                ->searchable(false),

            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->responsivePriority(-1),
        ];
    }

    /**
     * Filename export.
     */
    protected function filename(): string
    {
        return 'Template_' . date('YmdHis');
    }
}
