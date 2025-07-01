<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\HealthcaresDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klinik\Healthcare;
use App\Http\Requests\Klinik\StoreHealthcareRequest;
use App\Http\Requests\Klinik\UpdateHealthcareRequest;
use App\Models\Klinik\HealthcareCategory;
use App\Models\Klinik\HealthcareType;
use App\Models\Master\City;
use App\Models\Master\Country;
use App\Models\Master\District;
use App\Models\Master\Province;
use App\Models\Master\SubDistrict;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Controller untuk mengelola data layanan kesehatan
 *
 * Menangani operasi CRUD untuk entitas Healthcare termasuk
 * validasi data, logging aktivitas, dan penanganan error
 */
class HealthcaresController extends Controller
{
    /**
     * Instance pengguna yang sedang login
     */
    public ?object $user;

    /**
     * Konstruktor controller
     *
     * Mengatur middleware otentikasi dan otorisasi
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function (Request $request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar layanan kesehatan
     *
     * @param HealthcaresDataTable $dataTable Instance DataTable untuk menampilkan data
     * @return Response|View
     */
    public function index(HealthcaresDataTable $dataTable): Response|View
    {
        // Log aktivitas akses halaman index
        Log::info('User mengakses halaman daftar layanan kesehatan', [
            'user_id' => $this->user?->id,
            'user_email' => $this->user?->email
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Akses ditolak untuk melihat daftar layanan kesehatan', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data master!');
        }

        return $dataTable->render('pages.klinik.healthcares.index');
    }

    /**
     * Menampilkan form untuk membuat layanan kesehatan baru
     *
     * @return Response|View
     */
    public function create()
    {
        // Log aktivitas akses form create
        Log::info('User mengakses form pembuatan layanan kesehatan', [
            'user_id' => $this->user?->id
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk membuat layanan kesehatan', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data master!');
        }

        try {
            // Ambil data referensi untuk form
            $categories = HealthcareCategory::all();
            $types = HealthcareType::all();
            $countries = Country::all();
            $provinces = Province::all();

            Log::info('Data referensi berhasil dimuat untuk form create layanan kesehatan');

            return view('pages.klinik.healthcares.create', compact(
                'categories',
                'types',
                'countries',
                'provinces'
            ));
        } catch (Exception $e) {
            Log::error('Gagal memuat data referensi untuk form create layanan kesehatan', [
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcares.index')
                ->with('error', 'Gagal memuat form pembuatan layanan kesehatan!');
        }
    }

    /**
     * Menyimpan layanan kesehatan baru ke database
     *
     * @param StoreHealthcareRequest $request Request yang sudah divalidasi
     * @return RedirectResponse
     */
    public function store(StoreHealthcareRequest $request): RedirectResponse
    {
        // Log aktivitas penyimpanan
        Log::info('User mencoba menyimpan layanan kesehatan baru', [
            'user_id' => $this->user?->id,
            'data' => $request->validated()
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk menyimpan layanan kesehatan', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data master!');
        }

        // Ambil data yang sudah divalidasi
        $validated = $request->validated();

        // Gunakan transaksi database
        DB::beginTransaction();

        try {
            // Simpan data layanan kesehatan
            $healthcare = Healthcare::create($validated);

            // Commit transaksi
            DB::commit();

            Log::info('Layanan kesehatan berhasil disimpan', [
                'healthcare_id' => $healthcare->id,
                'healthcare_name' => $healthcare->name,
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcares.index')
                ->with('success', 'Layanan kesehatan berhasil dibuat!');

        } catch (Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            Log::error('Gagal menyimpan layanan kesehatan', [
                'error' => $e->getMessage(),
                'data' => $validated,
                'user_id' => $this->user?->id
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan layanan kesehatan! Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail layanan kesehatan tertentu
     *
     * @param Healthcare $healthcare Instance model Healthcare
     * @return Response|View
     */
    public function show(Healthcare $healthcare)
    {
        // Log aktivitas akses detail
        Log::info('User mengakses detail layanan kesehatan', [
            'healthcare_id' => $healthcare->id,
            'healthcare_name' => $healthcare->name,
            'user_id' => $this->user?->id
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Akses ditolak untuk melihat detail layanan kesehatan', [
                'healthcare_id' => $healthcare->id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data master!');
        }

        try {
            // Load relasi yang diperlukan
            $healthcare->load([
                'category',
                'type',
                'country',
                'province',
                'city',
                'district',
                'subDistrict'
            ]);

            return view('pages.klinik.healthcares.show', compact('healthcare'));
        } catch (Exception $e) {
            Log::error('Gagal memuat detail layanan kesehatan', [
                'healthcare_id' => $healthcare->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcares.index')
                ->with('error', 'Gagal memuat detail layanan kesehatan!');
        }
    }

    /**
     * Menampilkan form untuk mengedit layanan kesehatan
     *
     * @param Healthcare $healthcare Instance model Healthcare
     * @return Response|View
     */
    public function edit(Healthcare $healthcare)
    {
        // Log aktivitas akses form edit
        Log::info('User mengakses form edit layanan kesehatan', [
            'healthcare_id' => $healthcare->id,
            'healthcare_name' => $healthcare->name,
            'user_id' => $this->user?->id
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk mengedit layanan kesehatan', [
                'healthcare_id' => $healthcare->id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data master!');
        }

        try {
            // Ambil data referensi untuk form
            $categories = HealthcareCategory::all();
            $types = HealthcareType::all();
            $countries = Country::all();
            $provinces = Province::where('country_id', $healthcare->country_id)->get();
            $cities = City::where('province_id', $healthcare->province_id)->get();
            $districts = District::where('city_id', $healthcare->city_id)->get();
            $subdistricts = SubDistrict::where('district_id', $healthcare->district_id)->get();

            Log::info('Data referensi berhasil dimuat untuk form edit layanan kesehatan', [
                'healthcare_id' => $healthcare->id
            ]);

            return view('pages.klinik.healthcares.edit', compact(
                'healthcare',
                'categories',
                'types',
                'countries',
                'provinces',
                'cities',
                'districts',
                'subdistricts'
            ));
        } catch (Exception $e) {
            Log::error('Gagal memuat data referensi untuk form edit layanan kesehatan', [
                'healthcare_id' => $healthcare->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcares.index')
                ->with('error', 'Gagal memuat form edit layanan kesehatan!');
        }
    }

    /**
     * Memperbarui layanan kesehatan di database
     *
     * @param UpdateHealthcareRequest $request Request yang sudah divalidasi
     * @param Healthcare $healthcare Instance model Healthcare
     * @return RedirectResponse
     */
    public function update(UpdateHealthcareRequest $request, Healthcare $healthcare): RedirectResponse
    {
        // Log aktivitas update
        Log::info('User mencoba memperbarui layanan kesehatan', [
            'healthcare_id' => $healthcare->id,
            'healthcare_name' => $healthcare->name,
            'user_id' => $this->user?->id,
            'data' => $request->validated()
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk memperbarui layanan kesehatan', [
                'healthcare_id' => $healthcare->id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data master!');
        }

        // Ambil data yang sudah divalidasi
        $validated = $request->validated();

        // Simpan data lama untuk logging
        $oldData = $healthcare->toArray();

        // Gunakan transaksi database
        DB::beginTransaction();

        try {
            // Update data layanan kesehatan
            $healthcare->update($validated);

            // Commit transaksi
            DB::commit();

            Log::info('Layanan kesehatan berhasil diperbarui', [
                'healthcare_id' => $healthcare->id,
                'healthcare_name' => $healthcare->name,
                'old_data' => $oldData,
                'new_data' => $validated,
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcares.index')
                ->with('success', 'Layanan kesehatan berhasil diperbarui!');

        } catch (Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            Log::error('Gagal memperbarui layanan kesehatan', [
                'healthcare_id' => $healthcare->id,
                'error' => $e->getMessage(),
                'data' => $validated,
                'user_id' => $this->user?->id
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui layanan kesehatan! Silakan coba lagi.');
        }
    }

    /**
     * Menghapus layanan kesehatan dari database
     *
     * @param Healthcare $healthcare Instance model Healthcare
     * @return RedirectResponse
     */
    public function destroy(Healthcare $healthcare): RedirectResponse
    {
        // Log aktivitas penghapusan
        Log::info('User mencoba menghapus layanan kesehatan', [
            'healthcare_id' => $healthcare->id,
            'healthcare_name' => $healthcare->name,
            'user_id' => $this->user?->id
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Akses ditolak untuk menghapus layanan kesehatan', [
                'healthcare_id' => $healthcare->id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.delete'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk menghapus data master!');
        }

        // Simpan data untuk logging
        $healthcareData = $healthcare->toArray();

        // Gunakan transaksi database
        DB::beginTransaction();

        try {
            // Hapus layanan kesehatan (soft delete)
            $healthcare->delete();

            // Commit transaksi
            DB::commit();

            Log::info('Layanan kesehatan berhasil dihapus', [
                'healthcare_data' => $healthcareData,
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcares.index')
                ->with('success', 'Layanan kesehatan berhasil dihapus!');

        } catch (Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            Log::error('Gagal menghapus layanan kesehatan', [
                'healthcare_id' => $healthcare->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcares.index')
                ->with('error', 'Gagal menghapus layanan kesehatan! Silakan coba lagi.');
        }
    }
}
