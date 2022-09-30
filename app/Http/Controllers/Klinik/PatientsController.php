<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\NakesDataTable;
    use App\DataTables\PatientDataTable;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Account\SettingsInfoRequest;
    use App\Models\Klinik\HealthProfesional;
    use App\Models\Klinik\Patient;
    use App\Http\Requests\StorePatientRequest;
    use App\Http\Requests\UpdatePatientRequest;
    use App\Models\Master\BloodType;
    use App\Models\Master\CardType;
    use App\Models\Master\City;
    use App\Models\Master\Country;
    use App\Models\Master\District;
    use App\Models\Master\Education;
    use App\Models\Master\Gender;
    use App\Models\Master\MaritalStatus;
    use App\Models\Master\Province;
    use App\Models\Master\Religion;
    use App\Models\Master\SubDistrict;
    use App\Models\Master\Work;
    use App\Models\User;
    use App\Models\UserInfo;
    use Haruncpi\LaravelIdGenerator\IdGenerator;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Storage;
    use Spatie\Permission\Models\Role;

    class PatientsController extends Controller
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

        public function index(PatientDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('user.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any users !');
            }

            return $dataTable->render('pages.klinik.patients.index');
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


            $countries = Country::all();
            $provinces = Province::all();

            $cards      = CardType::all();
            $bloods     = BloodType::all();
            $religions  = Religion::all();
            $genders    = Gender::all();
            $works      = Work::all();
            $maritals   = MaritalStatus::all();
            $educations = Education::all();

            return view('pages.klinik.patients.create', compact([
                'countries', 'provinces', 'cards', 'bloods', 'religions', 'genders', 'works', 'maritals', 'educations'
            ]));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(SettingsInfoRequest $request)
        {
            // save user name
            $request['password'] = Hash::make('default');

            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'email'      => 'required|email|max:255',
                'phone'      => 'string',
                'password'   => 'string'
            ]);

            $user = User::create($validated);

            $roles = Role::where('name', 'patient')->first();
            $user->assignRole($roles);


            // save on user info
            $info = UserInfo::where('user_id', $user->id)->first();

            if ($info === null) {
                // create new model
                $info = new UserInfo();
            }

            // attach this info to the current user
            $info->user()->associate($user->id);

            foreach ($request->only(array_keys($request->rules())) as $key => $value) {
                if (is_array($value)) {
                    $value = serialize($value);
                }
                $info->$key = $value;
            }

            // include to save avatar
            if ($avatar = $this->upload()) {
                $info->photo = $avatar;
            }

            if ($request->boolean('avatar_remove')) {
                Storage::delete($info->avatar);
                $info->photo = null;
            }

            $info->save();

            // save on user info

            // save on user info
            $patient_id = IdGenerator::generate(['table' => 'patients', 'field' => 'patient_code', 'length' => 12, 'prefix' => 'P'.date('Ymd')]);

            $patient = Patient::where(['user_id' =>$user->id,])->first();
            /*$latest  = Patient::where('patient_code', 'like', "%P" . date('Ymd') . "%")->latest()->first();

            if ($latest) {
                $latest = substr($latest->patient_code,8,4);
            } else {
                $latest = 0;
            }*/
            if ($patient === null) {
                // create new model
                $patient = new Patient();
            }

            // attach this info to the current user
            $patient->user()->associate($user->id);
            //$patient->patient_code  = 'P'.date('Ymd'). str_pad($latest + 1, 4, '0', STR_PAD_LEFT);
            $patient->patient_code  = $patient_id;
            $patient->register_date = date('Ymd');
            $patient->save();

            return redirect()->intended('klinik/patients');

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
            $patient = Patient::where('user_id',$id)->first();
            return view('pages.klinik.patients.barcode', compact(['patient']));
        }

        /**
         * Display the specified resource.
         *
         * @param int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function barcode(Request $request)
        {
            $barcode = $request->all();
            $patient = Patient::where("patient_code",$barcode['barcode'])->first();
            $user = User::find($patient->user_id);
            return view('pages.klinik.patients._barcode', compact(['barcode','user']));
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

            $user      = User::with(['info'])->find($id);
            $info      = $user->info;
            $countries = Country::all();
            $provinces = Province::all();

            $cards      = CardType::all();
            $bloods     = BloodType::all();
            $religions  = Religion::all();
            $genders    = Gender::all();
            $works      = Work::all();
            $maritals   = MaritalStatus::all();
            $educations = Education::all();

            $provinces    = $info->country_id != null ? Province::where('country_id', $info->country_id)->get() : Province::all();
            $cities       = $info->province_id != null ? City::where('province_id', $info->province_id)->get() : null;
            $districts    = $info->city_id != null ? District::where('city_id', $info->city_id)->get() : null;
            $subdistricts = $info->district_id != null ? SubDistrict::where('district_id', $info->district_id)->get() : null;

            return view('pages.klinik.patients.edit', compact([
                'user', 'countries', 'provinces', 'cards', 'bloods', 'religions', 'genders', 'works', 'maritals', 'educations', 'info',
                'cities', 'districts', 'subdistricts'
            ]));

        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(SettingsInfoRequest $request)
        {
            // save user name
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'email'      => 'required|email|max:255',
                'phone'      => 'string'
            ]);
            $user      = User::find($request->user);

            $user->update($validated);

            $roles = Role::where('name', 'patient')->first();
            $user->assignRole($roles);

            // save on user info
            $info = UserInfo::where('user_id', $user->id)->first();

            if ($info === null) {
                // create new model
                $info = new UserInfo();
            }

            // attach this info to the current user
            $info->user()->associate($user->id);

            foreach ($request->only(array_keys($request->rules())) as $key => $value) {
                if (is_array($value)) {
                    $value = serialize($value);
                }
                $info->$key = $value;
            }

            // include to save avatar
            if ($avatar = $this->upload()) {
                $info->photo = $avatar;
            }

            if ($request->boolean('avatar_remove')) {
                Storage::delete($info->avatar);
                $info->photo = null;
            }


            $info->save();

            return redirect()->intended('klinik/patients');

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

            $user     = User::find($id);
            $info     = UserInfo::where(['user_id' => $user->id])->first();
            $patients = Patient::where(['user_id' => $user->id])->first();
            if (!is_null($user)) {
                $user->delete();
                $info->delete();
                $patients->delete();
            }

            session()->flash('success', 'User has been deleted !!');
            return redirect()->route('users.index');
        }


        /**
         * Function for upload avatar image
         *
         * @param string $folder
         * @param string $key
         * @param string $validation
         *
         * @return false|string|null
         */
        public function upload($folder = 'images', $key = 'photo', $validation = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|sometimes')
        {
            request()->validate([$key => $validation]);

            $file = null;
            if (request()->hasFile($key)) {
                $file = Storage::disk('public')->putFile($folder, request()->file($key), 'public');
            }

            return $file;
        }
    }
