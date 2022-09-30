<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
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
                'permission_group_id' => $value['group']
            ]);

            $role = Role::find(1);
            $role->givePermissionTo($permission);
        }
    }

    public function data()
    {
        $data = [];
        // list of model permission
        $model = ['user', 'role', 'permission','settings'];

        $i=1;
        foreach ($model as $value) {
            foreach ($this->crudActions($value) as $action) {
                $data[] = ['name' => $action,'group'=>$i];
            }
            $i++;
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
