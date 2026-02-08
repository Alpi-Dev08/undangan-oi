<?php

namespace App\DataTables\Masters;

use App\Models\Master\Kategori;
use App\Models\Master\Jenis;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
 
class KategoriWebsiteDataTable extends DataTable
{
    /**
     * Build DataTable.
     */
    public function dataTable($query)
    {
        return datatables()
        ->eloquent($query)

        ->addColumn('nama_jenis', function (Kategori $kategori) {
            return $kategori->jenis->nama_jenis ?? '-';
        })

        ->filter(function ($query) {
            if (request()->has('search')) {
                $search = request()->get('search')['value'] ?? null;

                if ($search) {
                    $query->where('nama_kategori', 'like', "%{$search}%")
                          ->orWhereHas('jenis', function ($q) use ($search) {
                              $q->where('nama_jenis', 'like', "%{$search}%");
                          });
                }
            }
        })

        ->addIndexColumn()
        ->addColumn('action', function (Kategori $model) {
            return view('pages.masters.kategori_web._action', compact('model'));
        })
        ->rawColumns(['action']);
    }

    /**
     * Query source.
     */
    public function query(Kategori $model)
    {
        return $model->newQuery()
        ->with('jenis')
        ->where('jenis_id', 3); 
    }

    /**
     * HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('kategori-table')
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

            Column::make('nama_jenis')
                ->title('Jenis Undangan'),

            Column::make('nama_kategori')
                ->title('Nama Kategori'),

            Column::make('deskripsi')
                ->title('Deskripsi'),

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
        return 'Kategori_' . date('YmdHis');
    }
}
