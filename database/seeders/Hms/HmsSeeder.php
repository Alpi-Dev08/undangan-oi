<?php

    namespace Database\Seeders\Hms;

   use App\Models\PermissionGroup;
   use Illuminate\Database\Seeder;
    use Spatie\Permission\Models\Permission;
    use Spatie\Permission\Models\Role;

    class HmsSeeder extends Seeder
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
        }

        public function data()
        {
            $data = [];
            // list of model permission
            $model = ['klinik'];

            $permissionGroup = PermissionGroup::create([
                'name' => 'Healthcare Management System'
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
