<?php

namespace Modules\Klinik\App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Kfa
{
    /**
     * Base URL untuk API KFA
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * API Key untuk KFA
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->baseUrl = config('klinik.kfa_base_url', 'https://api.kfa.co.id');
        $this->apiKey = config('klinik.kfa_api_key');
    }

    /**
     * Mencari produk berdasarkan keyword
     *
     * @param string $keyword
     * @param string $productType
     * @param int $limit
     * @return array
     */
    public function searchProducts(string $keyword, string $productType = 'farmasi', int $limit = 100): array
    {
        try {
            Log::info('KFA API Search Request', [
                'keyword' => $keyword,
                'product_type' => $productType,
                'limit' => $limit
            ]);

            $response = Http::timeout(30)->get($this->baseUrl . '/products', [
                'keyword' => $keyword,
                'type' => $productType,
                'limit' => $limit,
                'api_key' => $this->apiKey
            ]);

            if (!$response->successful()) {
                Log::error('KFA API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('KFA API returned error: ' . $response->status());
            }

            $data = $response->json();

            if (!isset($data['data']) || !is_array($data['data'])) {
                Log::warning('Invalid KFA API response format', ['response' => $data]);
                return [];
            }

            Log::info('KFA API Search Success', [
                'total_products' => count($data['data'])
            ]);

            return $data['data'];

        } catch (\Exception $e) {
            Log::error('KFA API Search Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Mendapatkan detail produk berdasarkan kode KFA
     *
     * @param string $kfaCode
     * @return array|null
     */
    public function getProductDetail(string $kfaCode): ?array
    {
        try {
            Log::info('KFA API Product Detail Request', [
                'kfa_code' => $kfaCode
            ]);

            $response = Http::timeout(30)->get($this->baseUrl . '/product-detail', [
                'kfa_code' => $kfaCode,
                'api_key' => $this->apiKey
            ]);

            if (!$response->successful()) {
                Log::error('KFA API Product Detail Error', [
                    'status' => $response->status(),
                    'kfa_code' => $kfaCode,
                    'body' => $response->body()
                ]);
                throw new \Exception('KFA API returned error: ' . $response->status());
            }

            $data = $response->json();

            if (!isset($data['data']) || !is_array($data['data'])) {
                Log::warning('Invalid KFA API product detail response format', [
                    'kfa_code' => $kfaCode,
                    'response' => $data
                ]);
                return null;
            }

            Log::info('KFA API Product Detail Success', [
                'kfa_code' => $kfaCode
            ]);

            return $data['data'];

        } catch (\Exception $e) {
            Log::error('KFA API Product Detail Exception', [
                'error' => $e->getMessage(),
                'kfa_code' => $kfaCode,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}