<?php

namespace Modules\Klinik\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Klinik\Models\KfaProduct;
use Satusehat\Integration\Terminology\Kfa;

class UpdateKfaDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'klinik:update-kfa-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update KFA data that is older than 1 week';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting KFA data update...');
        
        try {
            // Ambil semua produk yang perlu diupdate (lebih dari 1 minggu)
            $productsToUpdate = KfaProduct::where('last_sync', '<', now()->subWeek())
                ->orderBy('last_sync')
                ->get();

            $this->info("Found {$productsToUpdate->count()} products to update");

            $kfa = new Kfa();
            $updatedCount = 0;
            $failedCount = 0;

            foreach ($productsToUpdate as $product) {
                try {
                    $this->info("Updating product: {$product->kfa_code} - {$product->name}");
                    
                    // Ambil detail produk dari API
                    $apiProduct = $kfa->get_by_id($product->kfa_code, $product->product_type);
                    
                    if ($apiProduct) {
                        // Convert to array if it's an object for consistent handling
                        $productData = is_object($apiProduct) ? (array) $apiProduct : $apiProduct;
                        
                        // Update data produk
                        $product->update([
                            'name' => (string) ($productData['name'] ?? $productData['name'] ?? $product->name),
                            'manufacturer' => (string) ($productData['manufacturer'] ?? $productData['manufacturer'] ?? $product->manufacturer),
                            'dosage_form' => isset($productData['dosage_form']) ? (string) $productData['dosage_form'] : $product->dosage_form,
                            'strength' => isset($productData['strength']) ? (string) $productData['strength'] : $product->strength,
                            'unit' => isset($productData['unit']) ? (string) $productData['unit'] : $product->unit,
                            'packaging' => isset($productData['packaging']) ? (string) $productData['packaging'] : $product->packaging,
                            'fix_price' => isset($productData['fix_price']) ? (float) $productData['fix_price'] : $product->fix_price,
                            'het_price' => isset($productData['het_price']) ? (float) $productData['het_price'] : $product->het_price,
                            'registration_number' => isset($productData['registration_number']) ? (string) $productData['registration_number'] : $product->registration_number,
                            'registration_date' => isset($productData['registration_date']) ? (string) $productData['registration_date'] : $product->registration_date,
                            'expiry_date' => isset($productData['expiry_date']) ? (string) $productData['expiry_date'] : $product->expiry_date,
                            'description' => isset($productData['description']) ? (string) $productData['description'] : $product->description,
                            'raw_data' => json_encode($productData),
                            'last_sync' => now()
                        ]);
                        
                        $updatedCount++;
                        $this->info("✓ Successfully updated: {$product->kfa_code}");
                    } else {
                        $failedCount++;
                        $this->error("✗ Failed to update {$product->kfa_code}: No data from API");
                    }
                    
                    // Delay untuk menghindari rate limit
                    sleep(1);
                    
                } catch (\Exception $e) {
                    $failedCount++;
                    Log::error("Failed to update product {$product->kfa_code}", [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    $this->error("✗ Failed to update {$product->kfa_code}: {$e->getMessage()}");
                }
            }

            $this->info("Update completed! Updated: {$updatedCount}, Failed: {$failedCount}");
            Log::info('KFA data update completed', [
                'updated_count' => $updatedCount,
                'failed_count' => $failedCount
            ]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error during KFA data update: ' . $e->getMessage());
            Log::error('KFA data update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return Command::FAILURE;
        }
    }
}