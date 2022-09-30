<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermissionGroup extends Model
{
    protected $fillable = [
        'name'
    ];

    public function permission(){
        return $this->hasMany(Permission::class);
    }

    public function roles($group){
        $permission = Permission::where('permission_group_id', $group->id)->first();

        $data = [];

        $roles = Role::all();

        foreach($roles as $role){
            if($role->hasPermissionTo($permission->name)){
                array_push($data,$role);
            }
        }

        return $data;
    }

    public static function getpermissionsByGroupId($id)
    {
        $permissions = DB::table('permissions')
            ->select('name', 'id')
            ->where('permission_group_id', $id)
            ->get();
        return $permissions;
    }

}
