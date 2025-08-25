<?php

namespace Modules\Klinik\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Modules\Klinik\App\Services\Kfa;
use Modules\Klinik\Models\KfaProduct;

class KfaController extends Controller
{
    /**
     * Display KFA products listing page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('klinik::kfa.index');
    }

    /**
     * Get single product detail from database with fallback to KFA API
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProductDetail(Request $request): JsonResponse
    {
        Log::info('KFA Product Detail Request', [
            'request' => $request->all(),
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'kfa_code' => 'required|string'
        ]);

        $kfaCode = $request->kfa_code;

        try {
            // Coba ambil dari database dulu
            $product = KfaProduct::where('kfa_code', $kfaCode)->first();

            if ($product) {
                Log::info('Serving product detail from database', [
                    'kfa_code' => $kfaCode,
                    'last_sync' => $product->last_sync
                ]);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'kfa_code' => $product->kfa_code,
                        'name' => $product->name,
                        'manufacturer' => $product->manufacturer,
                        'manufacturer_country' => '',
                        'fix_price' => $product->fix_price ?? 0,
                        'het_price' => $product->het_price ?? 0,
                        'packaging' => $product->packaging ?? '',
                        'dosage_form' => $product->dosage_form ?? '',
                        'strength' => $product->strength ?? '',
                        'unit' => $product->unit ?? '',
                        'registration_number' => $product->registration_number ?? '',
                        'registration_date' => $product->registration_date ?? '',
                        'expiry_date' => $product->expiry_date ?? '',
                        'description' => $product->description ?? ''
                    ]
                ]);
            }

            // Jika tidak ada di database, ambil dari API
            Log::info('Fetching product detail from KFA API', [
                'kfa_code' => $kfaCode
            ]);

            $kfa = new Kfa();
            $apiProduct = $kfa->getProductDetail($kfaCode);

            Log::info('KFA API Response', [
                'kfa_code' => $kfaCode,
                'response' => $apiProduct
            ]);

            if ($apiProduct) {
                
                // Simpan ke database
                $product = KfaProduct::updateOrCreate(
                    ['kfa_code' => $kfaCode],
                    [
                        'name' => $apiProduct['name'] ?? '',
                        'manufacturer' => $apiProduct['manufacturer'] ?? '',
                        'product_type' => 'farmasi',
                        'dosage_form' => $apiProduct['dosage_form'] ?? null,
                        'strength' => $apiProduct['strength'] ?? null,
                        'unit' => $apiProduct['unit'] ?? null,
                        'packaging' => $apiProduct['packaging'] ?? null,
                        'fix_price' => $apiProduct['fix_price'] ?? null,
                        'het_price' => $apiProduct['het_price'] ?? null,
                        'registration_number' => $apiProduct['registration_number'] ?? null,
                        'registration_date' => $apiProduct['registration_date'] ?? null,
                        'expiry_date' => $apiProduct['expiry_date'] ?? null,
                        'description' => $apiProduct['description'] ?? null,
                        'raw_data' => json_encode($apiProduct),
                        'last_sync' => now()
                    ]
                );

                Log::info('Product detail saved to database', [
                    'kfa_code' => $kfaCode
                ]);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'kfa_code' => $product->kfa_code,
                        'name' => $product->name,
                        'manufacturer' => $product->manufacturer,
                        'manufacturer_country' => $apiProduct['manufacturer_country'] ?? '',
                        'fix_price' => $product->fix_price ?? 0,
                        'het_price' => $product->het_price ?? 0,
                        'packaging' => $product->packaging ?? '',
                        'dosage_form' => $product->dosage_form ?? '',
                        'strength' => $product->strength ?? '',
                        'unit' => $product->unit ?? '',
                        'registration_number' => $product->registration_number ?? '',
                        'registration_date' => $product->registration_date ?? '',
                        'expiry_date' => $product->expiry_date ?? '',
                        'description' => $product->description ?? ''
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ]);

        } catch (Exception $e) {
            Log::error('KFA API Error', [
                'error' => $e->getMessage(),
                'kfa_code' => $kfaCode,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari KFA',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get products list from KFA API with database caching
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProducts(Request $request): JsonResponse
    {
        Log::info('KFA Products List Request', [
            'request' => $request->all(),
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'product_type' => 'required|string|in:farmasi,alkes',
            'keyword' => 'nullable|string|min:1'
        ]);

        try {
            $productType = $request->product_type;
            $keyword = $request->keyword;

            // Cek apakah ada data yang perlu diupdate (lebih dari 1 minggu)
            $needsUpdate = KfaProduct::byProductType($productType)
                ->where('last_sync', '<', now()->subWeek())
                ->exists();

            // Jika ada data yang perlu diupdate atau belum ada data sama sekali
            if ($needsUpdate || KfaProduct::byProductType($productType)->count() === 0) {
                Log::info('Fetching fresh data from KFA API', [
                    'product_type' => $productType,
                    'keyword' => $keyword,
                    'needs_update' => $needsUpdate
                ]);

                // Ambil data dari API
                $kfa = new Kfa();
                $searchKeyword = $keyword ?? 'a'; // Default keyword untuk menampilkan semua produk
                $products = $kfa->searchProducts($searchKeyword, $productType, 1000);

                if (is_array($products) && count($products) > 0) {
                    // Simpan data ke database dengan transaction
                    DB::transaction(function () use ($products, $productType) {
                        foreach ($products as $product) {
                            $product = (array) $product;
                            KfaProduct::updateOrCreate(
                                ['kfa_code' => $product['kfa_code']],
                                [
                                    'name' => $product['name'] ?? '',
                                    'manufacturer' => $product['manufacturer'] ?? '',
                                    'product_type' => $productType,
                                    'dosage_form' => $product['dosage_form'] ?? null,
                                    'strength' => $product['strength'] ?? null,
                                    'unit' => $product['unit'] ?? null,
                                    'packaging' => $product['packaging'] ?? null,
                                    'fix_price' => $product['fix_price'] ?? null,
                                    'het_price' => $product['het_price'] ?? null,
                                    'registration_number' => $product['registration_number'] ?? null,
                                    'registration_date' => $product['registration_date'] ?? null,
                                    'expiry_date' => $product['expiry_date'] ?? null,
                                    'description' => $product['description'] ?? null,
                                    'raw_data' => json_encode($product),
                                    'last_sync' => now()
                                ]
                            );
                        }
                    });
                }
            }

            // Ambil data dari database
            $products = KfaProduct::byProductType($productType)
                ->search($keyword)
                ->orderBy('name')
                ->get();

            Log::info('Serving products from database', [
                'product_type' => $productType,
                'keyword' => $keyword,
                'count' => $products->count()
            ]);

            $data = $products->map(function ($product, $index) {
                return [
                    'DT_RowIndex' => $index + 1,
                    'kfa_code' => $product->kfa_code,
                    'name' => $product->name,
                    'manufacturer' => $product->manufacturer,
                    'fix_price' => $product->fix_price ? 'Rp ' . number_format($product->fix_price, 0, ',', '.') : '-',
                    'het_price' => $product->het_price ? 'Rp ' . number_format($product->het_price, 0, ',', '.') : '-',
                    'action' => '<button class="btn btn-sm btn-info" onclick="viewKfaDetail(\'' . $product->kfa_code . '\')">Lihat Detail</button>'
                ];
            })->toArray();

            return response()->json([
                'data' => $data,
                'recordsTotal' => count($data),
                'recordsFiltered' => count($data)
            ]);

        } catch (Exception $e) {
            Log::error('KFA Products Error', [
                'error' => $e->getMessage(),
                'product_type' => $request->product_type,
                'keyword' => $request->keyword,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Gagal mengambil data produk',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
