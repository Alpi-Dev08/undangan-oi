<?php

namespace Modules\Klinik\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Satusehat\Integration\Terminology\Kfa;

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
     * Get single product detail from KFA API
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

        try {
            $kfa = new Kfa();
            $response = $kfa->getProduct('kfa', $request->kfa_code);

            Log::info('KFA API Response', [
                'kfa_code' => $request->kfa_code,
                'response' => $response
            ]);

            if (is_array($response) && isset($response[1])) {
                $product = (array) $response[1];
                return response()->json([
                    'success' => true,
                    'data' => [
                        'kfa_code' => $product['kfa_code'] ?? '',
                        'name' => $product['name'] ?? '',
                        'manufacturer' => $product['manufacturer'] ?? '',
                        'manufacturer_country' => $product['manufacturer_country'] ?? '',
                        'fix_price' => $product['fix_price'] ?? 0,
                        'het_price' => $product['het_price'] ?? 0,
                        'packaging' => $product['packaging'] ?? '',
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
                'identifier' => $request->identifier,
                'code' => $request->code
            ]);

            return response()->json([
                'error' => 'Gagal mengambil data dari KFA',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get products list from KFA API
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
            'keyword' => 'required|string|min:3'
        ]);

        try {
            $kfa = new Kfa();
            
            // Get products based on type and keyword
            $response = $kfa->getProducts($request->product_type, $request->keyword, 1, 1000);

            Log::info('KFA API Products Response', [
                'product_type' => $request->product_type,
                'keyword' => $request->keyword,
                'count' => count($response['data'] ?? [])
            ]);

            if (is_array($response) && isset($response[1]->items->data)) {
                $data = collect($response[1]->items->data)->map(function ($item, $index) {
                    return [
                        'DT_RowIndex' => $index + 1,
                        'kfa_code' => $item->kfa_code ?? '',
                        'name' => $item->name ?? '',
                        'manufacturer' => $item->manufacturer ?? '',
                        'fix_price' => $item->fix_price ? 'Rp ' . number_format($item->fix_price, 0, ',', '.') : '-',
                        'het_price' => $item->het_price ? 'Rp ' . number_format($item->het_price, 0, ',', '.') : '-',
                        'action' => '<button class="btn btn-sm btn-info" onclick="viewKfaDetail(\'' . ($item->kfa_code ?? '') . '\')">Lihat Detail</button>'
                    ];
                })->toArray();
                
                return response()->json([
                    'data' => $data,
                    'recordsTotal' => $response[1]->items->total ?? count($data),
                    'recordsFiltered' => $response[1]->items->total ?? count($data)
                ]);
            }
            
            return response()->json([
                'data' => [],
                'recordsTotal' => 0,
                'recordsFiltered' => 0
            ]);

        } catch (Exception $e) {
            Log::error('KFA API Products Error', [
                'error' => $e->getMessage(),
                'product_type' => $request->product_type,
                'keyword' => $request->keyword
            ]);

            return response()->json([
                'error' => 'Gagal mengambil data produk dari KFA',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}