<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $role = Role::find(1);

        $user = User::create([
            'first_name'        => $faker->firstName,
            'last_name'         => $faker->lastName,
            'email'             => 'admin@demo.com',
            'phone'             => $faker->phoneNumber,
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
        ]);

        $this->addDummyInfo($faker, $user);
        $user->assignRole($role);

    }

    private function addDummyInfo(Generator $faker, User $user)
    {
        $dummyInfo = [
            'address'  => $faker->address
        ];

        $info = new UserInfo();
        foreach ($dummyInfo as $key => $value) {
            $info->$key = $value;
        }
        $info->user()->associate($user);
        $info->save();
    }
}
