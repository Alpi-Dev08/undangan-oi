<?php

namespace Database\Seeders\Master;

use App\Models\Master\Gender;
use Illuminate\Database\Seeder;

class GendersSeeder extends Seeder
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
            Gender::create([
                'name' => $value['name'],
            ]);
        }
    }

    public function data()
    {
        return [
            ['name' => 'Laki-laki'],
            ['name' => 'Perempuan']
        ];
    }
}
