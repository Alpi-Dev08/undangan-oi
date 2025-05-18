<?php


class RolesController extends Controller
{
    protected $user;
    protected $guardName = 'web';

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard($this->guardName)->user();
            return $next($request);
        });
    }

    /**
     * Memeriksa apakah pengguna memiliki izin tertentu
     *
     * @param string $permission izin yang diperlukan
     * @param string $message pesan error untuk ditampilkan
     * @return void
     */
    protected function authorizeUser(string $permission, string $message)
    {
        if (is_null($this->user) || !$this->user->can($permission)) {
            abort(403, $message);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RolesDataTable $dataTable)
    {
        $this->authorizeUser('role.read', 'Maaf !! Anda tidak berwenang untuk melihat role apapun!');
        return $dataTable->render('pages.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorizeUser('role.create', 'Maaf !! Anda tidak berwenang untuk membuat role apapun!');

        $permissionGroups = PermissionGroup::all();
        return view('pages.roles.create', compact('permissionGroups'));
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
        $this->authorizeUser('role.create', 'Maaf !! Anda tidak berwenang untuk membuat role apapun!');

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles'
        ], [
            'name.required' => 'Harap berikan nama role'
        ]);

        // Process Data
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $this->guardName
        ]);

        $permissions = $request->input('permissions');
        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role telah berhasil dibuat!');
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
        $this->authorizeUser('role.update', 'Maaf !! Anda tidak berwenang untuk mengedit role apapun!');

        $role = Role::findById($id, $this->guardName);
        $allPermissions = Permission::all();
        $permissionGroups = PermissionGroup::all();

        return view('pages.roles.edit', compact('role', 'allPermissions', 'permissionGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorizeUser('role.update', 'Maaf !! Anda tidak berwenang untuk mengedit role apapun!');

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $id
        ], [
            'name.required' => 'Harap berikan nama role'
        ]);

        $role = Role::findById($id, $this->guardName);
        $permissions = $request->input('permissions');

        $role->name = $request->name;
        $role->save();

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role telah berhasil diperbarui!');
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
        $this->authorizeUser('role.delete', 'Maaf !! Anda tidak berwenang untuk menghapus role apapun!');

        $role = Role::findById($id, $this->guardName);
        if (!is_null($role)) {
            $role->delete();
        }

        session()->flash('success', 'Role telah berhasil dihapus!');
        return redirect()->route('roles.index');
    }
}
