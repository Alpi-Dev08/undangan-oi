<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\NakesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\SettingsInfoRequest;
use App\Models\Klinik\HealthProfesional;
use App\Models\Klinik\HealthProfesionalType;
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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Throwable;

/**
 * Controller untuk mengelola data tenaga kesehatan (Health Professionals)
 *
 * Menangani operasi CRUD untuk tenaga kesehatan termasuk:
 * - Manajemen data user dan info user
 * - Manajemen data health professional
 * - Integrasi dengan sistem role dan permission
 */
class HealthProfesionalsController extends Controller
{
    private ?User $user;

    /**
     * Konstruktor controller dengan middleware otentikasi dan otorisasi
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function (Request $request, $next) {
            $this->user = Auth::guard('web')->user();

            Log::info('HealthProfesionalsController accessed', [
                'user_id' => $this->user?->id,
                'action' => $request->route()?->getActionName(),
                'ip' => $request->ip()
            ]);

            return $next($request);
        });
    }

    /**
     * Menampilkan daftar tenaga kesehatan
     *
     * @param NakesDataTable $dataTable
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(NakesDataTable $dataTable): View|JsonResponse
    {
        if (is_null($this->user) || !$this->user->can('user.read')) {
            Log::warning('Unauthorized access attempt to health professionals index', [
                'user_id' => $this->user?->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to view any health professionals !');
        }

        Log::info('Health professionals index accessed', [
            'user_id' => $this->user->id
        ]);

        return $dataTable->render('pages.klinik.healthprofesionals.index');
    }

    /**
     * Menampilkan form untuk membuat tenaga kesehatan baru
     *
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('user.create')) {
            Log::warning('Unauthorized access attempt to create health professional', [
                'user_id' => $this->user?->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to create any health professionals !');
        }

        try {
            $data = $this->getFormData();

            Log::info('Health professional create form accessed', [
                'user_id' => $this->user->id
            ]);

            return view('pages.klinik.healthprofesionals.create', $data);
        } catch (Throwable $e) {
            Log::error('Error loading health professional create form', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memuat form. Silakan coba lagi.');
        }
    }

    /**
     * Menyimpan tenaga kesehatan baru
     *
     * @param SettingsInfoRequest $request
     * @return RedirectResponse
     */
    public function store(SettingsInfoRequest $request): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('user.create')) {
            Log::warning('Unauthorized access attempt to store health professional', [
                'user_id' => $this->user?->id,
                'ip' => $request->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to create any health professionals !');
        }

        DB::beginTransaction();

        try {
            // Validasi data user
            $userValidated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'email'      => 'required|email|max:255|unique:users,email',
                'phone'      => 'nullable|string|max:20'
            ]);

            // Set password default
            $userValidated['password'] = Hash::make('default');

            // Buat user baru
            $user = User::create($userValidated);

            // Assign role nakes
            $nakesRole = Role::where('name', 'nakes')->first();
            if ($nakesRole) {
                $user->assignRole($nakesRole);
            }

            // Buat health professional record
            HealthProfesional::create([
                'user_id' => $user->id,
                'health_profesional_type_id' => $request->health_profesional_type_id
            ]);

            // Simpan user info
            $this->saveUserInfo($user, $request);

            DB::commit();

            Log::info('Health professional created successfully', [
                'user_id' => $this->user->id,
                'created_user_id' => $user->id,
                'email' => $user->email
            ]);

            return redirect()->route('healthprofesionals.index')
                ->with('success', 'Tenaga kesehatan berhasil ditambahkan!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Error creating health professional', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password'])
            ]);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail tenaga kesehatan
     *
     * @param HealthProfesional $healthprofesional
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(HealthProfesional $healthprofesional)
    {
        if (is_null($this->user) || !$this->user->can('user.read')) {
            Log::warning('Unauthorized access attempt to view health professional', [
                'user_id' => $this->user?->id,
                'health_professional_id' => $healthprofesional->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to view this health professional !');
        }

        try {
            $healthprofesional->load(['user.info', 'type', 'speciality']);

            Log::info('Health professional detail viewed', [
                'user_id' => $this->user->id,
                'health_professional_id' => $healthprofesional->id
            ]);

            return view('pages.klinik.healthprofesionals.show', compact('healthprofesional'));
        } catch (Throwable $e) {
            Log::error('Error loading health professional detail', [
                'user_id' => $this->user->id,
                'health_professional_id' => $healthprofesional->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memuat detail. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan form edit tenaga kesehatan
     *
     * @param HealthProfesional $healthprofesional
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(HealthProfesional $healthprofesional)
    {
        if (is_null($this->user) || !$this->user->can('user.update')) {
            Log::warning('Unauthorized access attempt to edit health professional', [
                'user_id' => $this->user?->id,
                'health_professional_id' => $healthprofesional->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to update any health professionals !');
        }

        try {
            $user = $healthprofesional->user()->with('info')->first();
            $info = $user->info;

            $data = $this->getFormData($info);
            $data['user'] = $user;
            $data['info'] = $info;
            $data['healthprofesional'] = $healthprofesional;

            Log::info('Health professional edit form accessed', [
                'user_id' => $this->user->id,
                'health_professional_id' => $healthprofesional->id
            ]);

            return view('pages.klinik.healthprofesionals.edit', $data);
        } catch (Throwable $e) {
            Log::error('Error loading health professional edit form', [
                'user_id' => $this->user->id,
                'health_professional_id' => $healthprofesional->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memuat form edit. Silakan coba lagi.');
        }
    }

    /**
     * Memperbarui data tenaga kesehatan
     *
     * @param SettingsInfoRequest $request
     * @param HealthProfesional $healthprofesional
     * @return RedirectResponse
     */
    public function update(SettingsInfoRequest $request, HealthProfesional $healthprofesional): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('user.update')) {
            Log::warning('Unauthorized access attempt to update health professional', [
                'user_id' => $this->user?->id,
                'health_professional_id' => $healthprofesional->id,
                'ip' => $request->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to update any health professionals !');
        }

        DB::beginTransaction();

        try {
            $user = $healthprofesional->user;

            // Validasi data user
            $userValidated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'email'      => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone'      => 'nullable|string|max:20'
            ]);

            // Update user
            $user->update($userValidated);

            // Update health professional type
            $healthprofesional->update([
                'health_profesional_type_id' => $request->health_profesional_type_id
            ]);

            // Update user info
            $this->saveUserInfo($user, $request);

            DB::commit();

            Log::info('Health professional updated successfully', [
                'user_id' => $this->user->id,
                'updated_user_id' => $user->id,
                'health_professional_id' => $healthprofesional->id
            ]);

            return redirect()->route('healthprofesionals.index')
                ->with('success', 'Data tenaga kesehatan berhasil diperbarui!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Error updating health professional', [
                'user_id' => $this->user->id,
                'health_professional_id' => $healthprofesional->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus tenaga kesehatan
     *
     * @param HealthProfesional $healthprofesional
     * @return RedirectResponse
     */
    public function destroy(HealthProfesional $healthprofesional): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('user.delete')) {
            Log::warning('Unauthorized access attempt to delete health professional', [
                'user_id' => $this->user?->id,
                'health_professional_id' => $healthprofesional->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to delete any health professionals !');
        }

        DB::beginTransaction();

        try {
            $user = $healthprofesional->user;
            $userInfo = $user->info;

            // Cek apakah user masih memiliki relasi aktif
            // Tambahkan pengecekan relasi lain jika diperlukan

            // Hapus health professional record
            $healthprofesional->delete();

            // Hapus user info jika ada
            if ($userInfo) {
                $userInfo->delete();
            }

            // Hapus user
            $user->delete();

            DB::commit();

            Log::info('Health professional deleted successfully', [
                'user_id' => $this->user->id,
                'deleted_user_id' => $user->id,
                'health_professional_id' => $healthprofesional->id
            ]);

            return redirect()->route('healthprofesionals.index')
                ->with('success', 'Tenaga kesehatan berhasil dihapus!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Error deleting health professional', [
                'user_id' => $this->user->id,
                'health_professional_id' => $healthprofesional->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
        }
    }

    /**
     * Mengambil data untuk form (create/edit)
     *
     * @param UserInfo|null $info
     * @return array
     */
    private function getFormData(?UserInfo $info = null): array
    {
        $data = [
            'countries' => Country::all(),
            'provinces' => Province::all(),
            'cards' => CardType::all(),
            'bloods' => BloodType::all(),
            'religions' => Religion::all(),
            'genders' => Gender::all(),
            'works' => Work::all(),
            'maritals' => MaritalStatus::all(),
            'educations' => Education::all(),
            'practitionerTypes' => HealthProfesionalType::all(),
            'cities' => null,
            'districts' => null,
            'subdistricts' => null
        ];

        if ($info) {
            // Load data berdasarkan info yang ada
            if ($info->country_id) {
                $data['provinces'] = Province::where('country_id', $info->country_id)->get();
            }
            if ($info->province_id) {
                $data['cities'] = City::where('province_id', $info->province_id)->get();
            }
            if ($info->city_id) {
                $data['districts'] = District::where('city_id', $info->city_id)->get();
            }
            if ($info->district_id) {
                $data['subdistricts'] = SubDistrict::where('district_id', $info->district_id)->get();
            }
        }

        return $data;
    }

    /**
     * Menyimpan atau memperbarui user info
     *
     * @param User $user
     * @param SettingsInfoRequest $request
     * @return void
     */
    private function saveUserInfo(User $user, SettingsInfoRequest $request): void
    {
        $info = UserInfo::where('user_id', $user->id)->first();

        if (!$info) {
            $info = new UserInfo();
            $info->user()->associate($user->id);
        }

        // Simpan data dari request
        foreach ($request->only(array_keys($request->rules())) as $key => $value) {
            if (is_array($value)) {
                $value = serialize($value);
            }
            $info->$key = $value;
        }

        $info->save();
    }
}
