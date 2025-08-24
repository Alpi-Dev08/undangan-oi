<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPasien;

class JenisPasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisPasien = [
            [
                'nama' => 'Umum',
                'keterangan' => 'Pasien yang membayar sendiri biaya pengobatan',
            ],
            [
                'nama' => 'BPJS',
                'keterangan' => 'Pasien yang menggunakan asuransi BPJS',
            ],
            [
                'nama' => 'Asuransi',
                'keterangan' => 'Pasien yang menggunakan asuransi swasta',
            ],
            [
                'nama' => 'Korporat',
                'keterangan' => 'Pasien yang biaya pengobatannya ditanggung oleh perusahaan',
            ],
        ];

        foreach ($jenisPasien as $jenis) {
            JenisPasien::create($jenis);
        }
    }
}
