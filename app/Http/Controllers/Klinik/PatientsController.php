<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\PatientDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\SettingsInfoRequest;
use App\Models\Klinik\Examination;
use App\Models\Klinik\Patient;
use App\Models\Klinik\PemeriksaanAwal;
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
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Exception;
use Throwable;

/**
 * Controller untuk mengelola data pasien klinik
 *
 * @package App\Http\Controllers\Klinik
 */
class PatientsController extends Controller
{
    /**
     * User yang sedang login
     */
    public ?object $user;

    /**
     * Constructor - Setup middleware dan user authentication
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });

        // Middleware untuk otorisasi
        $this->middleware('can:user.read')->only(['index', 'show', 'print']);
        $this->middleware('can:user.create')->only(['create', 'store']);
        $this->middleware('can:user.update')->only(['edit', 'update']);
        $this->middleware('can:user.delete')->only(['destroy']);
    }

    /**
     * Menampilkan daftar pasien
     *
     * @param PatientDataTable $dataTable
     * @return Response
     */
    public function index(PatientDataTable $dataTable): Response
    {
        Log::info('Mengakses halaman daftar pasien', [
            'user_id' => $this->user?->id,
            'user_name' => $this->user?->name
        ]);

        if (is_null($this->user) || !$this->user->can('user.read')) {
            Log::warning('Akses ditolak untuk melihat daftar pasien', [
                'user_id' => $this->user?->id,
                'permission' => 'user.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data pasien.');
        }

        return $dataTable->render('pages.klinik.patients.index');
    }

    /**
     * Menampilkan form untuk membuat pasien baru
     *
     * @return View
     */
    public function create()
    {
        Log::info('Mengakses form pembuatan pasien', [
            'user_id' => $this->user?->id
        ]);

        if (is_null($this->user) || !$this->user->can('user.create')) {
            Log::warning('Akses ditolak untuk membuat pasien', [
                'user_id' => $this->user?->id,
                'permission' => 'user.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data pasien.');
        }

        try {
            $countries = Country::select('id', 'name')->orderBy('name')->get();
            $provinces = Province::select('id', 'name')->orderBy('name')->get();
            $cards = CardType::select('id', 'name')->orderBy('name')->get();
            $bloods = BloodType::select('id', 'name')->orderBy('name')->get();
            $religions = Religion::select('id', 'name')->orderBy('name')->get();
            $genders = Gender::select('id', 'name')->orderBy('name')->get();
            $works = Work::select('id', 'name')->orderBy('name')->get();
            $maritals = MaritalStatus::select('id', 'name')->orderBy('name')->get();
            $educations = Education::select('id', 'name')->orderBy('name')->get();

            Log::info('Data master berhasil dimuat untuk form pasien', [
                'countries_count' => $countries->count(),
                'provinces_count' => $provinces->count()
            ]);

            return view('pages.klinik.patients.create', compact([
                'countries', 'provinces', 'cards', 'bloods', 'religions',
                'genders', 'works', 'maritals', 'educations'
            ]));
        } catch (Throwable $e) {
            Log::error('Gagal memuat data master untuk form pasien', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors('Terjadi kesalahan saat memuat data form.');
        }
    }

    /**
     * Menyimpan pasien baru ke database
     *
     * @param SettingsInfoRequest $request
     * @return RedirectResponse
     */
    public function store(SettingsInfoRequest $request): RedirectResponse
    {
        Log::info('Memulai proses pembuatan pasien', [
            'user_id' => $this->user?->id,
            'data' => $request->only(['first_name', 'last_name', 'email', 'phone'])
        ]);

        if (is_null($this->user) || !$this->user->can('user.create')) {
            Log::warning('Akses ditolak untuk membuat pasien', [
                'user_id' => $this->user?->id,
                'permission' => 'user.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data pasien.');
        }

        // Validasi data user
        $userValidated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'email|max:255|nullable|unique:users,email',
            'phone' => 'string|nullable',
        ], [
            'first_name.required' => 'Nama depan wajib diisi.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'email.email' => 'Format email tidak valid.'
        ]);

        // Cek duplikasi NIK jika ada
        if ($request->filled('nik')) {
            $existingNik = UserInfo::where('nik', $request->nik)->first();
            if ($existingNik) {
                Log::warning('NIK sudah terdaftar', [
                    'nik' => $request->nik,
                    'existing_user_id' => $existingNik->user_id
                ]);

                return back()
                    ->withInput()
                    ->withErrors(['nik' => 'NIK sudah terdaftar dalam sistem.']);
            }
        }

        DB::beginTransaction();
        try {
            // Buat user baru
            $userValidated['password'] = Hash::make('default');
            $user = User::create($userValidated);

            Log::info('User berhasil dibuat', [
                'user_id' => $user->id,
                'user_name' => $user->name
            ]);

            // Assign role patient
            $patientRole = Role::where('name', 'patient')->first();
            if ($patientRole) {
                $user->assignRole($patientRole);
            } else {
                throw new Exception('Role patient tidak ditemukan.');
            }

            // Buat atau update user info
            $info = UserInfo::where('user_id', $user->id)->first();
            if ($info === null) {
                $info = new UserInfo();
            }

            $info->user()->associate($user->id);

            // Simpan data info dari request
            foreach ($request->only(array_keys($request->rules())) as $key => $value) {
                if (is_array($value)) {
                    $value = serialize($value);
                }
                $info->$key = $value;
            }

            // Handle upload foto
            if ($avatar = $this->upload()) {
                $info->photo = $avatar;
            }

            if ($request->boolean('avatar_remove')) {
                if ($info->photo) {
                    Storage::delete($info->photo);
                }
                $info->photo = null;
            }

            $info->save();

            Log::info('User info berhasil disimpan', [
                'user_id' => $user->id,
                'info_id' => $info->id
            ]);

            // Generate patient code
            $patient_id = IdGenerator::generate([
                'table' => 'patients',
                'field' => 'patient_code',
                'length' => 12,
                'prefix' => 'P' . date('Ymd')
            ]);

            // Buat patient record
            $patient = Patient::where('user_id', $user->id)->first();
            if ($patient === null) {
                $patient = new Patient();
            }

            // Integrasi SatuSehat jika diperlukan
            if (isset($patient->user->info) && !$request->his_number) {
                try {
                    $this->createSatuSehatPatient($patient);
                } catch (Exception $e) {
                    Log::warning('Gagal membuat patient di SatuSehat', [
                        'error' => $e->getMessage(),
                        'patient_id' => $patient->id
                    ]);
                    // Tidak menggagalkan proses utama
                }
            }

            $patient->user()->associate($user->id);
            $patient->his_number = $request->his_number;
            $patient->patient_code = $patient_id;
            $patient->register_date = date('Ymd');
            $patient->save();

            Log::info('Patient berhasil dibuat', [
                'patient_id' => $patient->id,
                'patient_code' => $patient->patient_code,
                'user_id' => $user->id
            ]);

            DB::commit();

            Log::info('Pasien berhasil dibuat lengkap', [
                'patient_id' => $patient->id,
                'user_id' => $this->user->id
            ]);

            return redirect()
                ->route('patients.index')
                ->with('success', 'Pasien berhasil didaftarkan!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal membuat pasien', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->user?->id,
                'data' => $userValidated ?? []
            ]);

            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat mendaftarkan pasien. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail pemeriksaan untuk print
     *
     * @param int $id
     * @return View
     */
    public function show(int $id)
    {
        Log::info('Mengakses detail pemeriksaan', [
            'examination_id' => $id,
            'user_id' => $this->user?->id
        ]);

        if (is_null($this->user) || !$this->user->can('user.read')) {
            Log::warning('Akses ditolak untuk melihat detail pemeriksaan', [
                'examination_id' => $id,
                'user_id' => $this->user?->id,
                'permission' => 'user.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat detail pemeriksaan.');
        }

        try {
            $examination = Examination::with(['patient.user.info', 'health_profesional.user.info'])
                ->findOrFail($id);

            return view('pages.klinik.patients.print', compact('examination'));
        } catch (Throwable $e) {
            Log::error('Gagal memuat detail pemeriksaan', [
                'examination_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->withErrors('Pemeriksaan tidak ditemukan.');
        }
    }

    /**
     * Print hasil pemeriksaan
     *
     * @param Request $request
     * @param int $id
     * @return View
     */
    public function print(Request $request, int $id)
    {
        Log::info('Print hasil pemeriksaan', [
            'examination_id' => $id,
            'user_id' => $this->user?->id,
            'jumlah' => $request->jumlah
        ]);

        if (is_null($this->user) || !$this->user->can('user.read')) {
            Log::warning('Akses ditolak untuk print pemeriksaan', [
                'examination_id' => $id,
                'user_id' => $this->user?->id,
                'permission' => 'user.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk print hasil pemeriksaan.');
        }

        try {
            $examination = Examination::with(['health_profesional.user.info'])
                ->findOrFail($id);

            $dokter = $examination->health_profesional;
            $dokterName = ($dokter->user->info->title_prefix ? $dokter->user->info->title_prefix . '. ' : '') .
                         $dokter->user->name .
                         ($dokter->user->info->title_suffix ? ', ' . $dokter->user->info->title_suffix : '');

            $jumlah = $request->jumlah;

            return view('pages.klinik.patients.print', compact([
                'examination', 'dokter' => $dokterName, 'jumlah'
            ]));
        } catch (Throwable $e) {
            Log::error('Gagal print pemeriksaan', [
                'examination_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->withErrors('Gagal memuat data untuk print.');
        }
    }

    /**
     * Menampilkan form untuk mengedit pasien
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        Log::info('Mengakses form edit pasien', [
            'user_id' => $id,
            'current_user_id' => $this->user?->id
        ]);

        if (is_null($this->user) || !$this->user->can('user.update')) {
            Log::warning('Akses ditolak untuk mengedit pasien', [
                'user_id' => $id,
                'current_user_id' => $this->user?->id,
                'permission' => 'user.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data pasien.');
        }

        try {
            $user = User::with(['info'])->findOrFail($id);
            $info = $user->info;

            $countries = Country::select('id', 'name')->orderBy('name')->get();
            $cards = CardType::select('id', 'name')->orderBy('name')->get();
            $bloods = BloodType::select('id', 'name')->orderBy('name')->get();
            $religions = Religion::select('id', 'name')->orderBy('name')->get();
            $genders = Gender::select('id', 'name')->orderBy('name')->get();
            $works = Work::select('id', 'name')->orderBy('name')->get();
            $maritals = MaritalStatus::select('id', 'name')->orderBy('name')->get();
            $educations = Education::select('id', 'name')->orderBy('name')->get();

            // Load data geografis berdasarkan pilihan yang ada
            $provinces = $info->country_id ?
                Province::where('country_id', $info->country_id)->select('id', 'name')->orderBy('name')->get() :
                Province::select('id', 'name')->orderBy('name')->get();

            $cities = $info->province_id ?
                City::where('province_id', $info->province_id)->select('id', 'name')->orderBy('name')->get() :
                collect();

            $districts = $info->city_id ?
                District::where('city_id', $info->city_id)->select('id', 'name')->orderBy('name')->get() :
                collect();

            $subdistricts = $info->district_id ?
                SubDistrict::where('district_id', $info->district_id)->select('id', 'name')->orderBy('name')->get() :
                collect();

            Log::info('Data edit pasien berhasil dimuat', [
                'user_id' => $user->id,
                'has_info' => !is_null($info)
            ]);

            return view('pages.klinik.patients.edit', compact([
                'user', 'countries', 'provinces', 'cards', 'bloods', 'religions',
                'genders', 'works', 'maritals', 'educations', 'info',
                'cities', 'districts', 'subdistricts'
            ]));

        } catch (Throwable $e) {
            Log::error('Gagal memuat data edit pasien', [
                'user_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('patients.index')
                ->withErrors('Pasien tidak ditemukan atau terjadi kesalahan.');
        }
    }

    /**
     * Memperbarui data pasien di database
     *
     * @param SettingsInfoRequest $request
     * @return RedirectResponse
     */
    public function update(SettingsInfoRequest $request): RedirectResponse
    {
        Log::info('Memulai proses update pasien', [
            'user_id' => $request->user,
            'current_user_id' => $this->user?->id,
            'data' => $request->only(['first_name', 'last_name', 'email', 'phone'])
        ]);

        if (is_null($this->user) || !$this->user->can('user.update')) {
            Log::warning('Akses ditolak untuk update pasien', [
                'user_id' => $request->user,
                'current_user_id' => $this->user?->id,
                'permission' => 'user.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data pasien.');
        }

        // Validasi data user
        $userValidated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'email|max:255|nullable|unique:users,email,' . $request->user,
            'phone' => 'string|nullable',
        ], [
            'first_name.required' => 'Nama depan wajib diisi.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'email.email' => 'Format email tidak valid.'
        ]);

        // Cek duplikasi NIK jika ada (kecuali user saat ini)
        if ($request->filled('nik')) {
            $existingNik = UserInfo::where('nik', $request->nik)
                ->where('user_id', '!=', $request->user)
                ->first();
            if ($existingNik) {
                Log::warning('NIK sudah terdaftar saat update', [
                    'nik' => $request->nik,
                    'existing_user_id' => $existingNik->user_id,
                    'current_user_id' => $request->user
                ]);

                return back()
                    ->withInput()
                    ->withErrors(['nik' => 'NIK sudah terdaftar dalam sistem.']);
            }
        }

        DB::beginTransaction();
        try {
            $user = User::findOrFail($request->user);
            $user->update($userValidated);

            Log::info('Data user berhasil diupdate', [
                'user_id' => $user->id,
                'user_name' => $user->name
            ]);

            // Assign role patient jika belum ada
            $patientRole = Role::where('name', 'patient')->first();
            if ($patientRole && !$user->hasRole('patient')) {
                $user->assignRole($patientRole);
            }

            // Update user info
            $info = UserInfo::where('user_id', $user->id)->first();
            if ($info === null) {
                $info = new UserInfo();
            }

            $info->user()->associate($user->id);

            // Simpan data info dari request
            foreach ($request->only(array_keys($request->rules())) as $key => $value) {
                if (is_array($value)) {
                    $value = serialize($value);
                }
                $info->$key = $value;
            }

            // Handle upload foto
            if ($avatar = $this->upload()) {
                // Hapus foto lama jika ada
                if ($info->photo) {
                    Storage::delete($info->photo);
                }
                $info->photo = $avatar;
            }

            if ($request->boolean('avatar_remove')) {
                if ($info->photo) {
                    Storage::delete($info->photo);
                }
                $info->photo = null;
            }

            $info->save();

            Log::info('User info berhasil diupdate', [
                'user_id' => $user->id,
                'info_id' => $info->id
            ]);

            DB::commit();

            Log::info('Pasien berhasil diupdate', [
                'user_id' => $user->id,
                'current_user_id' => $this->user->id
            ]);

            return redirect()
                ->route('patients.index')
                ->with('success', 'Data pasien berhasil diperbarui!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal update pasien', [
                'user_id' => $request->user,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'current_user_id' => $this->user?->id,
                'data' => $userValidated ?? []
            ]);

            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat memperbarui data pasien. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus pasien dari database
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Log::info('Memulai proses hapus pasien', [
            'user_id' => $id,
            'current_user_id' => $this->user?->id
        ]);

        if (is_null($this->user) || !$this->user->can('user.delete')) {
            Log::warning('Akses ditolak untuk hapus pasien', [
                'user_id' => $id,
                'current_user_id' => $this->user?->id,
                'permission' => 'user.delete'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk menghapus data pasien.');
        }

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $info = UserInfo::where('user_id', $user->id)->first();
            $patient = Patient::where('user_id', $user->id)->first();

            // Hapus foto jika ada
            if ($info && $info->photo) {
                Storage::delete($info->photo);
            }

            // Hapus data terkait
            if ($patient) {
                $patient->delete();
            }

            if ($info) {
                $info->delete();
            }

            $user->delete();

            DB::commit();

            Log::info('Pasien berhasil dihapus', [
                'user_id' => $id,
                'current_user_id' => $this->user->id
            ]);

            return redirect()
                ->route('patients.index')
                ->with('success', 'Data pasien berhasil dihapus!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal menghapus pasien', [
                'user_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'current_user_id' => $this->user?->id
            ]);

            return back()->withErrors('Terjadi kesalahan saat menghapus data pasien. Silakan coba lagi.');
        }
    }

    /**
     * Menyimpan data pemeriksaan awal
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function pretest(Request $request): RedirectResponse
    {
        Log::info('Menyimpan data pemeriksaan awal', [
            'user_id' => $this->user?->id,
            'data' => $request->all()
        ]);

        try {
            $validated = $request->validate([
                // Tambahkan validasi sesuai kebutuhan
            ]);

            PemeriksaanAwal::create($request->all());

            Log::info('Pemeriksaan awal berhasil disimpan');

            return redirect()
                ->intended('klinik/patients')
                ->with('success', 'Data pemeriksaan awal berhasil disimpan!');

        } catch (Throwable $e) {
            Log::error('Gagal menyimpan pemeriksaan awal', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat menyimpan data pemeriksaan awal.');
        }
    }

    /**
     * Cek NIK di sistem SatuSehat
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function check_nik(Request $request): JsonResponse
    {
        Log::info('Cek NIK di SatuSehat', [
            'nik' => $request->nik,
            'user_id' => $this->user?->id
        ]);

        try {
            $request->validate([
                'nik' => 'required|string|digits:16'
            ], [
                'nik.required' => 'NIK wajib diisi.',
                'nik.digits' => 'NIK harus 16 digit.'
            ]);

            $nik = $request->nik;

            if (cekNIK($nik)) {
                $satusehat = satu_sehat('get', 'Patient?identifier=https://fhir.kemkes.go.id/id/nik|' . $nik, '');
                $response = json_decode($satusehat);
                $his = $response->entry[0]->resource->id ?? "";

                Log::info('NIK ditemukan di SatuSehat', [
                    'nik' => $nik,
                    'his_id' => $his
                ]);

                return response()->json([
                    'success' => true,
                    'data' => $his,
                    'message' => 'NIK ditemukan di SatuSehat'
                ]);
            }

            Log::info('NIK tidak ditemukan di SatuSehat', ['nik' => $nik]);

            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'NIK tidak ditemukan di SatuSehat'
            ]);

        } catch (Throwable $e) {
            Log::error('Gagal cek NIK di SatuSehat', [
                'nik' => $request->nik,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'Terjadi kesalahan saat mengecek NIK'
            ]);
        }
    }

    /**
     * Upload file foto/avatar
     *
     * @param string $folder
     * @param string $key
     * @param string $validation
     * @return string|null
     */
    private function upload(
        string $folder = 'images',
        string $key = 'photo',
        string $validation = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|sometimes'
    ): ?string {
        try {
            request()->validate([$key => $validation]);

            $file = null;
            if (request()->hasFile($key)) {
                $file = Storage::disk('public')->putFile($folder, request()->file($key), 'public');

                Log::info('File berhasil diupload', [
                    'file_path' => $file,
                    'folder' => $folder
                ]);
            }

            return $file;
        } catch (Throwable $e) {
            Log::error('Gagal upload file', [
                'error' => $e->getMessage(),
                'folder' => $folder,
                'key' => $key
            ]);

            return null;
        }
    }

    /**
     * Membuat patient di SatuSehat
     *
     * @param Patient $patient
     * @return void
     * @throws Exception
     */
    private function createSatuSehatPatient(Patient $patient): void
    {
        if (!isset($patient->user->info)) {
            throw new Exception('Data info pasien tidak lengkap untuk SatuSehat.');
        }

        $patientSatuSehat = [
            "resourceType" => "Patient",
            "meta" => [
                "profile" => [
                    "https://fhir.kemkes.go.id/r4/StructureDefinition/Patient"
                ]
            ],
            "identifier" => [
                [
                    "use" => "official",
                    "system" => "https://fhir.kemkes.go.id/id/nik",
                    "value" => $patient->user->info->nik ?? ''
                ],
                [
                    "use" => "official",
                    "system" => "https://fhir.kemkes.go.id/id/paspor",
                    "value" => $patient->user->info->paspor ?? ''
                ],
                [
                    "use" => "official",
                    "system" => "https://fhir.kemkes.go.id/id/kk",
                    "value" => $patient->user->info->kk ?? ''
                ]
            ],
            "active" => true,
            "name" => [
                [
                    "use" => "official",
                    "text" => $patient->user->name ?? $patient->user->info->first_name . ' ' . $patient->user->info->last_name,
                ]
            ],
            "telecom" => [
                [
                    "system" => "phone",
                    "value" => $patient->user->info->phone ?? '',
                    "use" => "mobile"
                ],
                [
                    "system" => "email",
                    "value" => $patient->user->email ?? '',
                    "use" => "home"
                ]
            ],
            "gender" => $patient->user->info->gender->name ?? '',
            "birthDate" => $patient->user->info->birth_date ?? '',
            "deceasedBoolean" => false,
            "address" => [
                [
                    "use" => "home",
                    "line" => [
                        $patient->user->info->address ?? ''
                    ],
                    "city" => $patient->user->info->city->name ?? 'Jakarta',
                    "postalCode" => $patient->user->info->postal_code ?? '12950',
                    "country" => "ID",
                    "extension" => [
                        [
                            "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                            "extension" => [
                                [
                                    "url" => "province",
                                    "valueCode" => $patient->user->info->province->code ?? ''
                                ],
                                [
                                    "url" => "city",
                                    "valueCode" => $patient->user->info->city->code ?? ''
                                ],
                                [
                                    "url" => "district",
                                    "valueCode" => $patient->user->info->district->code ?? ''
                                ],
                                [
                                    "url" => "village",
                                    "valueCode" => $patient->user->info->subdistrict->code ?? ''
                                ],
                                [
                                    "url" => "rt",
                                    "valueCode" => $patient->user->info->rt ?? ''
                                ],
                                [
                                    "url" => "rw",
                                    "valueCode" => $patient->user->info->rw ?? ''
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $satusehat = satu_sehat('create', 'Patient', '', $patientSatuSehat);

        Log::info('Patient berhasil dibuat di SatuSehat', [
            'patient_id' => $patient->id,
            'satusehat_response' => $satusehat
        ]);
    }
}
