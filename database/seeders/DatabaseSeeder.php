<?php

namespace Database\Seeders;

use Database\Seeders\Hms\HmsSeeder;
use Database\Seeders\Master\MasterSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            PermissionGroupSeeder::class,
            PermissionsSeeder::class,
            UsersSeeder::class,
            MasterSeeder::class,
            HmsSeeder::class,
            JenisPasienSeeder::class
        ]);
    }
}
