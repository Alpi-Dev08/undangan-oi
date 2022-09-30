<?php

    namespace Database\Seeders\Master;

    use App\Models\Master\Province;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;

    class ProvincesSeeder extends Seeder
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
                Province::create([
                    'country_id' => $value['country_id'],
                    'area_code'  => $value['area_code'],
                    'name'       => $value['name'],
                ]);
            }
        }

        public function data()
        {
            return [
                [
                    'country_id' => 1,
                    'area_code'  => 11,
                    'name'       => 'Aceh (NAD)'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 12,
                    'name'       => 'Sumatera Utara'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 13,
                    'name'       => 'Sumatera Barat'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 14,
                    'name'       => 'Riau'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 15,
                    'name'       => 'Jambi'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 16,
                    'name'       => 'Sumatera Selatan'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 17,
                    'name'       => 'Bengkulu'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 18,
                    'name'       => 'Lampung'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 19,
                    'name'       => 'Kepulauan Bangka Belitung'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 21,
                    'name'       => 'Kepulauan Riau'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 31,
                    'name'       => 'DKI Jakarta'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 32,
                    'name'       => 'Jawa Barat'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 33,
                    'name'       => 'Jawa Tengah'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 34,
                    'name'       => 'DI Yogyakarta'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 35,
                    'name'       => 'Jawa Timur'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 36,
                    'name'       => 'Banten'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 51,
                    'name'       => 'Bali'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 52,
                    'name'       => 'Nusa Tenggara Barat (NTB)'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 53,
                    'name'       => 'Nusa Tenggara Timur (NTT)'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 61,
                    'name'       => 'Kalimantan Barat'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 62,
                    'name'       => 'Kalimantan Tengah'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 63,
                    'name'       => 'Kalimantan Selatan'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 64,
                    'name'       => 'Kalimantan Timur'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 65,
                    'name'       => 'Kalimantan Utara'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 71,
                    'name'       => 'Kalimantan Utara'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 72,
                    'name'       => 'Sulawesi Tengah'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 73,
                    'name'       => 'Sulawesi Selatan'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 74,
                    'name'       => 'Sulawesi Tenggara'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 75,
                    'name'       => 'Gorontalo'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 76,
                    'name'       => 'Sulawesi Barat'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 81,
                    'name'       => 'Maluku'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 82,
                    'name'       => 'Maluku Utara'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 91,
                    'name'       => 'Papua'
                ],
                [
                    'country_id' => 1,
                    'area_code'  => 92,
                    'name'       => 'Papua Barat'
                ]
            ];
        }
    }
