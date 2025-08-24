<?php

namespace Modules\Klinik\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Klinik\Drug;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Satusehat\Integration\Terminology\Kfa;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KfaController extends Controller
{
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
            'user_id' => auth()->id() ?? null
        ]);

        $request->validate([
            'identifier' => 'required|string|in:kfa,lkpp,nie',
            'code' => 'required|string'
        ]);

        try {
            $kfa = new Kfa();
            $response = $kfa->getProduct($request->identifier, $request->code);

            Log::info('KFA API Response', [
                'identifier' => $request->identifier,
                'code' => $request->code,
                'response' => $response
            ]);

            return response()->json([
                'search_code' => $request->code,
                'search_identifier' => $request->identifier,
                'result' => $response
            ]);

        } catch (\Exception $e) {
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
     * Get paginated products from KFA API
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProducts(Request $request): JsonResponse
    {
        Log::info('KFA Products Request', [
            'request' => $request->all(),
            'user_id' => auth()->id() ?? null
        ]);

        $request->validate([
            'product_type' => 'required|string|in:alkes,farmasi',
            'keyword' => 'nullable|string',
            'page' => 'integer|min:1',
            'size' => 'integer|min:1|max:1000'
        ]);

        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        try {
            $kfa = new Kfa();
            $response = $kfa->getProducts(
                $request->product_type,
                $request->keyword,
                $page,
                $size
            );

            Log::info('KFA Products Response', [
                'product_type' => $request->product_type,
                'keyword' => $request->keyword,
                'page' => $page,
                'size' => $size,
                'total' => $response['total'] ?? 0
            ]);

            return response()->json([
                'total' => $response['total'] ?? 0,
                'page' => $page,
                'size' => $size,
                'items' => [
                    'data' => $response['entry'] ?? []
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('KFA Products API Error', [
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

    /**
     * Sync drug with KFA data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function syncDrugWithKfa(Request $request): JsonResponse
    {
        Log::info('Sync Drug with KFA Request', [
            'request' => $request->all(),
            'user_id' => auth()->id() ?? null
        ]);

        $request->validate([
            'drug_id' => 'required|exists:drugs,id',
            'kfa_code' => 'required|string',
            'identifier' => 'required|string|in:kfa,lkpp,nie'
        ]);

        DB::beginTransaction();

        try {
            $drug = Drug::findOrFail($request->drug_id);

            // Get KFA data
            $kfa = new Kfa();
            $kfaData = $kfa->getProduct($request->identifier, $request->kfa_code);

            // Update drug with KFA data
            $drug->update([
                'kfa_code' => $request->kfa_code,
                'kfa_data' => json_encode($kfaData),
                'name' => $kfaData['product_name'] ?? $drug->name,
                'price' => $kfaData['price'] ?? $drug->price
            ]);

            DB::commit();

            Log::info('Drug synced with KFA', [
                'drug_id' => $drug->id,
                'kfa_code' => $request->kfa_code,
                'identifier' => $request->identifier
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Obat berhasil disinkronisasi dengan data KFA',
                'data' => $drug->fresh()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Sync Drug with KFA Error', [
                'error' => $e->getMessage(),
                'drug_id' => $request->drug_id,
                'kfa_code' => $request->kfa_code
            ]);

            return response()->json([
                'error' => 'Gagal menyinkronisasi obat dengan KFA',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display KFA integration interface
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('klinik::kfa.index');
    }

    /**
     * Get drugs with KFA data
     *
     * @return JsonResponse
     */
    public function getDrugsWithKfa(): JsonResponse
    {
        Log::info('Get Drugs with KFA Data', [
            'user_id' => auth()->id() ?? null
        ]);

        try {
            $drugs = Drug::whereNotNull('kfa_code')
                ->select(['id', 'name', 'kfa_code', 'price', 'stock', 'kfa_data'])
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $drugs
            ]);

        } catch (\Exception $e) {
            Log::error('Get Drugs with KFA Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Gagal mengambil data obat dengan KFA',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
