<?php

namespace Modules\Klinik\App\Services;

use App\Models\Klinik\Drug;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Klinik\Models\KfaProduct;

class KfaDrugSyncService
{
    protected $similarityService;
    protected $defaultThreshold = 70;

    public function __construct(StringSimilarityService $similarityService)
    {
        $this->similarityService = $similarityService;
    }

    /**
     * Sinkronisasi semua drugs dengan data KFA
     */
    public function syncAllDrugs(int $threshold = null, int $limit = null): array
    {
        $threshold = $threshold ?? $this->defaultThreshold;
        
        $results = [
            'total_drugs' => 0,
            'matched_drugs' => 0,
            'new_matches' => 0,
            'updated_matches' => 0,
            'failed_matches' => 0,
            'threshold' => $threshold,
            'details' => []
        ];

        DB::transaction(function () use (&$results, $threshold, $limit) {
            $query = Drug::query()
                ->where(function ($q) {
                    $q->whereNull('kfa_code')
                      ->orWhere('last_sync_attempt', '<', now()->subDays(7));
                });

            if ($limit) {
                $query->limit($limit);
            }

            $drugs = $query->get();
            $results['total_drugs'] = $drugs->count();

            foreach ($drugs as $drug) {
                try {
                    $matchResult = $this->findKfaMatch($drug, $threshold);
                    
                    if ($matchResult['success']) {
                        $results['matched_drugs']++;
                        
                        if ($drug->kfa_code !== $matchResult['kfa_code']) {
                            $results['new_matches']++;
                        } else {
                            $results['updated_matches']++;
                        }

                        $this->updateDrugWithMatch($drug, $matchResult);
                        
                        $results['details'][] = [
                            'drug_name' => $drug->name,
                            'kfa_name' => $matchResult['kfa_name'],
                            'manufacturer' => $matchResult['manufacturer'],
                            'similarity_score' => $matchResult['similarity_score'],
                            'status' => 'success'
                        ];
                    } else {
                        $results['failed_matches']++;
                        $this->markSyncAttempt($drug);
                        
                        $results['details'][] = [
                            'drug_name' => $drug->name,
                            'status' => 'failed',
                            'reason' => $matchResult['reason'] ?? 'No suitable match found'
                        ];
                    }
                } catch (\Exception $e) {
                    Log::error('KFA sync error for drug: ' . $drug->name, [
                        'error' => $e->getMessage(),
                        'drug_id' => $drug->id,
                        'threshold' => $threshold
                    ]);
                    
                    $results['failed_matches']++;
                    $results['details'][] = [
                        'drug_name' => $drug->name,
                        'status' => 'error',
                        'reason' => $e->getMessage()
                    ];
                }
            }
        });

        return $results;
    }

    /**
     * Mencari kecocokan KFA untuk satu drug
     */
    public function findKfaMatch(Drug $drug, int $threshold = null): array
    {
        $threshold = $threshold ?? $this->defaultThreshold;
        
        // Gunakan query yang lebih efisien dengan membatasi jumlah data
        $kfaProducts = KfaProduct::query()
            ->where('product_type', 'farmasi')
            ->when(strlen($drug->name) > 3, function ($query) use ($drug) {
                $query->where(function ($q) use ($drug) {
                    $q->where('name', 'like', '%' . $drug->name . '%')
                      ->orWhere('name', 'like', '%' . $this->similarityService->normalizeString($drug->name) . '%');
                });
            })
            ->limit(20) // Kurangi dari 100 menjadi 20 untuk menghemat memory
            ->get();

        if ($kfaProducts->isEmpty()) {
            return [
                'success' => false,
                'reason' => 'No KFA products found for name: ' . $drug->name
            ];
        }

        $matches = [];
        
        foreach ($kfaProducts as $kfaProduct) {
            $score = $this->calculateSimilarity($drug, $kfaProduct);
            
            if ($score >= $threshold) {
                $matches[] = [
                    'kfa_product' => $kfaProduct,
                    'score' => $score
                ];
            }
        }

        if (empty($matches)) {
            return [
                'success' => false,
                'reason' => 'No match above threshold (' . $threshold . '%)',
                'best_score' => collect($kfaProducts)->isEmpty() ? 0 : 
                    $this->calculateSimilarity($drug, $kfaProducts->first())
            ];
        }

        // Urutkan berdasarkan score tertinggi
        usort($matches, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $bestMatch = $matches[0];

        return [
            'success' => true,
            'kfa_code' => $bestMatch['kfa_product']->kfa_code,
            'kfa_name' => $bestMatch['kfa_product']->name,
            'manufacturer' => $bestMatch['kfa_product']->manufacturer,
            'similarity_score' => $bestMatch['score'],
            'kfa_product' => $bestMatch['kfa_product'],
            'total_candidates' => count($matches)
        ];
    }

    /**
     * Menghitung similarity score antara drug dan KFA product
     */
    private function calculateSimilarity(Drug $drug, KfaProduct $kfaProduct): float
    {
        // Hitung similarity untuk nama obat
        $nameSimilarity = $this->similarityService->calculateCombinedScore(
            $drug->name,
            $kfaProduct->name
        );

        // Hitung similarity untuk manufacturer
        $manufacturerSimilarity = 0;
        if (!empty($drug->manufacturer) && !empty($kfaProduct->manufacturer)) {
            $manufacturerSimilarity = $this->similarityService->calculateCombinedScore(
                $drug->manufacturer,
                $kfaProduct->manufacturer
            );
        } elseif (empty($drug->manufacturer) && empty($kfaProduct->manufacturer)) {
            // Jika keduanya kosong, beri score 100 untuk manufacturer
            $manufacturerSimilarity = 100;
        }

        // Bobot: 80% untuk nama, 20% untuk manufacturer
        $finalScore = ($nameSimilarity * 0.8) + ($manufacturerSimilarity * 0.2);

        return round($finalScore, 2);
    }

    /**
     * Mendapatkan statistik sinkronisasi
     */
    public function getSyncStatistics(): array
    {
        $totalDrugs = Drug::count();
        $syncedDrugs = Drug::whereNotNull('kfa_code')->count();
        $pendingDrugs = Drug::whereNull('kfa_code')->count();
        $recentlySynced = Drug::where('last_sync_attempt', '>', now()->subDay())->count();

        return [
            'total_drugs' => $totalDrugs,
            'synced_drugs' => $syncedDrugs,
            'pending_drugs' => $pendingDrugs,
            'recently_synced' => $recentlySynced,
            'sync_percentage' => $totalDrugs > 0 ? round(($syncedDrugs / $totalDrugs) * 100, 2) : 0
        ];
    }

    /**
     * Mencari produk KFA berdasarkan nama untuk modal popup
     *
     * @param string $drugName
     * @param int $limit
     * @return array
     */
    public function searchKfaProducts(string $drugName, int $limit = 10): array
    {
        try {
            $kfaProducts = KfaProduct::query()
                ->where('product_type', 'farmasi')
                ->where(function ($query) use ($drugName) {
                    $query->where('name', 'like', '%' . $drugName . '%')
                          ->orWhere('name', 'like', '%' . $this->similarityService->normalizeString($drugName) . '%');
                })
                ->orderBy('name')
                ->limit($limit)
                ->get();

            $results = [];
            foreach ($kfaProducts as $product) {
                $results[] = [
                    'kfa_code' => $product->kfa_code,
                    'name' => $product->name,
                    'manufacturer' => $product->manufacturer,
                    'strength' => $product->strength,
                    'form' => $product->form,
                    'unit' => $product->unit,
                    'packaging' => $product->packaging,
                    'price' => $product->price,
                    'similarity_score' => $this->similarityService->calculateCombinedScore(
                        $drugName,
                        $product->name
                    )
                ];
            }

            return $results;

        } catch (\Exception $e) {
            Log::error('Error saat mencari produk KFA', [
                'drug_name' => $drugName,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Mendapatkan drugs yang belum tersinkronisasi
     */
    public function getPendingDrugs(int $limit = 50): \Illuminate\Support\Collection
    {
        return Drug::whereNull('kfa_code')
            ->orderBy('name')
            ->limit($limit)
            ->get(['id', 'name', 'manufacturer', 'created_at']);
    }

    /**
     * Mendapatkan drugs yang sudah tersinkronisasi
     */
    public function getSyncedDrugs(int $limit = 50): \Illuminate\Support\Collection
    {
        return Drug::whereNotNull('kfa_code')
            ->with(['kfaProduct' => function ($query) {
                $query->select('kfa_code', 'name', 'manufacturer');
            }])
            ->orderBy('last_sync_attempt', 'desc')
            ->limit($limit)
            ->get(['id', 'name', 'manufacturer', 'kfa_code', 'similarity_score', 'last_sync_attempt']);
    }

    /**
     * Reset semua sinkronisasi
     */
    public function resetAllSyncs(): int
    {
        return Drug::whereNotNull('kfa_code')
            ->update([
                'kfa_code' => null,
                'similarity_score' => null,
                'matching_metadata' => null,
                'last_sync_attempt' => null
            ]);
    }

    /**
     * Menandai sync attempt untuk drug
     */
    private function markSyncAttempt(Drug $drug): void
    {
        $drug->update([
            'last_sync_attempt' => now()
        ]);
    }

    /**
     * Update drug dengan hasil match dari KFA
     */
    private function updateDrugWithMatch(Drug $drug, array $matchResult): void
    {
        $drug->update([
            'kfa_code' => $matchResult['kfa_code'],
            'similarity_score' => $matchResult['similarity_score'],
            'matching_metadata' => json_encode([
                'kfa_name' => $matchResult['kfa_name'],
                'manufacturer' => $matchResult['manufacturer'],
                'matched_at' => now()->toDateTimeString()
            ]),
            'last_sync_attempt' => now()
        ]);
    }

    /**
     * Batch update dari data KFA
     */
    public function batchUpdateFromKfa(array $kfaCodes): array
    {
        $results = ['updated' => 0, 'not_found' => 0, 'errors' => []];

        foreach ($kfaCodes as $kfaCode) {
            try {
                $kfaProduct = KfaProduct::where('kfa_code', $kfaCode)->first();
                
                if (!$kfaProduct) {
                    $results['not_found']++;
                    continue;
                }

                $drug = Drug::where('name', 'like', '%' . $kfaProduct->name . '%')->first();
                
                if ($drug) {
                    $drug->update([
                        'kfa_code' => $kfaProduct->kfa_code,
                        'manufacturer' => $kfaProduct->manufacturer,
                        'similarity_score' => 100,
                        'matching_metadata' => [
                            'sync_method' => 'batch_update',
                            'kfa_data' => $kfaProduct->toArray()
                        ],
                        'last_sync_attempt' => now()
                    ]);
                    
                    $results['updated']++;
                }
            } catch (\Exception $e) {
                $results['errors'][$kfaCode] = $e->getMessage();
            }
        }

        return $results;
    }
}