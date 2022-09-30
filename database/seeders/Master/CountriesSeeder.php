<?php

namespace Database\Seeders\Master;

use App\Models\Master\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
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
            Country::create([
                'name' => $value['name'],
            ]);
        }
    }

    public function data()
    {
        return [
            ['name' => 'Indonesia']
        ];
    }
}
