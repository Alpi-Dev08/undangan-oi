<?php

namespace Modules\Klinik\App\Services;

class StringSimilarityService
{
    /**
     * Hitung similarity score antara dua string menggunakan similar_text
     * Metode yang sangat ringan untuk menghindari memory issue
     */
    public function calculateSimilarity(string $string1, string $string2): array
    {
        // Normalisasi string
        $normalized1 = $this->normalizeString($string1);
        $normalized2 = $this->normalizeString($string2);
        
        // Hitung similarity dengan similar_text
        similar_text($normalized1, $normalized2, $percent);
        
        return [
            'levenshtein' => round($percent, 2),
            'jaro_winkler' => round($percent, 2),
            'soundex' => 0,
            'cosine' => 0,
            'combined' => round($percent, 2)
        ];
    }

    /**
     * Hitung combined score dengan similar_text
     */
    public function calculateCombinedScore(string $string1, string $string2): float
    {
        $normalized1 = $this->normalizeString($string1);
        $normalized2 = $this->normalizeString($string2);
        
        similar_text($normalized1, $normalized2, $percent);
        return round($percent, 2);
    }

    /**
     * Normalisasi string untuk perbandingan
     */
    public function normalizeString(string $string): string
    {
        // Convert to lowercase
        $string = strtolower($string);
        
        // Remove special characters and extra spaces
        $string = preg_replace('/[^a-z0-9\s]/', ' ', $string);
        $string = preg_replace('/\s+/', ' ', $string);
        
        // Remove common words
        $commonWords = ['obat', 'tablet', 'kapsul', 'sirup', 'injeksi', 'salep', 'krim', 'gel', 'serbuk', 'suspensi'];
        $string = str_replace($commonWords, '', $string);
        
        // Trim and return
        return trim($string);
    }

    /**
     * Cek apakah string mirip berdasarkan threshold
     */
    public function isSimilar(string $string1, string $string2, float $threshold = 70.0): bool
    {
        $score = $this->calculateCombinedScore($string1, $string2);
        return $score >= $threshold;
    }

    /**
     * Dapatkan best matches untuk string terhadap array
     */
    public function findBestMatches(string $search, array $candidates, int $limit = 5): array
    {
        $matches = [];
        
        foreach ($candidates as $candidate) {
            $score = $this->calculateCombinedScore($search, $candidate);
            if ($score > 0) {
                $matches[] = [
                    'candidate' => $candidate,
                    'score' => $score
                ];
            }
        }
        
        usort($matches, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        return array_slice($matches, 0, $limit);
    }
}