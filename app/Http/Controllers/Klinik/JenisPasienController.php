<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\JenisPasienDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreJenisPasienRequest;
use App\Http\Requests\Klinik\UpdateJenisPasienRequest;
use App\Models\JenisPasien;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;
use App\Models\User;

/**
 * Controller untuk mengelola data Jenis Pasien
 *
 * Menangani operasi CRUD untuk data jenis pasien termasuk
 * validasi data dan logging aktivitas
 */
class JenisPasienController extends Controller
{
    /**
     * Instance pengguna yang sedang login
     */
    public ?User $user;

    /**
     * Konstruktor controller dengan middleware otentikasi dan otorisasi
     *
     * Menginisialisasi middleware untuk memastikan pengguna terautentikasi
     * dan memiliki izin yang sesuai untuk mengakses fitur jenis pasien
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();

            // Log akses controller
            Log::info('JenisPasienController accessed', [
                'user_id' => $this->user?->id,
                'user_email' => $this->user?->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return $next($request);
        });
    }

    /**
     * Menampilkan daftar data jenis pasien
     *
     * Menggunakan DataTable untuk menampilkan data jenis pasien dengan
     * fitur pagination, sorting, dan filtering
     *
     * @param JenisPasienDataTable $dataTable Instance DataTable untuk jenis pasien
     * @return Response Halaman index dengan DataTable
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(JenisPasienDataTable $dataTable): Response
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to jenis pasien index', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data jenis pasien!');
        }

        Log::info('Jenis pasien index page accessed', [
            'user_id' => $this->user->id
        ]);

        return $dataTable->render('pages.klinik.jenis_pasien.index');
    }

    /**
     * Menampilkan form untuk membuat data jenis pasien baru
     *
     * Menampilkan halaman form pembuatan data jenis pasien baru
     * dengan validasi otorisasi pengguna
     *
     * @return View Halaman form pembuatan
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): View
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            Log::warning('Unauthorized access attempt to jenis pasien create', [
                'user_id' => $this->user?->id,
                'permission' => 'masters.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data master!');
        }

        Log::info('Jenis pasien create form accessed', [
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.jenis_pasien.create');
    }

    /**
     * Menyimpan data jenis pasien baru ke database
     *
     * Memvalidasi dan menyimpan data jenis pasien baru dengan
     * transaksi database dan logging aktivitas
     *
     * @param StoreJenisPasienRequest $request Data request yang sudah divalidasi
     * @return RedirectResponse Redirect ke halaman index atau kembali dengan error
     * @throws ValidationException
     */
    public function store(StoreJenisPasienRequest $request): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            Log::warning('Unauthorized access attempt to jenis pasien store', [
                'user_id' => $this->user?->id,
                'permission' => 'masters.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data master!');
        }

        // Ambil data yang sudah divalidasi
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            // Buat data jenis pasien baru
            $jenisPasien = JenisPasien::create($validatedData);

            DB::commit();

            Log::info('Jenis pasien created successfully', [
                'user_id' => $this->user->id,
                'jenis_pasien_id' => $jenisPasien->id,
                'jenis_pasien_nama' => $jenisPasien->nama,
                'jenis_pasien_keterangan' => $jenisPasien->keterangan
            ]);

            session()->flash('success', 'Data jenis pasien berhasil dibuat!');
            return redirect()->route('jenis-pasien.index');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Failed to create jenis pasien', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input_data' => $validatedData
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat data jenis pasien: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail data jenis pasien tertentu
     *
     * Menampilkan halaman detail untuk data jenis pasien yang dipilih
     * dengan validasi otorisasi pengguna
     *
     * @param JenisPasien $jenisPasien Instance model jenis pasien
     * @return View Halaman detail jenis pasien
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(JenisPasien $jenisPasien): View
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to jenis pasien show', [
                'user_id' => $this->user?->id,
                'jenis_pasien_id' => $jenisPasien->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data jenis pasien!');
        }

        Log::info('Jenis pasien detail viewed', [
            'user_id' => $this->user->id,
            'jenis_pasien_id' => $jenisPasien->id,
            'jenis_pasien_nama' => $jenisPasien->nama
        ]);

        return view('pages.klinik.jenis_pasien.show', compact('jenisPasien'));
    }

    /**
     * Menampilkan form untuk mengedit data jenis pasien
     *
     * Menampilkan halaman form pengeditan untuk data jenis pasien yang dipilih
     * dengan validasi otorisasi pengguna
     *
     * @param JenisPasien $jenis_pasien Instance model jenis pasien
     * @return View Halaman form pengeditan
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(JenisPasien $jenis_pasien): View
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('masters.update')) {
            Log::warning('Unauthorized access attempt to jenis pasien edit', [
                'user_id' => $this->user?->id,
                'jenis_pasien_id' => $jenis_pasien->id,
                'permission' => 'masters.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data master!');
        }

        Log::info('Jenis pasien edit form accessed', [
            'user_id' => $this->user->id,
            'jenis_pasien_id' => $jenis_pasien->id,
            'jenis_pasien_nama' => $jenis_pasien->nama
        ]);

        return view('pages.klinik.jenis_pasien.edit', compact('jenis_pasien'));
    }

    /**
     * Memperbarui data jenis pasien di database
     *
     * Memvalidasi dan memperbarui data jenis pasien dengan
     * transaksi database dan logging aktivitas
     *
     * @param UpdateJenisPasienRequest $request Data request yang sudah divalidasi
     * @param JenisPasien $jenisPasien Instance model jenis pasien
     * @return RedirectResponse Redirect ke halaman index atau kembali dengan error
     * @throws ValidationException
     */
    public function update(UpdateJenisPasienRequest $request, JenisPasien $jenisPasien): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('masters.update')) {
            Log::warning('Unauthorized access attempt to jenis pasien update', [
                'user_id' => $this->user?->id,
                'jenis_pasien_id' => $jenisPasien->id,
                'permission' => 'masters.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk memperbarui data master!');
        }

        // Simpan data lama untuk logging
        $oldData = $jenisPasien->toArray();

        // Ambil data yang sudah divalidasi
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            // Update data jenis pasien
            $jenisPasien->update($validatedData);

            DB::commit();

            Log::info('Jenis pasien updated successfully', [
                'user_id' => $this->user->id,
                'jenis_pasien_id' => $jenisPasien->id,
                'old_data' => $oldData,
                'new_data' => $jenisPasien->fresh()->toArray()
            ]);

            session()->flash('success', 'Data jenis pasien berhasil diperbarui!');
            return redirect()->route('jenis-pasien.index');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Failed to update jenis pasien', [
                'user_id' => $this->user->id,
                'jenis_pasien_id' => $jenisPasien->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input_data' => $validatedData
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data jenis pasien: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data jenis pasien dari database
     *
     * Menghapus data jenis pasien dengan soft delete dan logging aktivitas
     * Memeriksa relasi sebelum penghapusan untuk mencegah data orphan
     *
     * @param JenisPasien $jenisPasien Instance model jenis pasien
     * @return RedirectResponse Redirect ke halaman index atau kembali dengan error
     */
    public function destroy(JenisPasien $jenisPasien): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('masters.delete')) {
            Log::warning('Unauthorized access attempt to jenis pasien destroy', [
                'user_id' => $this->user?->id,
                'jenis_pasien_id' => $jenisPasien->id,
                'permission' => 'masters.delete'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk menghapus data master!');
        }

        // Periksa apakah jenis pasien memiliki relasi dengan examination
        $examinationCount = $jenisPasien->examinations()->count();

        if ($examinationCount > 0) {
            Log::warning('Attempt to delete jenis pasien with existing examinations', [
                'user_id' => $this->user->id,
                'jenis_pasien_id' => $jenisPasien->id,
                'examination_count' => $examinationCount
            ]);

            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus jenis pasien karena masih memiliki data pemeriksaan terkait.');
        }

        // Simpan data untuk logging sebelum dihapus
        $deletedData = $jenisPasien->toArray();

        DB::beginTransaction();

        try {
            // Hapus data jenis pasien (soft delete)
            $jenisPasien->delete();

            DB::commit();

            Log::info('Jenis pasien deleted successfully', [
                'user_id' => $this->user->id,
                'deleted_data' => $deletedData
            ]);

            session()->flash('success', 'Data jenis pasien berhasil dihapus!');
            return redirect()->route('jenis-pasien.index');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Failed to delete jenis pasien', [
                'user_id' => $this->user->id,
                'jenis_pasien_id' => $jenisPasien->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menghapus data jenis pasien: ' . $e->getMessage());
        }
    }
}
