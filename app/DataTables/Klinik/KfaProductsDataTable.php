<?php

namespace App\DataTables\Klinik;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Satusehat\Integration\Terminology\Kfa;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KfaProductsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->collection($query)
            ->addIndexColumn()
            ->addColumn('action', function ($product) {
                return '<button class="btn btn-sm btn-primary" onclick="viewKfaDetail(\'' . ($product['kfa_code'] ?? '') . '\')">Lihat Detail</button>';
            })
            ->editColumn('fix_price', function ($product) {
                return isset($product['fix_price']) ? 'Rp ' . number_format($product['fix_price'], 0, ',', '.') : '-';
            })
            ->editColumn('het_price', function ($product) {
                return isset($product['het_price']) ? 'Rp ' . number_format($product['het_price'], 0, ',', '.') : '-';
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $productType = request('product_type', 'farmasi');
        $keyword = request('keyword', '');
        
        $cacheKey = "kfa_products_{$productType}_{$keyword}_" . md5($productType . $keyword);
        
        $products = Cache::remember($cacheKey, 300, function () use ($productType, $keyword) {
            $kfa = new Kfa();
            $searchKeyword = $keyword ?: 'a'; // Default keyword untuk menampilkan semua produk
            $products = $kfa->getProducts($searchKeyword, $productType, 1000);
            
            return collect($products)->map(function ($item) {
                return (array) $item;
            })->toArray();
        });
        
        return collect($products);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('kfa-products-table')
            ->columns($this->getColumns())
            ->minifiedAjax('', null, [
                'product_type' => '$("#productType").val()',
                'keyword' => '$("#keyword").val()'
            ])
            ->dom('Bfrtip')
            ->orderBy(1)
            ->responsive()
            ->autoWidth(true)
            ->parameters([
                'scrollX' => true,
                'processing' => true,
                'serverSide' => false,
                'searching' => true,
                'lengthChange' => true,
                'pageLength' => 10,
                'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, "All"]]
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
            Column::make('kfa_code')->title('Kode KFA'),
            Column::make('name')->title('Nama Produk'),
            Column::make('manufacturer')->title('Produsen'),
            Column::make('fix_price')->title('Harga Fix'),
            Column::make('het_price')->title('HET'),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->responsivePriority(-1),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'KfaProducts_' . date('YmdHis');
    }
}