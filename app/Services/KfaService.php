<?php

namespace App\Services;

use Modules\Klinik\App\Http\Controllers\KfaController;
use Illuminate\Http\Request;

class KfaService
{
    protected $kfaController;

    public function __construct(KfaController $kfaController)
    {
        $this->kfaController = $kfaController;
    }

    /**
     * Get KFA product detail with caching
     *
     * @param string $kfaCode
     * @return array|null
     */
    public function getProductDetail(string $kfaCode): ?array
    {
        if (empty($kfaCode)) {
            return null;
        }

        // Create a new request instance
        $request = new Request(['kfa_code' => $kfaCode]);
        
        // Get product detail from KFA controller
        $response = $this->kfaController->getProductDetail($request);
        
        if ($response->getData()->success && isset($response->getData()->data)) {
            return (array) $response->getData()->data;
        }

        return null;
    }

    /**
     * Format KFA data for tooltip display
     *
     * @param array|null $kfaData
     * @return string
     */
    public function formatTooltipData(?array $kfaData): string
    {
        if (!$kfaData) {
            return 'Data KFA tidak tersedia';
        }

        $tooltipContent = [];
        
        if (!empty($kfaData['name'])) {
            $tooltipContent[] = 'Nama: ' . e($kfaData['name']);
        }
        
        if (!empty($kfaData['manufacturer'])) {
            $tooltipContent[] = 'Manufacturer: ' . e($kfaData['manufacturer']);
        }
        
        if (!empty($kfaData['het_price'])) {
            $tooltipContent[] = 'HET: Rp ' . number_format($kfaData['het_price'], 0, ',', '.');
        }
        
        if (!empty($kfaData['fix_price'])) {
            $tooltipContent[] = 'Fix Price: Rp ' . number_format($kfaData['fix_price'], 0, ',', '.');
        }
        
        if (!empty($kfaData['packaging'])) {
            $tooltipContent[] = 'Kemasan: ' . e($kfaData['packaging']);
        }
        
        if (!empty($kfaData['dosage_form'])) {
            $tooltipContent[] = 'Bentuk: ' . e($kfaData['dosage_form']);
        }
        
        if (!empty($kfaData['strength'])) {
            $tooltipContent[] = 'Kekuatan: ' . e($kfaData['strength']);
        }
        
        if (!empty($kfaData['registration_number'])) {
            $tooltipContent[] = 'Registrasi: ' . e($kfaData['registration_number']);
        }

        return implode('\n', $tooltipContent);
    }

    /**
     * Check if KFA data exists for a given code
     *
     * @param string $kfaCode
     * @return bool
     */
    public function hasKfaData(string $kfaCode): bool
    {
        $data = $this->getProductDetail($kfaCode);
        return $data !== null;
    }
}