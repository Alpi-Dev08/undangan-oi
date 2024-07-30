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
                'code' => $value['code'],
                'name' => $value['name'],
            ]);
        }
    }

    public function data()
    {
        return [
            ['code' => 'sou', 'name' => 'Gigi sehat, normal, tanpa kelainan'],
            ['code' => 'non', 'name' => 'Gigi tidak ada/tidak diketahui'],
            ['code' => 'une', 'name' => 'Un-erupted'],
            ['code' => 'pre', 'name' => 'Partial Eerupted'],
            ['code' => 'imv', 'name' => 'Impacted visible'],
            ['code' => 'ano', 'name' => 'Anomali']
        ];
    }
}
