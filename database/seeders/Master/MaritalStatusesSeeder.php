<?php

    namespace Database\Seeders\Master;

    use App\Models\Master\MaritalStatus;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;

    class MaritalStatusesSeeder extends Seeder
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
                MaritalStatus::create([
                    'name' => $value['name'],
                ]);
            }
        }

        function data()
        {
            return [
                ['name' => 'Belum Kawin'],
                ['name' => 'Kawin'],
                ['name' => 'Cerai Hidup'],
                ['name' => 'Cerai mati'],
            ];
        }
    }
