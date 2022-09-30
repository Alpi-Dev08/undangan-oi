<?php

    namespace App\Http\Controllers;

    use App\DataTables\RolesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\PermissionGroup;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Spatie\Permission\Models\Role;
    use App\Models\Permission;

    class RolesController extends Controller
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
        public function index(RolesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('role.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any role !');
            }
            return $dataTable->render('pages.roles.index');
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            if (is_null($this->user) || !$this->user->can('role.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any role !');
            }

            $permissiongroups = PermissionGroup::all();
            return view('pages.roles.create',compact(['permissiongroups']));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            if (is_null($this->user) || !$this->user->can('role.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any role !');
            }

            // Validation Data
            $request->validate([
                'name' => 'required|max:100|unique:roles'
            ], [
                'name.requried' => 'Please give a role name'
            ]);

            // Process Data
            $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

            $permissions = $request->input('permissions');

            if (!empty($permissions)) {
                $role = Role::find($role->id);
                $role->syncPermissions($permissions);
            }

            session()->flash('success', 'Role has been created !!');
            return redirect()->route('roles.index');
        }

        /**
         * Display the specified resource.
         *
         * @param int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            if (is_null($this->user) || !$this->user->can('role.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any role !');
            }

            $role              = Role::findById($id, 'web');
            $all_permissions   = Permission::all();
            $permissiongroups = PermissionGroup::all();
            return view('pages.roles.edit', compact('role', 'all_permissions','permissiongroups'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
            if (is_null($this->user) || !$this->user->can('role.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any role !');
            }

            // Validation Data
            $request->validate([
                'name' => 'required|max:100|unique:roles,name,' . $id
            ], [
                'name.requried' => 'Please give a role name'
            ]);

            $role        = Role::findById($id, 'web');
            $permissions = $request->input('permissions');

            $role->name = $request->name;
            $role->save();

            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            }

            session()->flash('success', 'Role has been updated !!');
            return redirect()->route('roles.index');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            if (is_null($this->user) || !$this->user->can('role.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any role !');
            }


            $role = Role::findById($id, 'web');
            if (!is_null($role)) {
                $role->delete();
            }

            session()->flash('success', 'Role has been deleted !!');
            return redirect()->route('roles.index');
        }
    }
