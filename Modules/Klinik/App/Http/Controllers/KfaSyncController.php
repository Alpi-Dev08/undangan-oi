<?php

namespace Modules\Klinik\App\Http\Controllers;

use App\Models\Klinik\Drug;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Klinik\App\Services\KfaDrugSyncService;

class KfaSyncController extends Controller
{
    protected $syncService;

    public function __construct(KfaDrugSyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    /**
     * Menampilkan halaman sinkronisasi KFA
     */
    public function index()
    {
        $stats = $this->syncService->getSyncStatistics();
        return view('klinik::kfa-sync.index', compact('stats'));
    }

    /**
     * Menjalankan sinkronisasi KFA - Drugs
     */
    public function sync(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'threshold' => 'numeric|min:0|max:100',
                'dry_run' => 'boolean',
                'reset' => 'boolean',
                'limit' => 'integer|min:1|max:1000'
            ]);

            $threshold = $request->input('threshold', 70);
            $dryRun = $request->input('dry_run', false);
            $reset = $request->input('reset', false);
            $limit = $request->input('limit');

            $results = $this->syncService->syncAllDrugs($threshold, $dryRun, $reset, $limit);

            return response()->json([
                'success' => true,
                'data' => $results,
                'message' => 'Sinkronisasi berhasil dilakukan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan statistik sinkronisasi
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->syncService->getSyncStatistics();

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan detail match untuk satu drug
     */
    public function showMatch($drugId): JsonResponse
    {
        try {
            $drug = Drug::findOrFail($drugId);
            $match = $this->syncService->findKfaMatch($drug);

            return response()->json([
                'success' => true,
                'data' => [
                    'drug' => $drug,
                    'match' => $match
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menghapus semua sinkronisasi
     */
    public function reset(): JsonResponse
    {
        try {
            $this->syncService->resetAllSyncs();

            return response()->json([
                'success' => true,
                'message' => 'Semua sinkronisasi berhasil direset'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan daftar drugs yang belum tersinkronisasi
     */
    public function pending(): JsonResponse
    {
        try {
            $pendingDrugs = Drug::query()
                ->whereNull('kfa_code')
                ->orWhere('kfa_code', '')
                ->select(['id', 'name', 'manufacturer', 'created_at'])
                ->orderBy('name')
                ->limit(100)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $pendingDrugs
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan daftar drugs yang sudah tersinkronisasi
     */
    public function synced(): JsonResponse
    {
        try {
            $syncedDrugs = Drug::query()
                ->whereNotNull('kfa_code')
                ->where('kfa_code', '!=', '')
                ->select(['id', 'name', 'kfa_code', 'manufacturer', 'similarity_score', 'last_sync_attempt'])
                ->orderBy('name')
                ->limit(100)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $syncedDrugs
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
