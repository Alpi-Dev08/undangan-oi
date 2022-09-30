<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
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
            PermissionGroup::create([
                'name' => $value['name'],
            ]);
        }
    }

    public function data()
    {
        return [
            ['name' => 'User'],
            ['name' => 'Role'],
            ['name' => 'Permission'],
            ['name' => 'Settings']
        ];
    }
}
