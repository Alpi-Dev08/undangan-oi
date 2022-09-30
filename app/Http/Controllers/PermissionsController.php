<?php

namespace App\Http\Controllers;

use App\DataTables\PermissionsDataTable;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;

class PermissionsController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PermissionsDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('permission.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any permission !');
        }
        return $dataTable->render('pages.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('permission.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any permission !');
        }
       return view('pages.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('permission.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any permission !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:permissions'
        ], [
            'name.requried' => 'Please give a permission name'
        ]);

        // Process Data
        $group = PermissionGroup::create(['name' => $request->name]);

        $group_name = strtolower($request->name);
        $data = [
            $group_name.'.create',
            $group_name.'.read',
            $group_name.'.update',
            $group_name.'.delete',
            $group_name.'.approve',
            $group_name.'.report'
        ];

        foreach($data as $permission){
            Permission::create([
               'name' => $permission,
               'guard_name' => 'web',
               'permission_group_id' => $group->id
            ]);
        }

        session()->flash('success', 'Permission has been created !!');
        return redirect()->route('permissions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('permission.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any role !');
        }

        $permission              = PermissionGroup::find($id);
        return view('pages.permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('permission.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any permission !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:permissions,name,' . $id
        ], [
            'name.requried' => 'Please give a permission name'
        ]);

        $group        = PermissionGroup::find($id);
        $group->name = $request->name;

        $group_name = strtolower($request->name);

        if($group->save()){
            $permissions = Permission::where('permission_group_id', $group->id)->get();

            $data = [
                $group_name.'.create',
                $group_name.'.read',
                $group_name.'.update',
                $group_name.'.delete',
                $group_name.'.approve',
                $group_name.'.report'
            ];

            $i = 0;
            foreach($permissions as $permission){
                $permission->name = $data[$i];
                $permission->save();

                $i++;
            }
        }
        session()->flash('success', 'Permission has been updated !!');
        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('permission.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any role !');
        }


        $permission = PermissionGroup::find($id);
        if (!is_null($permission)) {
            if($permission->delete()){
                Permission::where('permission_group_id',$id)->delete();
            }
        }

        session()->flash('success', 'Permission has been deleted !!');
        return redirect()->route('permissions.index');
    }
}
