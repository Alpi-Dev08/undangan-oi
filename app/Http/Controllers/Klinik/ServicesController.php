<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\ServicesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\{StoreServiceRequest, UpdateServiceRequest};
use App\Models\Klinik\{Service, ServiceCategory};
use Illuminate\Http\{RedirectResponse, Response};
use Illuminate\Support\Facades\{Auth, DB, Log};
use Illuminate\View\View;
use Throwable;

/**
 * Controller untuk mengelola layanan
 *
 * Menangani operasi CRUD untuk layanan termasuk
 * validasi, otorisasi, logging, dan transaksi database
 */
class ServicesController extends Controller
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
     * Menerapkan middleware otentikasi untuk semua method
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar layanan
     *
     * @param ServicesDataTable $dataTable
     * @return Response|View
     */
    public function index(ServicesDataTable $dataTable)
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to services index', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data layanan.');
        }

        try {
            Log::info('Menampilkan daftar layanan', [
                'user_id' => $this->user->id,
                'user_name' => $this->user->name
            ]);

            return $dataTable->render('pages.klinik.services.index');

        } catch (Throwable $e) {
            Log::error('Gagal memuat daftar layanan', [
                'error' => $e->getMessage(),
                'user_id' => $this->user->id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal memuat daftar layanan');
        }
    }

    /**
     * Menampilkan form untuk membuat layanan baru
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized access attempt to services create', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data layanan.');
        }

        try {
            // Memuat kategori layanan untuk dropdown
            $service_categories = ServiceCategory::select('id', 'name')
                ->orderBy('name')
                ->get();

            Log::info('Menampilkan form pembuatan layanan', [
                'user_id' => $this->user->id,
                'categories_count' => $service_categories->count()
            ]);

            return view('pages.klinik.services.create', [
                'service_category' => $service_categories
            ]);

        } catch (Throwable $e) {
            Log::error('Gagal memuat form pembuatan layanan', [
                'error' => $e->getMessage(),
                'user_id' => $this->user->id
            ]);

            return redirect()->route('services.index')
                ->with('error', 'Gagal memuat form pembuatan layanan');
        }
    }

    /**
     * Menyimpan layanan baru ke database
     *
     * @param StoreServiceRequest $request
     * @return RedirectResponse
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized access attempt to services store', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data layanan.');
        }

        try {
            // Validasi data sudah dilakukan oleh FormRequest
            $validated = $request->validated();

            // Sanitasi dan normalisasi data
            $validated['name'] = trim($validated['name']);
            $validated['price'] = $validated['price'] ?? 0;

            // Pengecekan keberadaan kategori layanan
            $serviceCategory = ServiceCategory::find($validated['service_category_id']);
            if (!$serviceCategory) {
                Log::warning('Percobaan membuat layanan dengan kategori yang tidak ada', [
                    'service_category_id' => $validated['service_category_id'],
                    'user_id' => $this->user->id
                ]);

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kategori layanan tidak ditemukan');
            }

            // Pengecekan duplikasi nama dalam kategori yang sama (case-insensitive)
            $existingService = Service::whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])
                ->where('service_category_id', $validated['service_category_id'])
                ->first();

            if ($existingService) {
                Log::warning('Percobaan membuat layanan dengan nama yang sudah ada dalam kategori', [
                    'name' => $validated['name'],
                    'service_category_id' => $validated['service_category_id'],
                    'existing_id' => $existingService->id,
                    'user_id' => $this->user->id
                ]);

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Nama layanan sudah digunakan dalam kategori ini');
            }

            // Transaksi database dengan rollback
            DB::beginTransaction();

            $service = Service::create($validated);

            DB::commit();

            Log::info('Layanan berhasil dibuat', [
                'service_id' => $service->id,
                'name' => $service->name,
                'service_category_id' => $service->service_category_id,
                'price' => $service->price,
                'user_id' => $this->user->id
            ]);

            return redirect()->route('services.index')
                ->with('success', 'Layanan berhasil dibuat');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal membuat layanan', [
                'error' => $e->getMessage(),
                'input' => $request->all(),
                'user_id' => $this->user->id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat layanan');
        }
    }

    /**
     * Menampilkan detail layanan
     *
     * @param Service $service
     * @return View|RedirectResponse
     */
    public function show(Service $service): View|RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to services show', [
                'user_id' => $this->user?->id,
                'service_id' => $service->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat detail layanan.');
        }

        try {
            // Load relasi kategori
            $service->load('category');

            Log::info('Menampilkan detail layanan', [
                'service_id' => $service->id,
                'user_id' => $this->user->id
            ]);

            return view('pages.klinik.services.show', compact('service'));

        } catch (Throwable $e) {
            Log::error('Gagal memuat detail layanan', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user->id
            ]);

            return redirect()->route('services.index')
                ->with('error', 'Gagal memuat detail layanan');
        }
    }

    /**
     * Menampilkan form untuk mengedit layanan
     *
     * @param Service $service
     * @return View|RedirectResponse
     */
    public function edit(Service $service): View|RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized access attempt to services edit', [
                'user_id' => $this->user?->id,
                'service_id' => $service->id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data layanan.');
        }

        try {
            // Memuat kategori layanan untuk dropdown
            $service_categories = ServiceCategory::select('id', 'name')
                ->orderBy('name')
                ->get();

            // Load relasi kategori untuk service
            $service->load('category');

            Log::info('Menampilkan form edit layanan', [
                'service_id' => $service->id,
                'user_id' => $this->user->id
            ]);

            return view('pages.klinik.services.edit', [
                'service_category' => $service_categories,
                'service' => $service
            ]);

        } catch (Throwable $e) {
            Log::error('Gagal memuat form edit layanan', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user->id
            ]);

            return redirect()->route('services.index')
                ->with('error', 'Gagal memuat form edit layanan');
        }
    }

    /**
     * Memperbarui layanan di database
     *
     * @param UpdateServiceRequest $request
     * @param Service $service
     * @return RedirectResponse
     */
    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized access attempt to services update', [
                'user_id' => $this->user?->id,
                'service_id' => $service->id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data layanan.');
        }

        try {
            // Validasi data sudah dilakukan oleh FormRequest
            $validated = $request->validated();

            // Sanitasi dan normalisasi data
            $validated['name'] = trim($validated['name']);
            $validated['price'] = $validated['price'] ?? $service->price;

            // Pengecekan keberadaan kategori layanan
            $serviceCategory = ServiceCategory::find($validated['service_category_id']);
            if (!$serviceCategory) {
                Log::warning('Percobaan update layanan dengan kategori yang tidak ada', [
                    'service_category_id' => $validated['service_category_id'],
                    'service_id' => $service->id,
                    'user_id' => $this->user->id
                ]);

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kategori layanan tidak ditemukan');
            }

            // Pengecekan duplikasi nama dalam kategori yang sama (case-insensitive) kecuali untuk record yang sedang diupdate
            $existingService = Service::whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])
                ->where('service_category_id', $validated['service_category_id'])
                ->where('id', '!=', $service->id)
                ->first();

            if ($existingService) {
                Log::warning('Percobaan update layanan dengan nama yang sudah ada dalam kategori', [
                    'name' => $validated['name'],
                    'service_category_id' => $validated['service_category_id'],
                    'existing_id' => $existingService->id,
                    'updating_id' => $service->id,
                    'user_id' => $this->user->id
                ]);

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Nama layanan sudah digunakan dalam kategori ini');
            }

            // Transaksi database dengan rollback
            DB::beginTransaction();

            $service->update($validated);

            DB::commit();

            Log::info('Layanan berhasil diperbarui', [
                'service_id' => $service->id,
                'name' => $service->name,
                'service_category_id' => $service->service_category_id,
                'price' => $service->price,
                'user_id' => $this->user->id
            ]);

            return redirect()->route('services.index')
                ->with('success', 'Layanan berhasil diperbarui');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal memperbarui layanan', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
                'input' => $request->all(),
                'user_id' => $this->user->id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui layanan');
        }
    }

    /**
     * Menghapus layanan dari database
     *
     * @param Service $service
     * @return RedirectResponse
     */
    public function destroy(Service $service): RedirectResponse
    {
        // Validasi otorisasi pengguna
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Unauthorized access attempt to services destroy', [
                'user_id' => $this->user?->id,
                'service_id' => $service->id,
                'permission' => 'klinik.delete'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk menghapus data layanan.');
        }

        try {
            // Pengecekan relasi sebelum penghapusan
            if ($service->transaction_detail()->exists()) {
                Log::warning('Percobaan menghapus layanan yang masih memiliki transaksi', [
                    'service_id' => $service->id,
                    'transactions_count' => $service->transaction_detail()->count(),
                    'user_id' => $this->user->id
                ]);

                return redirect()->route('services.index')
                    ->with('error', 'Layanan tidak dapat dihapus karena masih memiliki transaksi terkait');
            }

            // Transaksi database dengan rollback
            DB::beginTransaction();

            $serviceName = $service->name;
            $serviceId = $service->id;
            $categoryId = $service->service_category_id;

            $service->delete();

            DB::commit();

            Log::info('Layanan berhasil dihapus', [
                'service_id' => $serviceId,
                'name' => $serviceName,
                'service_category_id' => $categoryId,
                'user_id' => $this->user->id
            ]);

            return redirect()->route('services.index')
                ->with('success', 'Layanan berhasil dihapus');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal menghapus layanan', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user->id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('services.index')
                ->with('error', 'Gagal menghapus layanan');
        }
    }
}
