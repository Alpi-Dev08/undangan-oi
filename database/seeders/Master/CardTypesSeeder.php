<?php

namespace Database\Seeders\Master;

use App\Models\Master\CardType;
use Illuminate\Database\Seeder;

class CardTypesSeeder extends Seeder
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
            CardType::create([
                'name' => $value['name'],
            ]);
        }
    }

    function data()
    {
        return [
            ['name' => 'KTP'],
            ['name' => 'SIM'],
            ['name' => 'PASPOR']
        ];
    }
}
