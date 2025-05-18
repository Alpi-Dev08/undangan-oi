<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\SettingsEmailRequest;
    use App\Http\Requests\SettingsNakesRequest;
    use App\Models\BloodType;
    use App\Models\CardType;
    use App\Models\City;
    use App\Models\Country;
    use App\Models\District;
    use App\Models\Education;
    use App\Models\Examination;
    use App\Models\Gender;
    use App\Models\HealthProfesional;
    use App\Models\HealthProfesionalType;
    use App\Models\JenisPasien;
    use App\Models\Location;
    use App\Models\MaritalStatus;
    use App\Models\MedicalRecord;
    use App\Models\OdontogramSymbol;
    use App\Models\Package;
    use App\Models\PackageDetail;
    use App\Models\Patient;
    use App\Models\PemeriksaanAwal;
    use App\Models\Province;
    use App\Models\Religion;
    use App\Models\ServiceCategory;
    use App\Models\Speciality;
    use App\Models\SubDistrict;
    use App\Models\Transaction;
    use App\Models\User;
    use App\Models\Work;
    use App\Services\SatuSehatService;
    use Carbon\Carbon;
    use Exception;
    use Haruncpi\LaravelIdGenerator\IdGenerator;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Log;
    use Ramsey\Uuid\Uuid;
    use Satusehat\Integration\Encounter;

    class SettingsController extends Controller
    {
        /**
         * Konstruktor dengan dependency injection SatuSehatService
         */
        protected $satuSehatService;

        public function __construct(SatuSehatService $satuSehatService)
        {
            $this->satuSehatService = $satuSehatService;
        }

        /**
         * Menampilkan halaman pengaturan
         */
        public function index(Request $request)
        : View
        {
            $user = $this->getUserFromRequest($request);
            $info = $user->info;

            // Load reference data
            $data = [
                'user'              => $user,
                'info'              => $info,
                'countries'         => Country::all(),
                'provinces'         => $this->getProvincesByCountry($info->country_id),
                'cities'            => $this->getCitiesByProvince($info->province_id),
                'districts'         => $this->getDistrictsByCity($info->city_id),
                'subdistricts'      => $this->getSubDistrictsByDistrict($info->district_id),
                'cards'             => CardType::all(),
                'bloods'            => BloodType::all(),
                'religions'         => Religion::all(),
                'genders'           => Gender::all(),
                'works'             => Work::all(),
                'maritals'          => MaritalStatus::all(),
                'educations'        => Education::all(),
                'odontogramsymbols' => OdontogramSymbol::all(),
                'specialities'      => Speciality::all(),
                'types'             => HealthProfesionalType::all(),
                'nakes'             => HealthProfesional::where('user_id', auth()->user()->id)->first(),
            ];

            return view('pages.account.settings.settings', compact(array_keys($data)));
        }

        /**
         * Metode helper untuk mendapatkan user dari request
         */
        private function getUserFromRequest(Request $request)
        : User
        {
            $id = $request->id;
            return $id ? User::findOrFail($id) : auth()->user();
        }

        /**
         * Metode helper untuk mendapatkan provinsi berdasarkan negara
         */
        private function getProvincesByCountry(?int $countryId)
        : mixed
        {
            if ($countryId) {
                return Province::where('country_id', $countryId)->get();
            }

            return Province::all();
        }

        /**
         * Metode helper untuk mendapatkan kota berdasarkan provinsi
         */
        private function getCitiesByProvince(?int $provinceId)
        : mixed
        {
            return $provinceId ? City::where('province_id', $provinceId)->get() : null;
        }

        /**
         * Metode helper untuk mendapatkan kecamatan berdasarkan kota
         */
        private function getDistrictsByCity(?int $cityId)
        : mixed
        {
            return $cityId ? District::where('city_id', $cityId)->get() : null;
        }

        /**
         * Metode helper untuk mendapatkan kelurahan berdasarkan kecamatan
         */
        private function getSubDistrictsByDistrict(?int $districtId)
        : mixed
        {
            return $districtId ? SubDistrict::where('district_id', $districtId)->get() : null;
        }

        /**
         * Menampilkan halaman pembayaran
         */
        public function payments(Request $request)
        : View
        {
            $user        = $this->getUserFromRequest($request);
            $examination = Examination::find($request->examination);

            return view('pages.account.payments.payments', compact('user', 'info', 'examination'));
        }

        /**
         * Memproses pembuatan pembayaran
         */
        public function createPayment(Request $request)
        : RedirectResponse
        {
            $examination         = Examination::find($request->id);
            $examination->status = $request->status;
            $examination->save();

            return redirect()->route('examinations.index');
        }

        /**
         * Menampilkan halaman pemeriksaan
         */
        public function examinations(Request $request)
        : View
        {
            $user = $this->getUserFromRequest($request);

            $data = [
                'user'              => $user,
                'info'              => $user->info,
                'healthprofesional' => HealthProfesional::all(),
                'servicecategories' => ServiceCategory::where('is_global', 0)->get(),
                'pemeriksaan_awal'  => PemeriksaanAwal::where(['user_id' => null, 'patient_id' => null])
                                                      ->latest()
                                                      ->first(),
                'packages'          => Package::all(),
                'locations'         => Location::all(),
                'jenisPasien'       => JenisPasien::all(),
            ];

            return view('pages.account.examinations.examinations', compact(array_keys($data)));
        }

        /**
         * Menampilkan halaman janji temu
         */
        public function appointments(Request $request)
        : View
        {
            $user = $this->getUserFromRequest($request);

            $data = [
                'user'              => $user,
                'info'              => $user->info,
                'healthprofesional' => HealthProfesional::all(),
                'servicecategories' => ServiceCategory::where('is_global', 0)->get(),
            ];

            return view('pages.account.examinations.appointments', compact(array_keys($data)));
        }

        /**
         * Membuat pemeriksaan baru
         */
        public function createExamination(Request $request)
        : RedirectResponse
        {
            $user             = User::find($request->user_id);
            $examination_code = $this->generateCode('examinations', 'examination_code', 12, 'E' . date('Ymd'));

            // Mencari atau membuat medical record
            $medical_record = $this->findOrCreateMedicalRecord($user);

            // Membuat objek examination baru
            $examination = new Examination();
            $examination->fill([
                'user_id'               => $user->id,
                'patient_id'            => $user->patient->id,
                'jenis_pasien_id'       => $request->jenis_pasien_id,
                'medical_record_id'     => $medical_record->id,
                'examination_code'      => $examination_code,
                'health_profesional_id' => $request->health_profesional_id,
                'service_category_id'   => $request->service_category_id,
                'package_id'            => $request->package_id,
                'location_id'           => $request->location_id,
                'examination_date'      => date('Y-m-d H:i:s'),
                'total'                 => 0,
                'status'                => 'waiting payment'
            ]);

            // Menangani consent jika pasien memiliki his_number
            if ($user->patient->his_number) {
                $this->handleConsent($examination, $user, $request);
            }

            // Menangani encounter untuk SATU Sehat
            if ($user->patient->his_number) {
                $this->createSatuSehatEncounter($examination, $user, $request);
            }

            $examination->save();

            // Menangani pemeriksaan awal jika tersedia
            if ($request->pemeriksaan_awal) {
                $this->handlePemeriksaanAwal($request, $examination, $user);
            }

            // Membuat transaksi untuk pemeriksaan
            $this->createTransaction($examination);

            // Menangani paket jika ada
            if ($examination->package_id != null) {
                $package            = Package::find($examination->package_id);
                $packageDetails     = PackageDetail::where('package_id', $package->id)->get();
                $service_categories = ServiceCategory::all();

                return view('examinations.package', compact('examination', 'package', 'packageDetails', 'service_categories'));
            }

            return redirect()->route('examinations.services', ['id' => $examination->id]);
        }

        /**
         * Metode helper untuk generate kode
         */
        private function generateCode(string $table, string $field, int $length, string $prefix)
        : string
        {
            return IdGenerator::generate([
                'table'  => $table,
                'field'  => $field,
                'length' => $length,
                'prefix' => $prefix
            ]);
        }

        /**
         * Metode helper untuk mencari atau membuat medical record
         */
        private function findOrCreateMedicalRecord(User $user)
        : MedicalRecord
        {
            $medical_record = MedicalRecord::where('user_id', $user->id)->first();

            if ($medical_record) {
                return $medical_record;
            }

            $medical_record_id                   = $this->generateCode('medical_records', 'medical_record_code', 13, 'MR' . date('Ymd'));
            $medical_record                      = new MedicalRecord();
            $medical_record->medical_record_code = $medical_record_id;
            $medical_record->user_id             = $user->id;
            $medical_record->save();

            return $medical_record;
        }

        /**
         * Metode helper untuk menangani consent
         */
        private function handleConsent(Examination $examination, User $user, Request $request)
        : void
        {
            $data = [
                'patient_id' => $user->patient->his_number,
                'action'     => $request->isConsent == "ya" ? "OPTIN" : "OPTOUT",
                'agent'      => auth()->user()->name,
            ];

            $consent = satu_sehat_consent($data);

            if ($consent) {
                $examination->is_consent   = $request->isConsent == "ya" ? 1 : 0;
                $examination->consent_data = $consent;
            }
        }

        /**
         * Metode helper untuk membuat encounter SATU Sehat
         */
        private function createSatuSehatEncounter(Examination $examination, User $user, Request $request)
        : void
        {
            $location          = $this->getLocationForSatuSehat($request->location_id);
            $healthprofesional = HealthProfesional::find($request->health_profesional_id);

            // Menentukan ID referensi tenaga kesehatan
            if ($healthprofesional->his_number) {
                $reference      = $healthprofesional->his_number;
                $reference_name = $healthprofesional->user->name;
            } else {
                $reference         = "10000571263";
                $healthprofesional = HealthProfesional::where('his_number', '10000571263')->first();
                $reference_name    = $healthprofesional->user->name;
            }

            // Override untuk environment staging
            if (getenv('SATUSEHAT_ENV') == 'STG') {
                $reference      = '10009880728';
                $reference_name = 'dr. Alexander';
            }

            try {
                $encounter = new Encounter;
                $uuid      = Uuid::uuid4()->toString();

                $encounter->addRegistrationId($uuid);
                $encounter->setArrived(Carbon::now()->subMinutes(15)->toDateTimeString());
                $encounter->addRegistrationId($examination->examination_code);
                $encounter->setConsultationMethod('RAJAL');
                $encounter->setSubject($user->patient->his_number, $user->name);
                $encounter->addParticipant($reference, $reference_name);
                $encounter->addLocation($location->location_id, $location->name);

                [$encounterData, $res] = $encounter->post();
                $encounterJson = json_encode($res, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

                if (isset($res->id)) {
                    $examination->encounter_id     = $res->id;
                    $examination->encounter        = $encounterJson;
                    $examination->encounter_status = $res->status;
                }
            } catch (Exception $e) {
                // Log error instead of dd()
                Log::error('SATU Sehat Encounter Error: ' . $e->getMessage());
            }
        }

        /**
         * Metode helper untuk mendapatkan lokasi SATU Sehat
         */
        private function getLocationForSatuSehat(?int $locationId)
        : object
        {
            if (getenv('SATUSEHAT_ENV') == 'STG') {
                return (object) [
                    'location_id' => '9252e3e6-f0e9-4076-9a4f-91c0a24a8b25',
                    'name'        => 'Ruang Poli Umum'
                ];
            }

            return Location::find($locationId);
        }

        /**
         * Metode helper untuk menangani pemeriksaan awal
         */
        private function handlePemeriksaanAwal(Request $request, Examination $examination, User $user)
        : void
        {
            $pemeriksaan_awal                 = PemeriksaanAwal::find($request->pemeriksaan_awal);
            $pemeriksaan_awal->examination_id = $examination->id;
            $pemeriksaan_awal->user_id        = $request->user_id;
            $pemeriksaan_awal->patient_id     = $user->patient->id;
            $pemeriksaan_awal->save();
        }

        /**
         * Metode helper untuk membuat transaksi
         */
        private function createTransaction(Examination $examination)
        : void
        {
            $invoiceNumber = $this->generateCode('transactions', 'invoice_number', 14, 'INV' . date('Ymd'));

            $transaction                 = new Transaction();
            $transaction->examination_id = $examination->id;
            $transaction->invoice_number = $invoiceNumber;
            $transaction->amount         = $examination->total;
            $transaction->status         = 'waiting payment';
            $transaction->save();
        }

        /**
         * Membuat janji temu baru
         */
        public function createAppointment(Request $request)
        : RedirectResponse
        {
            $user             = User::find($request->user_id);
            $examination_code = $this->generateCode('examinations', 'examination_code', 12, 'E' . date('Ymd'));

            // Mencari atau membuat medical record
            $medical_record = $this->findOrCreateMedicalRecord($user);

            // Membuat objek examination baru untuk janji temu
            $examination = new Examination();
            $examination->fill([
                'user_id'               => $user->id,
                'patient_id'            => $user->patient->id,
                'medical_record_id'     => $medical_record->id,
                'examination_code'      => $examination_code,
                'health_profesional_id' => $request->health_profesional_id,
                'service_category_id'   => $request->service_category_id,
                'location_id'           => $request->location_id,
                'examination_date'      => date('Y-m-d H:i:s'),
                'appointment_date'      => $request->appointment_date,
                'appointment_status'    => '0',
                'is_appointment'        => '1',
                'total'                 => 0,
                'status'                => 'waiting payment'
            ]);

            $examination->save();

            // Membuat transaksi untuk janji temu
            $this->createTransaction($examination);

            return redirect()->route('appointments.index');
        }

        /**
         * Memperbarui data tenaga kesehatan
         */
        public function nakes(SettingsNakesRequest $request)
        : RedirectResponse
        {
            $healthprofesional = HealthProfesional::where('user_id', auth()->user()->id)->first();

            if ($healthprofesional === null) {
                $healthprofesional = new HealthProfesional();
            }

            // Menghubungkan dengan user saat ini
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
         * Mengubah email user
         */
        public function changeEmail(SettingsEmailRequest $request)
        : RedirectResponse
        {
            // Mencegah perubahan email untuk akun demo
            if ($request->input('current_email') === 'demo@demo.com') {
                return redirect()->intended('account/settings');
            }

            auth()->user()->update(['email' => $request->input('email')]);

            if ($request->expectsJson()) {
                return response()->json($request->all());
            }

            return redirect()->intended('account/settings');
        }
    }
