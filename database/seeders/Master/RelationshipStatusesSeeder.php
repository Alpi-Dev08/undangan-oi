<?php

namespace Database\Seeders\Master;

use App\Models\Master\RelationshipStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelationshipStatusesSeeder extends Seeder
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
            RelationshipStatus::create([
                'name' => $value['name'],
            ]);
        }
    }

    function data()
    {
        return [
            ['name' => 'Kepala Keluarga'],
            ['name' => 'Suami'],
            ['name' => 'Istri'],
            ['name' => 'Anak'],
            ['name' => 'Menantu'],
            ['name' => 'Cucu'],
            ['name' => 'Orangtua'],
            ['name' => 'Mertua'],
            ['name' => 'Famili lain'],
            ['name' => 'Pembantu'],
            ['name' => 'Lainnya']
        ];
    }
}
