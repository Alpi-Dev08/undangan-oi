<?php

namespace App\Imports;

use App\Models\Klinik\Drug;
use App\Models\Klinik\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class DrugsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip rows with empty name
            if (empty($row['name'])) {
                continue;
            }

            // Lookup unit_id berdasarkan nama unit
            $unit = Unit::where('name', $row['unit'])->first();
            $unit_id = $unit ? $unit->id : null;

            // Gunakan updateOrCreate untuk mencegah duplikasi
            try {
                $drugs = Drug::updateOrCreate(
                    [
                        'name' => $row['name'],
                        'unit_id' => $unit_id
                    ],
                    [
                        'price' => $row['price'] ?? 0,
                        'stock' => $row['stock'] ?? 0,
                    ]
                );
            } catch (\Exception $e) {
                // Log the error and continue with the next row
                \Log::error('Error creating/updating drug: ' . $e->getMessage());
                continue;
            }
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'name.required' => 'Nama obat wajib diisi.',
            'name.string' => 'Nama obat harus berupa teks.',
            'name.max' => 'Nama obat maksimal 255 karakter.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok tidak boleh negatif.',
        ];
    }
}
