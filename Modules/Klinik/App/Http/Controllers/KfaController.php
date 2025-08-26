<?php

namespace Modules\Klinik\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Satusehat\Integration\Terminology\Kfa;
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
                        'description' => $product->description ?? '',
                        'dosage_form' => $product->dosage_form ?? ''
                    ]
                ]);
            }

            // Jika tidak ada di database, ambil dari API
            Log::info('Fetching product detail from KFA API', [
                'kfa_code' => $kfaCode
            ]);

            $kfa = new Kfa();
            $apiProduct = $kfa->get_by_id($kfaCode, 'farmasi');

            Log::info('KFA API Response', [
                'kfa_code' => $kfaCode,
                'response' => $apiProduct
            ]);

            if ($apiProduct) {
                // Convert to array if it's an object
                $productData = is_object($apiProduct) ? (array) $apiProduct : $apiProduct;

                // Simpan ke database
                $product = KfaProduct::updateOrCreate(
                    ['kfa_code' => (string) $kfaCode],
                    [
                        'name' => (string) ($productData['name'] ?? $productData['name'] ?? ''),
                        'manufacturer' => (string) ($productData['manufacturer'] ?? $productData['manufacturer'] ?? ''),
                        'product_type' => 'farmasi',
                        'dosage_form'         => isset($productData['dosage_form']) ? (is_array($productData['dosage_form']) ? implode(', ', $productData['dosage_form']) : (is_object($productData['dosage_form']) ? json_encode($productData['dosage_form']) : (string) $productData['dosage_form'])) : null,
                        'strength'            => isset($productData['strength']) ? (is_object($productData['strength']) ? (string) $productData['strength'] : (string) $productData['strength']) : null,
                        'unit'                => isset($productData['unit']) ? (is_object($productData['unit']) ? (string) $productData['unit'] : (string) $productData['unit']) : null,
                        'packaging'           => isset($productData['packaging']) ? (is_object($productData['packaging']) ? (string) $productData['packaging'] : (string) $productData['packaging']) : null,
                        'fix_price' => isset($productData['fix_price']) ? (float) $productData['fix_price'] : null,
                        'het_price' => isset($productData['het_price']) ? (float) $productData['het_price'] : null,
                        'registration_number' => isset($productData['registration_number']) ? (is_object($productData['registration_number']) ? (string) $productData['registration_number'] : (string) $productData['registration_number']) : null,
                        'registration_date'   => isset($productData['registration_date']) ? (is_object($productData['registration_date']) ? (string) $productData['registration_date'] : (string) $productData['registration_date']) : null,
                        'expiry_date'         => isset($productData['expiry_date']) ? (is_object($productData['expiry_date']) ? (string) $productData['expiry_date'] : (string) $productData['expiry_date']) : null,
                        'description'         => isset($productData['description']) ? (is_object($productData['description']) ? (string) $productData['description'] : (string) $productData['description']) : null,
                        'raw_data' => json_encode($productData),
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

            // Cari data di database terlebih dahulu
            $products = KfaProduct::byProductType($productType)
                ->search($keyword)
                ->orderBy('name')
                ->get();

            // Jika tidak ada data di database, ambil dari API
            if ($products->isEmpty()) {
                Log::info('No data found in database, fetching from KFA API', [
                    'product_type' => $productType,
                    'keyword' => $keyword
                ]);

                // Ambil data dari API
                $kfa = new Kfa();
                $searchKeyword = $keyword ?? 'asam'; // Default keyword untuk menampilkan semua produk
                $apiResponse = $kfa->getProducts($productType, $searchKeyword, 1, 1000);


                $apiProducts = [];
                if ($apiResponse[0] == '200') {
                    $responseData = $apiResponse[1];
                    if (is_object($responseData) && isset($responseData->items)) {
                        $apiProducts = $responseData->items->data;
                    } elseif (is_array($responseData) && isset($responseData['items'])) {
                        $apiProducts = $responseData['items']['data'];
                    }
                }

                if (!empty($apiProducts)) {
                    // Simpan data ke database dengan transaction
                    DB::transaction(function () use ($apiProducts, $productType) {
                        foreach ($apiProducts as $product) {
                            $productData = is_object($product) ? (array) $product : $product;
                            KfaProduct::updateOrCreate(
                                ['kfa_code' => (string) ($productData['kfa_code'] ?? $productData['code'] ?? '')],
                                [
                                    'name'                => (string) ($productData['name'] ?? ''),
                                    'manufacturer'        => (string) ($productData['manufacturer'] ?? ''),
                                    'product_type'        => $productType,
                                    'dosage_form'         => isset($productData['dosage_form']) ? (is_array($productData['dosage_form']) ? implode(', ', $productData['dosage_form']) : (is_object($productData['dosage_form']) ? json_encode($productData['dosage_form']) : (string) $productData['dosage_form'])) : null,
                                    'strength'            => isset($productData['strength']) ? (is_object($productData['strength']) ? (string) $productData['strength'] : (string) $productData['strength']) : null,
                                    'unit'                => isset($productData['unit']) ? (is_object($productData['unit']) ? (string) $productData['unit'] : (string) $productData['unit']) : null,
                                    'packaging'           => isset($productData['packaging']) ? (is_object($productData['packaging']) ? (string) $productData['packaging'] : (string) $productData['packaging']) : null,
                                    'fix_price'           => isset($productData['fix_price']) ? (float) $productData['fix_price'] : null,
                                    'het_price'           => isset($productData['het_price']) ? (float) $productData['het_price'] : null,
                                    'registration_number' => isset($productData['registration_number']) ? (is_object($productData['registration_number']) ? (string) $productData['registration_number'] : (string) $productData['registration_number']) : null,
                                    'registration_date'   => isset($productData['registration_date']) ? (is_object($productData['registration_date']) ? (string) $productData['registration_date'] : (string) $productData['registration_date']) : null,
                                    'expiry_date'         => isset($productData['expiry_date']) ? (is_object($productData['expiry_date']) ? (string) $productData['expiry_date'] : (string) $productData['expiry_date']) : null,
                                    'description'         => isset($productData['description']) ? (is_object($productData['description']) ? (string) $productData['description'] : (string) $productData['description']) : null,
                                    'raw_data'            => json_encode($productData),
                                    'last_sync'           => now()
                                ]
                            );
                        }
                    });

                    // Ambil data yang baru disimpan
                    $products = KfaProduct::byProductType($productType)
                        ->search($keyword)
                        ->orderBy('name')
                        ->get();
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
