<?php

namespace Database\Seeders\Master;

use App\Models\Master\Religion;
use Illuminate\Database\Seeder;

class ReligionsSeeder extends Seeder
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
            Religion::create([
                'name' => $value['name'],
            ]);
        }
    }

    public function data()
    {
        return [
            ['name' => 'Islam'],
            ['name' => 'Protestan'],
            ['name' => 'Katolik'],
            ['name' => 'Hindu'],
            ['name' => 'Buddha'],
            ['name' => 'Khonghucu']
        ];
    }
}
