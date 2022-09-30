<?php

    namespace Database\Seeders\Master;

    use App\Models\Master\BloodType;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;

    class BloodTypesSeeder extends Seeder
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
                BloodType::create([
                    'name' => $value['name'],
                ]);
            }
        }

        function data()
        {
            return [
                ['name' => 'A'],
                ['name' => 'B'],
                ['name' => 'AB'],
                ['name' => 'IO'],
                ['name' => 'A+'],
                ['name' => 'B+']
            ];
        }
    }
