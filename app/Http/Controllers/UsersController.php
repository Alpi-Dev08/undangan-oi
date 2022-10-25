<?php

    namespace App\Http\Controllers;

    use App\DataTables\UsersDataTable;
    use App\Models\Klinik\HealthProfesional;
    use App\Models\User;
    use App\Http\Controllers\Controller;
    use App\Models\UserInfo;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use App\Models\Permission;
    use Spatie\Permission\Models\Role;

    class UsersController extends Controller
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

        public function index(UsersDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('user.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any users !');
            }

            return $dataTable->render('pages.users.index');
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            if (is_null($this->user) || !$this->user->can('user.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any users !');
            }

            $roles = Role::all();
            return view('pages.users.create', compact('roles'));
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
            if (is_null($this->user) || !$this->user->can('user.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any users !');
            }
            // Validation Data
            $request->validate([
                'first_name' => 'required|max:50',
                'last_name'  => 'max:50',
                'email'      => 'required|max:100|email|unique:users',
                'password'   => 'required|min:6|confirmed',
                'phone'      => 'unique:users|numeric'
            ]);

            // Create New User
            $user             = new User();
            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->email      = $request->email;
            $user->phone      = $request->phone;
            $user->password   = Hash::make($request->password);

            if($user->save()){
                $userInfo = new UserInfo();
                $userInfo->user_id = $user->id;
                $userInfo->save();
            }

            if ($request->roles) {
                if($request->roles == '4'){
                    // save on user info
                    $dokter = HealthProfesional::where('user_id', $user->id)->first();

                    if ($dokter === null) {
                        // create new model
                        $dokter = new HealthProfesional();
                    }
                    $dokter->user_id = $user->id;
                    $dokter->health_profesional_type_id = 1;
                    $dokter->save();
                }
                $user->assignRole($request->roles);
            }

            session()->flash('success', 'User has been created !!');
            return redirect()->route('users.index');
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
            if (is_null($this->user) || !$this->user->can('user.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any users !');
            }
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
            if (is_null($this->user) || !$this->user->can('user.update')) {
                abort(403, 'Sorry !! You are Unauthorized to update any users !');
            }

            $user  = User::with(['info'])->find($id);
            $roles = Role::all();
            return view('pages.users.edit', compact('user', 'roles'));
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
            if (is_null($this->user) || !$this->user->can('user.update')) {
                abort(403, 'Sorry !! You are Unauthorized to update any users !');
            }

            // Create New User
            $user = User::find($id);
            $userInfo = userInfo::where('user_id', $user->id)->first();

            // Validation Data
            if ($request->password !== '') {
                $request->validate([
                    'first_name' => 'required|max:50',
                    'last_name'  => 'max:50',
                    'email'      => 'required|max:100|email|unique:users,email,' . $id,
                    'password'   => 'nullable|min:6|confirmed',
                    'phone'      => 'numeric|unique:users,phone,'.$user->id
                ]);
            } else {
                $request->validate([
                    'first_name' => 'required|max:50',
                    'last_name'  => 'max:50',
                    'email'      => 'required|max:100|email|unique:users,email,' . $id,
                    'phone'      => 'numeric|unique:users,phone,'.$user->id
                ]);
            }

            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->email      = $request->email;
            $user->phone      = $request->phone;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            if($user->save()){
                $userInfo->save();
            }

            $user->roles()->detach();
            if ($request->roles) {
                $user->assignRole($request->roles);
            }

            session()->flash('success', 'User has been updated !!');
            return redirect()->route('users.index');
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
            if (is_null($this->user) || !$this->user->can('user.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any users !');
            }

            $user = User::find($id);
            $info = UserInfo::where(['user_id' => $user->id])->first();
            if (!is_null($user)) {
                $user->delete();
                $info->delete();
            }

            session()->flash('success', 'User has been deleted !!');
            return redirect()->route('users.index');
        }
    }
