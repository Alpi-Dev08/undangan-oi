<?php

namespace Modules\Klinik\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Klinik\Drug;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Satusehat\Integration\Terminology\Kfa;

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
            'user_id' => Auth::id()
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
     * Get products from KFA API for DataTables
     *
     * @param Request $request
     * @return mixed
     */
    public function getProducts(Request $request)
    {
        Log::info('KFA Products DataTable Request', [
            'request' => $request->all(),
            'user_id' => Auth::id()
        ]);

        return app(\App\DataTables\Klinik\KfaProductsDataTable::class)->render($request);
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
            'user_id' => Auth::id()
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
        $kfaProductsDataTable = app(\App\DataTables\Klinik\KfaProductsDataTable::class);
        $kfaSyncedDrugsDataTable = app(\App\DataTables\Klinik\KfaSyncedDrugsDataTable::class);
        
        return view('klinik::kfa.index', compact('kfaProductsDataTable', 'kfaSyncedDrugsDataTable'));
    }

    /**
     * Get drugs with KFA data for DataTables
     *
     * @return mixed
     */
    public function getDrugsWithKfa(Request $request)
    {
        Log::info('Get Drugs with KFA DataTable Request', [
            'request' => $request->all(),
            'user_id' => Auth::id()
        ]);

        return app(\App\DataTables\Klinik\KfaSyncedDrugsDataTable::class)->render($request);
    }

    /**
     * Get drugs for select dropdown
     *
     * @return JsonResponse
     */
    public function getDrugsForSelect(): JsonResponse
    {
        try {
            $drugs = Drug::select(['id', 'name'])
                ->whereNull('kfa_code')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $drugs
            ]);

        } catch (Exception $e) {
            Log::error('Error getting drugs for select', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data obat'
            ], 500);
        }
    }
}
