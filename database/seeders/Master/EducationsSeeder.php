<?php

    namespace Database\Seeders\Master;

    use App\Models\Master\Education;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;

    class EducationsSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $data = $this->data();

            foreach ($data as $value) {
                Education::create([
                    'name' => $value['name'],
                ]);
            }
        }

        function data()
        {
            return [
                ['name' => 'Tidak / Belum Sekolah'],
                ['name' => 'Belum Tamat SD / Sederajat'],
                ['name' => 'Tamat SD / Sederajat'],
                ['name' => 'SLTP / Sederajat'],
                ['name' => 'SLTA / Sederajat'],
                ['name' => 'Diploma I / II'],
                ['name' => 'Akademi / Diploma III / Sarjana Muda'],
                ['name' => 'Diploma IV / Strata I'],
                ['name' => 'Strata II'],
                ['name' => 'Strata III']
            ];

        }
    }
