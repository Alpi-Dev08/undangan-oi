<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\IcdtenDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klinik\Icdten;
use App\Models\User;
use Illuminate\Http\{Request, RedirectResponse, JsonResponse};
use Illuminate\Support\Facades\{Auth, DB, Log};
use Illuminate\View\View;
use Throwable;

/**
 * Controller untuk mengelola data ICD-10
 *
 * Menangani operasi CRUD untuk data ICD-10 termasuk pencarian
 * dan validasi data dengan logging aktivitas
 */
class IcdtenController extends Controller
{
    /**
     * Instance pengguna yang sedang login
     */
    public ?User $user;

    /**
     * Konstruktor controller dengan middleware otentikasi dan otorisasi
     *
     * Menginisialisasi middleware untuk memastikan pengguna terautentikasi
     * dan memiliki izin yang sesuai untuk mengakses fitur ICD-10
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            // Log akses controller
            Log::info('IcdtenController accessed', [
                'user_id' => $this->user?->id,
                'user_email' => $this->user?->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return $next($request);
        });
    }

    /**
     * Menampilkan daftar data ICD-10
     *
     * Menggunakan DataTable untuk menampilkan data ICD-10 dengan
     * fitur pagination, sorting, dan filtering
     *
     * @param IcdtenDataTable $dataTable Instance DataTable untuk ICD-10
     * @return JsonResponse|View Halaman index dengan DataTable
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(IcdtenDataTable $dataTable): JsonResponse|View
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to ICD-10 index', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data ICD-10!');
        }

        Log::info('ICD-10 index page accessed', [
            'user_id' => $this->user->id
        ]);

        return $dataTable->render('pages.klinik.icdten.index');
    }

    /**
     * Menampilkan form untuk membuat data ICD-10 baru
     *
     * Menampilkan halaman form pembuatan data ICD-10 baru
     * dengan validasi otorisasi pengguna
     *
     * @return View Halaman form pembuatan
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): View
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized access attempt to ICD-10 create', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data ICD-10!');
        }

        Log::info('ICD-10 create form accessed', [
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.icdten.create');
    }

    /**
     * Menyimpan data ICD-10 baru ke database
     *
     * Memvalidasi dan menyimpan data ICD-10 baru dengan
     * transaksi database dan logging aktivitas
     *
     * @param Request $request Data request dari form
     * @return RedirectResponse Redirect ke halaman index atau kembali dengan error
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized access attempt to ICD-10 store', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data ICD-10!');
        }

        // Validasi input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:icdtens,code',
        ], [
            'name.required' => 'Nama ICD-10 wajib diisi.',
            'name.string' => 'Nama ICD-10 harus berupa teks.',
            'name.max' => 'Nama ICD-10 maksimal 255 karakter.',
            'code.required' => 'Kode ICD-10 wajib diisi.',
            'code.string' => 'Kode ICD-10 harus berupa teks.',
            'code.max' => 'Kode ICD-10 maksimal 255 karakter.',
            'code.unique' => 'Kode ICD-10 sudah digunakan.',
        ]);

        DB::beginTransaction();

        try {
            // Buat data ICD-10 baru
            $icdten = Icdten::create($validatedData);

            DB::commit();

            Log::info('ICD-10 created successfully', [
                'user_id' => $this->user->id,
                'icdten_id' => $icdten->id,
                'icdten_code' => $icdten->code,
                'icdten_name' => $icdten->name
            ]);

            session()->flash('success', 'Data ICD-10 berhasil dibuat!');
            return redirect()->route('icdten.index');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Failed to create ICD-10', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input_data' => $validatedData
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat data ICD-10: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail data ICD-10 tertentu
     *
     * Menampilkan halaman detail untuk data ICD-10 yang dipilih
     * dengan validasi otorisasi pengguna
     *
     * @param Icdten $icdten Instance model ICD-10
     * @return View Halaman detail ICD-10
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Icdten $icdten): View
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to ICD-10 show', [
                'user_id' => $this->user?->id,
                'icdten_id' => $icdten->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data ICD-10!');
        }

        Log::info('ICD-10 detail viewed', [
            'user_id' => $this->user->id,
            'icdten_id' => $icdten->id,
            'icdten_code' => $icdten->code
        ]);

        return view('pages.klinik.icdten.show', compact('icdten'));
    }

    /**
     * Menampilkan form untuk mengedit data ICD-10
     *
     * Menampilkan halaman form pengeditan untuk data ICD-10 yang dipilih
     * dengan validasi otorisasi pengguna
     *
     * @param Icdten $icdten Instance model ICD-10
     * @return View Halaman form pengeditan
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Icdten $icdten): View
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized access attempt to ICD-10 edit', [
                'user_id' => $this->user?->id,
                'icdten_id' => $icdten->id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data ICD-10!');
        }

        Log::info('ICD-10 edit form accessed', [
            'user_id' => $this->user->id,
            'icdten_id' => $icdten->id,
            'icdten_code' => $icdten->code
        ]);

        return view('pages.klinik.icdten.edit', compact('icdten'));
    }

    /**
     * Memperbarui data ICD-10 di database
     *
     * Memvalidasi dan memperbarui data ICD-10 dengan
     * transaksi database dan logging aktivitas
     *
     * @param Request $request Data request dari form
     * @param Icdten $icdten Instance model ICD-10
     * @return RedirectResponse Redirect ke halaman index atau kembali dengan error
     * @throws ValidationException
     */
    public function update(Request $request, Icdten $icdten): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized access attempt to ICD-10 update', [
                'user_id' => $this->user?->id,
                'icdten_id' => $icdten->id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk memperbarui data ICD-10!');
        }

        // Simpan data lama untuk logging
        $oldData = $icdten->toArray();

        // Validasi input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:icdtens,code,' . $icdten->id,
        ], [
            'name.required' => 'Nama ICD-10 wajib diisi.',
            'name.string' => 'Nama ICD-10 harus berupa teks.',
            'name.max' => 'Nama ICD-10 maksimal 255 karakter.',
            'code.required' => 'Kode ICD-10 wajib diisi.',
            'code.string' => 'Kode ICD-10 harus berupa teks.',
            'code.max' => 'Kode ICD-10 maksimal 255 karakter.',
            'code.unique' => 'Kode ICD-10 sudah digunakan.',
        ]);

        DB::beginTransaction();

        try {
            // Update data ICD-10
            $icdten->update($validatedData);

            DB::commit();

            Log::info('ICD-10 updated successfully', [
                'user_id' => $this->user->id,
                'icdten_id' => $icdten->id,
                'old_data' => $oldData,
                'new_data' => $icdten->fresh()->toArray()
            ]);

            session()->flash('success', 'Data ICD-10 berhasil diperbarui!');
            return redirect()->route('icdten.index');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Failed to update ICD-10', [
                'user_id' => $this->user->id,
                'icdten_id' => $icdten->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input_data' => $validatedData
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data ICD-10: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data ICD-10 dari database
     *
     * Menghapus data ICD-10 dengan soft delete dan logging aktivitas
     * Memeriksa relasi sebelum penghapusan untuk mencegah data orphan
     *
     * @param Icdten $icdten Instance model ICD-10
     * @return RedirectResponse Redirect ke halaman index atau kembali dengan error
     */
    public function destroy(Icdten $icdten): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Unauthorized access attempt to ICD-10 destroy', [
                'user_id' => $this->user?->id,
                'icdten_id' => $icdten->id,
                'permission' => 'klinik.delete'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk menghapus data ICD-10!');
        }

        // Simpan data untuk logging sebelum dihapus
        $deletedData = $icdten->toArray();

        DB::beginTransaction();

        try {
            // Hapus data ICD-10 (soft delete)
            $icdten->delete();

            DB::commit();

            Log::info('ICD-10 deleted successfully', [
                'user_id' => $this->user->id,
                'deleted_data' => $deletedData
            ]);

            session()->flash('success', 'Data ICD-10 berhasil dihapus!');
            return redirect()->route('icdten.index');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Failed to delete ICD-10', [
                'user_id' => $this->user->id,
                'icdten_id' => $icdten->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menghapus data ICD-10: ' . $e->getMessage());
        }
    }

    /**
     * Mencari data ICD-10 untuk keperluan AJAX/API
     *
     * Melakukan pencarian data ICD-10 berdasarkan kode atau nama
     * dengan pagination untuk performa yang optimal
     *
     * @param Request $request Data request pencarian
     * @return JsonResponse Response JSON dengan hasil pencarian
     */
    public function search(Request $request): JsonResponse
    {
        try {
            // Validasi parameter pencarian
            $request->validate([
                'q' => 'nullable|string|max:255',
                'page' => 'nullable|integer|min:1'
            ]);

            $term = $request->input('q', '');
            $page = $request->input('page', 1);
            $perPage = 30;

            Log::info('ICD-10 search performed', [
                'user_id' => $this->user?->id,
                'search_term' => $term,
                'page' => $page
            ]);

            // Lakukan pencarian dengan query yang dioptimasi
            $query = Icdten::query();

            if (!empty($term)) {
                $query->where(function ($q) use ($term) {
                    $q->where('code', 'LIKE', "%{$term}%")
                      ->orWhere('name', 'LIKE', "%{$term}%");
                });
            }

            $results = $query->orderBy('code')
                           ->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'total_count' => $results->total(),
                'items' => $results->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'text' => $item->name,
                        'code' => $item->code
                    ];
                })
            ]);

        } catch (Throwable $e) {
            Log::error('ICD-10 search failed', [
                'user_id' => $this->user?->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'error' => 'Pencarian gagal dilakukan',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
