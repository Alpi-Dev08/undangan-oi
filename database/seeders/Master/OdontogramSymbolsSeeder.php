<?php

namespace Database\Seeders\Master;

use App\Models\Master\OdontogramSymbol;
use Illuminate\Database\Seeder;

class OdontogramSymbolsSeeder extends Seeder
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
            OdontogramSymbol::create([
                'name' => $value['name'],
            ]);
        }
    }

    public function data()
    {
        return [
            ['name' => 'sou'],
            ['name' => 'non'],
            ['name' => 'une'],
            ['name' => 'pre'],
            ['name' => 'imv'],
            ['name' => 'ano']
        ];
    }
}
