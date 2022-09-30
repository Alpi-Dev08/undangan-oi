<?php

    namespace Database\Seeders\Master;

   use App\Models\PermissionGroup;
   use Illuminate\Database\Seeder;
    use Spatie\Permission\Models\Permission;
    use Spatie\Permission\Models\Role;

    class MasterSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            $data = $this->data();
            foreach ($data as $value) {
                $permission = Permission::create([
                    'name' => $value['name'],
                    'permission_group_id' => $value['group'],
                ]);

                $role = Role::find(1);
                $role->givePermissionTo($permission);
            }

            $this->call([
                ReligionsSeeder::class,
                GendersSeeder::class,
                WorksSeeder::class,
                EducationsSeeder::class,
                BloodTypesSeeder::class,
                MaritalStatusesSeeder::class,
                RelationshipStatusesSeeder::class,
                CardTypesSeeder::class,
                CountriesSeeder::class,
                ProvincesSeeder::class,
                CitiesSeeder::class,
                DistrictsSeeder::class,
                SubDistrictsSeeder::class
            ]);
        }

        public function data()
        {
            $data = [];
            // list of model permission
            $model = ['masters'];

            $permissionGroup = PermissionGroup::create([
                'name' => 'masters'
            ]);

            foreach ($model as $value) {
                foreach ($this->crudActions($value) as $action) {
                    $data[] = ['name' => $action,'group' => $permissionGroup->id];
                }
            }

            return $data;
        }

        public function crudActions($name)
        {
            $actions = [];
            // list of permission actions
            $crud = ['create', 'read', 'update', 'delete'];

            foreach ($crud as $value) {
                $actions[] = $name.'.'.$value;
            }

            return $actions;
        }
    }
