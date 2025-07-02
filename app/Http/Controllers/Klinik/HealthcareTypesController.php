<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\HealthcareTypesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klinik\HealthcareType;
use App\Http\Requests\Klinik\StoreHealthcareTypeRequest;
use App\Http\Requests\Klinik\UpdateHealthcareTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Controller untuk mengelola data tipe layanan kesehatan
 *
 * Menangani operasi CRUD untuk entitas HealthcareType termasuk
 * validasi data, logging aktivitas, dan penanganan error
 */
class HealthcareTypesController extends Controller
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
     * Menampilkan daftar tipe layanan kesehatan
     *
     * @param HealthcareTypesDataTable $dataTable Instance DataTable untuk menampilkan data
     * @return Response|View
     */
    public function index(HealthcareTypesDataTable $dataTable): JsonResponse|View
    {
        // Log aktivitas akses halaman index
        Log::info('User mengakses halaman daftar tipe layanan kesehatan', [
            'user_id' => $this->user?->id,
            'user_email' => $this->user?->email
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Akses ditolak untuk melihat daftar tipe layanan kesehatan', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data master!');
        }

        return $dataTable->render('pages.klinik.healthcaretypes.index');
    }

    /**
     * Menampilkan form untuk membuat tipe layanan kesehatan baru
     *
     * @return Response|View
     */
    public function create(): Response|View
    {
        // Log aktivitas akses form create
        Log::info('User mengakses form pembuatan tipe layanan kesehatan', [
            'user_id' => $this->user?->id
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk membuat tipe layanan kesehatan', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data master!');
        }

        return view('pages.klinik.healthcaretypes.create');
    }

    /**
     * Menyimpan tipe layanan kesehatan baru ke database
     *
     * @param StoreHealthcareTypeRequest $request Request yang sudah divalidasi
     * @return RedirectResponse
     */
    public function store(StoreHealthcareTypeRequest $request): RedirectResponse
    {
        // Log aktivitas penyimpanan
        Log::info('User mencoba menyimpan tipe layanan kesehatan baru', [
            'user_id' => $this->user?->id,
            'data' => $request->validated()
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk menyimpan tipe layanan kesehatan', [
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
            // Simpan data tipe layanan kesehatan
            $healthcareType = HealthcareType::create($validated);

            // Commit transaksi
            DB::commit();

            Log::info('Tipe layanan kesehatan berhasil disimpan', [
                'healthcare_type_id' => $healthcareType->id,
                'healthcare_type_name' => $healthcareType->name,
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcaretypes.index')
                ->with('success', 'Tipe layanan kesehatan berhasil dibuat!');

        } catch (Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            Log::error('Gagal menyimpan tipe layanan kesehatan', [
                'error' => $e->getMessage(),
                'data' => $validated,
                'user_id' => $this->user?->id
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan tipe layanan kesehatan! Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail tipe layanan kesehatan tertentu
     *
     * @param HealthcareType $healthcaretype Instance model HealthcareType
     * @return Response|View
     */
    public function show(HealthcareType $healthcaretype)
    {
        // Log aktivitas akses detail
        Log::info('User mengakses detail tipe layanan kesehatan', [
            'healthcare_type_id' => $healthcaretype->id,
            'healthcare_type_name' => $healthcaretype->name,
            'user_id' => $this->user?->id
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Akses ditolak untuk melihat detail tipe layanan kesehatan', [
                'healthcare_type_id' => $healthcaretype->id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data master!');
        }

        try {
            // Load relasi yang diperlukan
            $healthcaretype->load(['healthcare']);

            return view('pages.klinik.healthcaretypes.show', compact('healthcaretype'));
        } catch (Exception $e) {
            Log::error('Gagal memuat detail tipe layanan kesehatan', [
                'healthcare_type_id' => $healthcaretype->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcaretypes.index')
                ->with('error', 'Gagal memuat detail tipe layanan kesehatan!');
        }
    }

    /**
     * Menampilkan form untuk mengedit tipe layanan kesehatan
     *
     * @param HealthcareType $healthcaretype Instance model HealthcareType
     * @return Response|View
     */
    public function edit(HealthcareType $healthcaretype): Response|View
    {
        // Log aktivitas akses form edit
        Log::info('User mengakses form edit tipe layanan kesehatan', [
            'healthcare_type_id' => $healthcaretype->id,
            'healthcare_type_name' => $healthcaretype->name,
            'user_id' => $this->user?->id
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk mengedit tipe layanan kesehatan', [
                'healthcare_type_id' => $healthcaretype->id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data master!');
        }

        return view('pages.klinik.healthcaretypes.edit', compact('healthcaretype'));
    }

    /**
     * Memperbarui tipe layanan kesehatan di database
     *
     * @param UpdateHealthcareTypeRequest $request Request yang sudah divalidasi
     * @param HealthcareType $healthcaretype Instance model HealthcareType
     * @return RedirectResponse
     */
    public function update(UpdateHealthcareTypeRequest $request, HealthcareType $healthcaretype): RedirectResponse
    {
        // Log aktivitas update
        Log::info('User mencoba memperbarui tipe layanan kesehatan', [
            'healthcare_type_id' => $healthcaretype->id,
            'healthcare_type_name' => $healthcaretype->name,
            'user_id' => $this->user?->id,
            'data' => $request->validated()
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk memperbarui tipe layanan kesehatan', [
                'healthcare_type_id' => $healthcaretype->id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data master!');
        }

        // Ambil data yang sudah divalidasi
        $validated = $request->validated();

        // Simpan data lama untuk logging
        $oldData = $healthcaretype->toArray();

        // Gunakan transaksi database
        DB::beginTransaction();

        try {
            // Update data tipe layanan kesehatan
            $healthcaretype->update($validated);

            // Commit transaksi
            DB::commit();

            Log::info('Tipe layanan kesehatan berhasil diperbarui', [
                'healthcare_type_id' => $healthcaretype->id,
                'healthcare_type_name' => $healthcaretype->name,
                'old_data' => $oldData,
                'new_data' => $validated,
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcaretypes.index')
                ->with('success', 'Tipe layanan kesehatan berhasil diperbarui!');

        } catch (Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            Log::error('Gagal memperbarui tipe layanan kesehatan', [
                'healthcare_type_id' => $healthcaretype->id,
                'error' => $e->getMessage(),
                'data' => $validated,
                'user_id' => $this->user?->id
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui tipe layanan kesehatan! Silakan coba lagi.');
        }
    }

    /**
     * Menghapus tipe layanan kesehatan dari database
     *
     * @param HealthcareType $healthcaretype Instance model HealthcareType
     * @return RedirectResponse
     */
    public function destroy(HealthcareType $healthcaretype): RedirectResponse
    {
        // Log aktivitas penghapusan
        Log::info('User mencoba menghapus tipe layanan kesehatan', [
            'healthcare_type_id' => $healthcaretype->id,
            'healthcare_type_name' => $healthcaretype->name,
            'user_id' => $this->user?->id
        ]);

        // Periksa otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Akses ditolak untuk menghapus tipe layanan kesehatan', [
                'healthcare_type_id' => $healthcaretype->id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.delete'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk menghapus data master!');
        }

        // Simpan data untuk logging
        $healthcareTypeData = $healthcaretype->toArray();

        // Gunakan transaksi database
        DB::beginTransaction();

        try {
            // Periksa apakah tipe layanan kesehatan masih digunakan
            $healthcareCount = $healthcaretype->healthcare()->count();

            if ($healthcareCount > 0) {
                Log::warning('Gagal menghapus tipe layanan kesehatan karena masih digunakan', [
                    'healthcare_type_id' => $healthcaretype->id,
                    'healthcare_count' => $healthcareCount,
                    'user_id' => $this->user?->id
                ]);

                return redirect()->route('healthcaretypes.index')
                    ->with('error', 'Tipe layanan kesehatan tidak dapat dihapus karena masih digunakan oleh ' . $healthcareCount . ' layanan kesehatan!');
            }

            // Hapus tipe layanan kesehatan (soft delete)
            $healthcaretype->delete();

            // Commit transaksi
            DB::commit();

            Log::info('Tipe layanan kesehatan berhasil dihapus', [
                'healthcare_type_data' => $healthcareTypeData,
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcaretypes.index')
                ->with('success', 'Tipe layanan kesehatan berhasil dihapus!');

        } catch (Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            Log::error('Gagal menghapus tipe layanan kesehatan', [
                'healthcare_type_id' => $healthcaretype->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return redirect()->route('healthcaretypes.index')
                ->with('error', 'Gagal menghapus tipe layanan kesehatan! Silakan coba lagi.');
        }
    }
}
