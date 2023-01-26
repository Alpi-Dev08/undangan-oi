<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\SettingsEmailRequest;
use App\Http\Requests\Account\SettingsInfoRequest;
use App\Http\Requests\Account\SettingsNakesRequest;
use App\Http\Requests\Account\SettingsPasswordRequest;
use App\Models\Klinik\Examination;
use App\Models\Klinik\HealthProfesional;
use App\Models\Klinik\HealthProfesionalType;
use App\Models\Klinik\Location;
use App\Models\Klinik\MedicalRecord;
use App\Models\Klinik\Package;
use App\Models\Klinik\PackageDetail;
use App\Models\Klinik\ServiceCategory;
use App\Models\Klinik\ServiceType;
use App\Models\Klinik\Speciality;
use App\Models\Klinik\Transaction;
use App\Models\Klinik\TransactionDetail;
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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $id = $request->id;
        $user = $id != '' ? User::find($id) : auth()->user();
        $info = $user->info;
        $countries = Country::all();

        $provinces = $info->country_id != null ? Province::where('country_id', $info->country_id)->get() : Province::all();
        $cities = $info->province_id != null ? City::where('province_id', $info->province_id)->get() : null;
        $districts = $info->city_id != null ? District::where('city_id', $info->city_id)->get() : null;
        $subdistricts = $info->district_id != null ? SubDistrict::where('district_id', $info->district_id)->get() : null;

        $cards = CardType::all();
        $bloods = BloodType::all();
        $religions = Religion::all();
        $genders = Gender::all();
        $works = Work::all();
        $maritals = MaritalStatus::all();
        $educations = Education::all();

        $specialities = Speciality::all();
        $types = HealthProfesionalType::all();
        $nakes = HealthProfesional::where('user_id', auth()->user()->id)->first();

        // get the default inner page
        return view('pages.account.settings.settings', compact([
            'user', 'info', 'countries', 'provinces', 'cities', 'districts', 'subdistricts', 'cards', 'bloods', 'religions', 'genders', 'works', 'maritals', 'educations',
            'specialities', 'types', 'nakes'
        ]));
    }

    public function payments(Request $request)
    {
        $id = $request->id;
        $user = $id != '' ? User::find($id) : auth()->user();
        $examination = Examination::find($request->examination);
        $info = $user->info;

        // get the default inner page
        return view('pages.account.payments.payments', compact([
            'user', 'info', 'examination'
        ]));
    }

    public function createPayment(Request $request)
    {
        $id = $request->id;
        $examination = Examination::find($request->id);
        $examination->status = $request->status;
        $examination->save();
        return redirect()->route('examinations.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function examinations(Request $request)
    {
        $id = $request->id;
        $user = $id != '' ? User::find($id) : auth()->user();
        $healthprofesional = HealthProfesional::all();
        $servicecategories = ServiceCategory::where('is_global', 0)->get();
        $packages = Package::all();
        $locations = Location::all();

        $info = $user->info;


        // get the default inner page
        return view('pages.account.examinations.examinations', compact([
            'user', 'info', 'healthprofesional', 'servicecategories', 'locations', 'packages'
        ]));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function appointments(Request $request)
    {
        $id = $request->id;
        $user = $id != '' ? User::find($id) : auth()->user();
        $healthprofesional = HealthProfesional::all();
        $servicecategories = ServiceCategory::where('is_global', 0)->get();

        $info = $user->info;


        // get the default inner page
        return view('pages.account.examinations.appointments', compact([
            'user', 'info', 'healthprofesional', 'servicecategories'
        ]));
    }

    public function createExamination(Request $request)
    {
        $user = User::find($request->user_id);
        $examination_code = IdGenerator::generate(['table' => 'examinations', 'field' => 'examination_code', 'length' => 12, 'prefix' => 'E' . date('Ymd')]);
        $medical_record = MedicalRecord::where('user_id', $request->user_id)->first();
        if ($medical_record) {
            $medical_record_id = $medical_record->medical_record_code;
        } else {
            $medical_record_id = IdGenerator::generate(['table' => 'medical_records', 'field' => 'medical_record_code', 'length' => 13, 'prefix' => 'MR' . date('Ymd')]);

            $medical_record = new MedicalRecord();
            $medical_record->medical_record_code = $medical_record_id;
            $medical_record->user_id = $user->id;
            $medical_record->save();
        }

        $examination = new Examination();
        $examination->user_id = $user->id;
        $examination->patient_id = $user->patient->id;
        $examination->medical_record_id = $medical_record->id;
        $examination->examination_code = $examination_code;
        $examination->health_profesional_id = $request->health_profesional_id;
        $examination->service_category_id = $request->service_category_id;
        $examination->package_id = $request->package_id;
        $examination->location_id = $request->location_id;
        $examination->examination_date = date('Y-m-d H:i:s');
        $examination->total = 0;
        $examination->status = 'waiting';
        $examination->save();

        $inv = IdGenerator::generate(['table' => 'transactions', 'field' => 'invoice_number', 'length' => 14, 'prefix' => 'INV' . date('Ymd')]);


        $transactions = new Transaction();
        $transactions->examination_id = $examination->id;
        $transactions->invoice_number = $inv;
        $transactions->amount = $examination->total;
        $transactions->status = 'waiting';
        $transactions->save();
        if($examination->package_id != null){
            $package = Package::find($examination->package_id);
            $packageDetails = PackageDetail::where('package_id', $package->id)->get();
            $service_categories = ServiceCategory::all();

            return view('examinations.package', compact([
                'examination', 'package', 'packageDetails', 'service_categories'
            ]));
        }
        return redirect()->route('examinations.services', ['id' => $examination->id]);
    }

    public function createAppointment(Request $request)
    {
        $user = User::find($request->user_id);
        $examination_code = IdGenerator::generate(['table' => 'examinations', 'field' => 'examination_code', 'length' => 12, 'prefix' => 'E' . date('Ymd')]);
        $medical_record = MedicalRecord::where('user_id', $request->user_id)->first();
        if ($medical_record) {
            $medical_record_id = $medical_record->medical_record_code;
        } else {
            $medical_record_id = IdGenerator::generate(['table' => 'medical_records', 'field' => 'medical_record_code', 'length' => 13, 'prefix' => 'MR' . date('Ymd')]);

            $medical_record = new MedicalRecord();
            $medical_record->medical_record_code = $medical_record_id;
            $medical_record->user_id = $user->id;
            $medical_record->save();
        }

        $examination = new Examination();
        $examination->user_id = $user->id;
        $examination->patient_id = $user->patient->id;
        $examination->medical_record_id = $medical_record->id;
        $examination->examination_code = $examination_code;
        $examination->health_profesional_id = $request->health_profesional_id;
        $examination->service_category_id = $request->service_category_id;
        $examination->location_id = $request->location_id;
        $examination->examination_date = date('Y-m-d H:i:s');
        $examination->appointment_date = $request->appointment_date;
        $examination->appointment_status = '0';
        $examination->is_appointment = '1';
        $examination->total = 0;
        $examination->status = 'waiting';
        $examination->save();

        $inv = IdGenerator::generate(['table' => 'transactions', 'field' => 'invoice_number', 'length' => 14, 'prefix' => 'INV' . date('Ymd')]);


        $transactions = new Transaction();
        $transactions->examination_id = $examination->id;
        $transactions->invoice_number = $inv;
        $transactions->amount = $examination->total;
        $transactions->status = 'waiting';
        $transactions->save();

        return redirect()->route('appointments.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SettingsInfoRequest $request)
    {
        // save user name
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'string'
        ]);
        $user = User::find($request->user_id);
        $user()->update($validated);

        // save on user info
        $info = UserInfo::where('user_id', $user()->id)->first();

        if ($info === null) {
            // create new model
            $info = new UserInfo();
        }

        // attach this info to the current user
        $info->user()->associate($user());

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

        return redirect()->intended('account/settings');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function nakes(SettingsNakesRequest $request)
    {
        // save on user info
        $healthprofesional = HealthProfesional::where('user_id', auth()->user()->id)->first();

        if ($healthprofesional === null) {
            // create new model
            $healthprofesional = new HealthProfesional();
        }

        // attach this info to the current user
        $healthprofesional->user()->associate(auth()->user());

        foreach ($request->only(array_keys($request->rules())) as $key => $value) {
            if (is_array($value)) {
                $value = serialize($value);
            }
            $healthprofesional->$key = $value;
        }

        $healthprofesional->save();

        return redirect()->intended('account/settings');
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

    /**
     * Function to accept request for change email
     *
     * @param SettingsEmailRequest $request
     */
    public function changeEmail(SettingsEmailRequest $request)
    {
        // prevent change email for demo account
        if ($request->input('current_email') === 'demo@demo.com') {
            return redirect()->intended('account/settings');
        }

        auth()->user()->update(['email' => $request->input('email')]);

        if ($request->expectsJson()) {
            return response()->json($request->all());
        }

        return redirect()->intended('account/settings');
    }

    /**
     * Function to accept request for change password
     *
     * @param SettingsPasswordRequest $request
     */
    public function changePassword(SettingsPasswordRequest $request)
    {
        // prevent change password for demo account
        if ($request->input('current_email') === 'demo@demo.com') {
            return redirect()->intended('account/settings');
        }

        auth()->user()->update(['password' => Hash::make($request->input('password'))]);

        if ($request->expectsJson()) {
            return response()->json($request->all());
        }

        return redirect()->intended('account/settings');
    }
}
