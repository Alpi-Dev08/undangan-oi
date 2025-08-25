<?php

namespace Modules\Klinik\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Klinik\App\Services\KfaDrugSyncService;

class SyncKfaDrugsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'klinik:sync-kfa-drugs
                        {--dry-run : Jalankan simulasi tanpa menyimpan perubahan}
                        {--reset : Reset semua sinkronisasi sebelum mulai}
                        {--threshold=70 : Set threshold similarity score}
                        {--drug= : Sinkronisasi satu drug berdasarkan ID}
                        {--limit= : Batasi jumlah drug yang diproses}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data drugs dengan KFA menggunakan fuzzy string matching';

    /**
     * Execute the console command.
     */
    public function handle(KfaDrugSyncService $syncService)
    {
        $this->info('🔄 Memulai sinkronisasi KFA - Drugs');
        
        $threshold = (int) $this->option('threshold');
        $limit = $this->option('limit') ? (int) $this->option('limit') : null;
        
        // Tampilkan statistik awal
        $stats = $syncService->getSyncStatistics();
        $this->table(['Metrik', 'Jumlah'], [
            ['Total Drugs', $stats['total_drugs']],
            ['Sudah Sync', $stats['synced_drugs']],
            ['Belum Sync', $stats['pending_drugs']],
            ['Persentase Sync', $stats['sync_percentage'] . '%'],
        ]);

        if ($this->option('reset')) {
            $this->warn('⚠️  Reset semua sinkronisasi...');
            $resetCount = $syncService->resetAllSyncs();
            $this->info("✅ Reset selesai: {$resetCount} drugs direset");
        }

        if ($this->option('drug')) {
            return $this->syncSingleDrug($syncService, $threshold);
        }

        // Mode dry-run
        if ($this->option('dry-run')) {
            $this->warn('🧪 Mode dry-run - Tidak ada perubahan yang disimpan');
        }

        $this->info("🚀 Memulai proses sinkronisasi dengan threshold: {$threshold}%");
        $startTime = microtime(true);

        $results = $syncService->syncAllDrugs($threshold, $limit);

        $duration = round(microtime(true) - $startTime, 2);

        $this->newLine();
        $this->info('✅ Sinkronisasi selesai!');
        
        // Tampilkan hasil
        $this->table(['Hasil', 'Jumlah'], [
            ['Total Drugs Diproses', $results['total_drugs']],
            ['Drugs Berhasil Match', $results['matched_drugs']],
            ['Match Baru', $results['new_matches']],
            ['Match Diperbarui', $results['updated_matches']],
            ['Match Gagal', $results['failed_matches']],
            ['Durasi (detik)', $duration],
        ]);

        // Tampilkan detail untuk match yang gagal
        if ($results['failed_matches'] > 0) {
            $this->newLine();
            $this->warn('⚠️  Drugs yang gagal di-match:');
            
            $failedDetails = collect($results['details'])
                ->where('status', 'failed')
                ->take(10)
                ->map(function ($detail) {
                    return [$detail['drug_name'], $detail['reason']];
                })->toArray();

            if (!empty($failedDetails)) {
                $this->table(['Nama Drug', 'Alasan'], $failedDetails);
            }
        }

        // Tampilkan detail untuk match yang sukses
        $successfulMatches = collect($results['details'])
            ->where('status', 'success')
            ->take(10)
            ->map(function ($detail) {
                return [
                    $detail['drug_name'],
                    $detail['kfa_name'],
                    $detail['manufacturer'],
                    $detail['similarity_score'] . '%'
                ];
            })->toArray();

        if (!empty($successfulMatches)) {
            $this->newLine();
            $this->info('✅ Contoh match yang sukses:');
            $this->table(['Drug', 'KFA', 'Manufacturer', 'Score'], $successfulMatches);
        }

        // Update statistik akhir
        $finalStats = $syncService->getSyncStatistics();
        $this->newLine();
        $this->info('📊 Statistik Akhir:');
        $this->table(['Metrik', 'Jumlah'], [
            ['Total Drugs', $finalStats['total_drugs']],
            ['Sudah Sync', $finalStats['synced_drugs']],
            ['Persentase Sync', $finalStats['sync_percentage'] . '%'],
        ]);

        Log::info('KFA-Drugs sync completed', [
            'results' => $results,
            'duration' => $duration,
            'final_stats' => $finalStats
        ]);
    }

    /**
     * Sinkronisasi satu drug
     */
    private function syncSingleDrug(KfaDrugSyncService $syncService, int $threshold): int
    {
        $drugId = $this->option('drug');
        $drug = \App\Models\Klinik\Drug::findOrFail($drugId);

        $this->info("🎯 Mencari match untuk drug: {$drug->name}");

        $result = $syncService->findKfaMatch($drug, $threshold);

        if ($result['success']) {
            $this->info("✅ Match ditemukan!");
            $this->table(['Detail', 'Value'], [
                ['KFA Code', $result['kfa_code']],
                ['KFA Name', $result['kfa_name']],
                ['Manufacturer', $result['manufacturer']],
                ['Similarity Score', $result['similarity_score'] . '%'],
                ['Total Candidates', $result['total_candidates']],
            ]);

            if (!$this->option('dry-run')) {
                $this->updateDrugWithMatch($drug, $result);
                $this->info("✅ Drug berhasil di-update");
            }
        } else {
            $this->error("❌ Match tidak ditemukan: {$result['reason']}");
        }

        return Command::SUCCESS;
    }

    /**
     * Update drug dengan data match
     */
    private function updateDrugWithMatch($drug, $result): void
    {
        $drug->update([
            'kfa_code' => $result['kfa_code'],
            'manufacturer' => $result['manufacturer'],
            'similarity_score' => $result['similarity_score'],
            'matching_metadata' => [
                'matched_at' => now()->toDateTimeString(),
                'similarity_method' => 'fuzzy_matching',
                'kfa_product_name' => $result['kfa_name'],
                'kfa_manufacturer' => $result['manufacturer']
            ],
            'last_sync_attempt' => now()
        ]);
    }
}