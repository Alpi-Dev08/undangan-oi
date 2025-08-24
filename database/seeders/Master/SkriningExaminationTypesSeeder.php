<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use App\Models\Klinik\SkriningExaminationType;

class SkriningExaminationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $row) {
            SkriningExaminationType::create([
                'name' => $row['name'],
                'nilai_normal' => $row['nilai_normal'],
            ]);
        }
    }

    private function data(): array
    {
        return [
            ['name' => 'Tinggi Badan', 'nilai_normal' => '-'],
            ['name' => 'Berat Badan', 'nilai_normal' => '-'],
            ['name' => 'Lingkar Perut', 'nilai_normal' => 'Perempuan: < 80 cm<br>Laki-laki: < 90 cm'],
            [
                'name' => 'Tekanan Darah',
                'nilai_normal' => "Optimal: < 120 / < 80 mmHg<br>Normal: 120 – 129 / 80 – 84 mmHg",
            ],
            [
                'name' => 'Gula Darah Puasa',
                'nilai_normal' => "Normal: 70-100 mg/dL<br>Prediabetes: 100-125 mg/dL<br>Diabetes: >=126 mg/dL",
            ],
            ['name' => 'Gula Darah Sewaktu', 'nilai_normal' => '< 120 mg/dL'],
            [
                'name' => 'Gula Darah 2 Jam PP',
                'nilai_normal' => "Normal: < 140 mg/dL<br>Prediabetes: 140-199 mg/dL",
            ],
            ['name' => 'Kolesterol Total', 'nilai_normal' => '< 200 mg/dL'],
            [
                'name' => 'Asam Urat',
                'nilai_normal' => "Perempuan: 2,4 - 6 mg/dL<br>Laki-laki: 3,4 - 7 mg/dL",
            ],
            ['name' => 'Golongan Darah', 'nilai_normal' => '-'],
        ];
    } 
}
