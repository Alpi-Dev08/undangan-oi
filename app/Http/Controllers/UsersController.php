<?php

    namespace App\Http\Controllers;

    use App\DataTables\UsersDataTable;
    use App\Models\Klinik\HealthProfesional;
    use App\Models\User;
    use App\Models\UserInfo;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Spatie\Permission\Models\Role;

    class UsersController extends Controller
    {
        private const UNAUTHORIZED_VIEW   = 'Sorry !! You are Unauthorized to view any users !';
        private const UNAUTHORIZED_CREATE = 'Sorry !! You are Unauthorized to create any users !';
        private const UNAUTHORIZED_UPDATE = 'Sorry !! You are Unauthorized to update any users !';
        private const UNAUTHORIZED_DELETE = 'Sorry !! You are Unauthorized to delete any users !';
        protected $user;

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
            $this->authorizeAction('user.read', self::UNAUTHORIZED_VIEW);
            return $dataTable->render('pages.users.index');
        }

        /**
         * Memeriksa apakah pengguna saat ini memiliki izin untuk tindakan tertentu
         *
         * @param string $permission
         * @param string $message
         *
         * @return void
         */
        protected function authorizeAction($permission, $message)
        {
            if (is_null($this->user) || !$this->user->can($permission)) {
                abort(403, $message);
            }
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $this->authorizeAction('user.create', self::UNAUTHORIZED_CREATE);
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
            $this->authorizeAction('user.create', self::UNAUTHORIZED_CREATE);

            // Validasi data
            $this->validateUserData($request);

            // Buat pengguna baru
            $user = $this->createOrUpdateUser(new User(), $request);

            // Buat info pengguna
            $this->createUserInfo($user);

            // Tetapkan peran
            if ($request->roles) {
                if ($request->roles == '4') {
                    $this->createOrUpdateHealthProfessional($user->id);
                }
                $user->assignRole($request->roles);
            }

            session()->flash('success', 'User has been created !!');
            return redirect()->route('users.index');
        }

        /**
         * Memvalidasi data pengguna
         *
         * @param Request  $request
         * @param int|null $userId
         * @param bool     $validatePassword
         *
         * @return void
         */
        protected function validateUserData(Request $request, $userId = null, $validatePassword = true)
        {
            $rules = [
                'first_name' => 'required|max:50',
                'last_name'  => 'max:50',
                'email'      => 'required|max:100|email|unique:users,email,' . $userId,
                'phone'      => 'numeric|unique:users,phone,' . $userId
            ];

            if ($validatePassword) {
                $rules['password'] = 'required|min:6|confirmed';
            }

            $request->validate($rules);
        }

        /**
         * Membuat atau memperbarui pengguna
         *
         * @param User    $user
         * @param Request $request
         *
         * @return User
         */
        protected function createOrUpdateUser(User $user, Request $request)
        {
            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->email      = $request->email;
            $user->phone      = $request->phone;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();
            return $user;
        }

        /**
         * Membuat info pengguna jika belum ada
         *
         * @param User $user
         *
         * @return UserInfo
         */
        protected function createUserInfo(User $user)
        {
            $userInfo = UserInfo::firstOrNew(['user_id' => $user->id]);
            $userInfo->save();
            return $userInfo;
        }

        /**
         * Membuat atau memperbarui informasi profesional kesehatan
         *
         * @param int $userId
         *
         * @return HealthProfesional
         */
        protected function createOrUpdateHealthProfessional($userId)
        {
            $dokter                             = HealthProfesional::firstOrNew(['user_id' => $userId]);
            $dokter->health_profesional_type_id = 1;
            $dokter->save();
            return $dokter;
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
            $this->authorizeAction('user.read', self::UNAUTHORIZED_VIEW);
            // Implementasi show belum lengkap
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
            $this->authorizeAction('user.update', self::UNAUTHORIZED_UPDATE);

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
            $this->authorizeAction('user.update', self::UNAUTHORIZED_UPDATE);

            $user     = User::find($id);
            $userInfo = UserInfo::where('user_id', $user->id)->first();

            // Validasi data berdasarkan keberadaan password
            $this->validateUserData($request, $id, $request->password !== '');

            // Update user
            $this->createOrUpdateUser($user, $request);

            // Update user info jika ada
            if ($userInfo) {
                $userInfo->save();
            }

            // Update peran
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
            $this->authorizeAction('user.delete', self::UNAUTHORIZED_DELETE);

            $user = User::find($id);
            if (!is_null($user)) {
                $info = UserInfo::where(['user_id' => $user->id])->first();
                $user->delete();
                if ($info) {
                    $info->delete();
                }
            }

            session()->flash('success', 'User has been deleted !!');
            return redirect()->route('users.index');
        }
    }
