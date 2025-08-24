<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\SpecialitiesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klinik\Speciality;
use App\Http\Requests\Klinik\StoreSpecialityRequest;
use App\Http\Requests\Klinik\UpdateSpecialityRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

/**
 * Controller untuk mengelola data spesialisasi
 *
 * Menangani operasi CRUD untuk data spesialisasi termasuk
 * validasi, otorisasi, logging, dan transaksi database
 *
 * @package App\Http\Controllers\Klinik
 */
class SpecialitiesController extends Controller
{
    /**
     * Instance pengguna yang sedang login
     *
     * @var \App\Models\User|null
     */
    public $user;

    /**
     * Konstruktor controller
     *
     * Menginisialisasi middleware otentikasi dan menetapkan
     * pengguna yang sedang login untuk digunakan di seluruh controller
     */
    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar spesialisasi
     *
     * Menampilkan halaman index dengan DataTable yang berisi
     * daftar semua spesialisasi dengan pemeriksaan otorisasi
     *
     * @param SpecialitiesDataTable $dataTable Instance DataTable untuk spesialisasi
     * @return Response|View Response halaman index
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(SpecialitiesDataTable $dataTable)
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to specialities index', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data spesialisasi.');
        }

        Log::info('Accessing specialities index', [
            'user_id' => $this->user->id
        ]);

        return $dataTable->render('pages.klinik.specialities.index');
    }

    /**
     * Menampilkan form untuk membuat spesialisasi baru
     *
     * Menampilkan halaman form pembuatan spesialisasi baru
     * dengan pemeriksaan otorisasi
     *
     * @return View Response halaman form create
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): View
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized access attempt to specialities create', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data spesialisasi.');
        }

        Log::info('Accessing specialities create form', [
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.specialities.create');
    }

    /**
     * Menyimpan spesialisasi baru ke database
     *
     * Memvalidasi dan menyimpan data spesialisasi baru dengan
     * transaksi database dan logging aktivitas
     *
     * @param StoreSpecialityRequest $request Data request yang sudah divalidasi
     * @return RedirectResponse Redirect ke halaman index atau kembali dengan error
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreSpecialityRequest $request): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized access attempt to specialities store', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data spesialisasi.');
        }

        // Validasi data
        $validated = $request->validated();

        // Sanitasi input
        $validated['name'] = trim($validated['name']);

        // Pengecekan duplikasi nama secara case-insensitive
        $existingSpeciality = Speciality::whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])->first();
        if ($existingSpeciality) {
            Log::warning('Attempt to create duplicate speciality', [
                'user_id' => $this->user->id,
                'name' => $validated['name'],
                'existing_id' => $existingSpeciality->id
            ]);
            return back()->withErrors(['name' => 'Spesialisasi dengan nama tersebut sudah ada.'])->withInput();
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Simpan data spesialisasi
            $speciality = Speciality::create($validated);

            // Commit transaksi
            DB::commit();

            Log::info('Speciality created successfully', [
                'user_id' => $this->user->id,
                'speciality_id' => $speciality->id,
                'name' => $speciality->name
            ]);

            session()->flash('success', 'Spesialisasi berhasil dibuat!');
            return redirect()->route('specialities.index');

        } catch (Throwable $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            Log::error('Failed to create speciality', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data spesialisasi.'])->withInput();
        }
    }

    /**
     * Menampilkan detail spesialisasi tertentu
     *
     * Menampilkan halaman detail untuk spesialisasi yang dipilih
     * dengan pemeriksaan otorisasi
     *
     * @param Speciality $speciality Instance model spesialisasi
     * @return View Response halaman detail
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Speciality $speciality): View
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to specialities show', [
                'user_id' => $this->user?->id,
                'speciality_id' => $speciality->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat detail spesialisasi.');
        }

        Log::info('Viewing speciality details', [
            'user_id' => $this->user->id,
            'speciality_id' => $speciality->id
        ]);

        return view('pages.klinik.specialities.show', compact('speciality'));
    }

    /**
     * Menampilkan form untuk mengedit spesialisasi
     *
     * Menampilkan halaman form edit untuk spesialisasi yang dipilih
     * dengan pemeriksaan otorisasi
     *
     * @param int $id ID spesialisasi yang akan diedit
     * @return View Response halaman form edit
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(int $id): View
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized access attempt to specialities edit', [
                'user_id' => $this->user?->id,
                'speciality_id' => $id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data spesialisasi.');
        }

        // Cari spesialisasi berdasarkan ID
        $speciality = Speciality::findOrFail($id);

        Log::info('Accessing speciality edit form', [
            'user_id' => $this->user->id,
            'speciality_id' => $speciality->id
        ]);

        return view('pages.klinik.specialities.edit', compact('speciality'));
    }

    /**
     * Memperbarui data spesialisasi di database
     *
     * Memvalidasi dan memperbarui data spesialisasi dengan
     * transaksi database dan logging aktivitas
     *
     * @param UpdateSpecialityRequest $request Data request yang sudah divalidasi
     * @param Speciality $speciality Instance model spesialisasi
     * @return RedirectResponse Redirect ke halaman index atau kembali dengan error
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UpdateSpecialityRequest $request, Speciality $speciality): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized access attempt to specialities update', [
                'user_id' => $this->user?->id,
                'speciality_id' => $speciality->id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data spesialisasi.');
        }

        // Validasi data
        $validated = $request->validated();

        // Sanitasi input
        $validated['name'] = trim($validated['name']);

        // Pengecekan duplikasi nama secara case-insensitive (kecuali untuk record yang sedang diupdate)
        $existingSpeciality = Speciality::whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])
            ->where('id', '!=', $speciality->id)
            ->first();

        if ($existingSpeciality) {
            Log::warning('Attempt to update speciality with duplicate name', [
                'user_id' => $this->user->id,
                'speciality_id' => $speciality->id,
                'name' => $validated['name'],
                'existing_id' => $existingSpeciality->id
            ]);
            return back()->withErrors(['name' => 'Spesialisasi dengan nama tersebut sudah ada.'])->withInput();
        }

        // Simpan data lama untuk logging
        $oldData = $speciality->toArray();

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Update data spesialisasi
            $speciality->update($validated);

            // Commit transaksi
            DB::commit();

            Log::info('Speciality updated successfully', [
                'user_id' => $this->user->id,
                'speciality_id' => $speciality->id,
                'old_data' => $oldData,
                'new_data' => $speciality->fresh()->toArray()
            ]);

            session()->flash('success', 'Spesialisasi berhasil diperbarui!');
            return redirect()->route('specialities.index');

        } catch (Throwable $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            Log::error('Failed to update speciality', [
                'user_id' => $this->user->id,
                'speciality_id' => $speciality->id,
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data spesialisasi.'])->withInput();
        }
    }

    /**
     * Menghapus spesialisasi dari database
     *
     * Menghapus data spesialisasi dengan pengecekan relasi,
     * transaksi database dan logging aktivitas
     *
     * @param Speciality $speciality Instance model spesialisasi
     * @return RedirectResponse Redirect ke halaman index dengan pesan
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Speciality $speciality): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Unauthorized access attempt to specialities destroy', [
                'user_id' => $this->user?->id,
                'speciality_id' => $speciality->id,
                'permission' => 'klinik.delete'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk menghapus data spesialisasi.');
        }

        // Pengecekan relasi sebelum penghapusan
        if ($speciality->healthProfesional()->exists()) {
            Log::warning('Attempt to delete speciality with existing health professionals', [
                'user_id' => $this->user->id,
                'speciality_id' => $speciality->id,
                'health_professionals_count' => $speciality->healthProfesional()->count()
            ]);

            session()->flash('error', 'Spesialisasi tidak dapat dihapus karena masih memiliki tenaga kesehatan terkait.');
            return redirect()->route('specialities.index');
        }

        // Simpan data untuk logging
        $deletedData = $speciality->toArray();

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Hapus spesialisasi
            $speciality->delete();

            // Commit transaksi
            DB::commit();

            Log::info('Speciality deleted successfully', [
                'user_id' => $this->user->id,
                'deleted_data' => $deletedData
            ]);

            session()->flash('success', 'Spesialisasi berhasil dihapus!');
            return redirect()->route('specialities.index');

        } catch (Throwable $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            Log::error('Failed to delete speciality', [
                'user_id' => $this->user->id,
                'speciality_id' => $speciality->id,
                'error' => $e->getMessage()
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menghapus data spesialisasi.');
            return redirect()->route('specialities.index');
        }
    }
}
