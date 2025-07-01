<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\ServiceCategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klinik\ServiceCategory;
use App\Http\Requests\Klinik\StoreServiceCategoryRequest;
use App\Http\Requests\Klinik\UpdateServiceCategoryRequest;
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
 * Controller untuk mengelola kategori layanan
 *
 * Menangani operasi CRUD untuk kategori layanan termasuk
 * validasi, otorisasi, logging, dan transaksi database
 */
class ServiceCategoriesController extends Controller
{
    /**
     * Konstruktor controller
     *
     * Menerapkan middleware otentikasi untuk semua method
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar kategori layanan
     *
     * @param ServiceCategoriesDataTable $dataTable
     * @return Response|View
     */
    public function index(ServiceCategoriesDataTable $dataTable)
    {
        try {
            // Pemeriksaan otorisasi menggunakan Gate
            Gate::authorize('viewAny', ServiceCategory::class);

            Log::info('Menampilkan daftar kategori layanan', [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name
            ]);

            return $dataTable->render('pages.klinik.servicecategories.index');

        } catch (Throwable $e) {
            Log::error('Gagal memuat daftar kategori layanan', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal memuat daftar kategori layanan');
        }
    }

    /**
     * Menampilkan form untuk membuat kategori layanan baru
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        try {
            // Pemeriksaan otorisasi menggunakan Gate
            Gate::authorize('create', ServiceCategory::class);

            Log::info('Menampilkan form pembuatan kategori layanan', [
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.servicecategories.create');

        } catch (Throwable $e) {
            Log::error('Gagal memuat form pembuatan kategori layanan', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('servicecategories.index')
                ->with('error', 'Gagal memuat form pembuatan kategori layanan');
        }
    }

    /**
     * Menyimpan kategori layanan baru ke database
     *
     * @param StoreServiceCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreServiceCategoryRequest $request): RedirectResponse
    {
        try {
            // Pemeriksaan otorisasi menggunakan Gate
            Gate::authorize('create', ServiceCategory::class);

            // Validasi data sudah dilakukan oleh FormRequest
            $validated = $request->validated();

            // Sanitasi dan normalisasi data
            $validated['name'] = trim($validated['name']);
            $validated['is_global'] = $validated['is_global'] ?? false;
            $validated['is_mcu'] = $validated['is_mcu'] ?? false;

            // Pengecekan duplikasi nama (case-insensitive)
            $existingCategory = ServiceCategory::whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])
                ->first();

            if ($existingCategory) {
                Log::warning('Percobaan membuat kategori layanan dengan nama yang sudah ada', [
                    'name' => $validated['name'],
                    'existing_id' => $existingCategory->id,
                    'user_id' => Auth::id()
                ]);

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Nama kategori layanan sudah digunakan');
            }

            // Transaksi database dengan rollback
            DB::beginTransaction();

            $serviceCategory = ServiceCategory::create($validated);

            DB::commit();

            Log::info('Kategori layanan berhasil dibuat', [
                'service_category_id' => $serviceCategory->id,
                'name' => $serviceCategory->name,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('servicecategories.index')
                ->with('success', 'Kategori layanan berhasil dibuat');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal membuat kategori layanan', [
                'error' => $e->getMessage(),
                'input' => $request->all(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat kategori layanan');
        }
    }

    /**
     * Menampilkan detail kategori layanan
     *
     * @param ServiceCategory $servicecategory
     * @return View|RedirectResponse
     */
    public function show(ServiceCategory $servicecategory): View|RedirectResponse
    {
        try {
            // Pemeriksaan otorisasi menggunakan Gate
            Gate::authorize('view', $servicecategory);

            Log::info('Menampilkan detail kategori layanan', [
                'service_category_id' => $servicecategory->id,
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.servicecategories.show', compact('servicecategory'));

        } catch (Throwable $e) {
            Log::error('Gagal memuat detail kategori layanan', [
                'service_category_id' => $servicecategory->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('servicecategories.index')
                ->with('error', 'Gagal memuat detail kategori layanan');
        }
    }

    /**
     * Menampilkan form untuk mengedit kategori layanan
     *
     * @param ServiceCategory $servicecategory
     * @return View|RedirectResponse
     */
    public function edit(ServiceCategory $servicecategory): View|RedirectResponse
    {
        try {
            // Pemeriksaan otorisasi menggunakan Gate
            Gate::authorize('update', $servicecategory);

            Log::info('Menampilkan form edit kategori layanan', [
                'service_category_id' => $servicecategory->id,
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.servicecategories.edit', compact('servicecategory'));

        } catch (Throwable $e) {
            Log::error('Gagal memuat form edit kategori layanan', [
                'service_category_id' => $servicecategory->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('servicecategories.index')
                ->with('error', 'Gagal memuat form edit kategori layanan');
        }
    }

    /**
     * Memperbarui kategori layanan di database
     *
     * @param UpdateServiceCategoryRequest $request
     * @param ServiceCategory $servicecategory
     * @return RedirectResponse
     */
    public function update(UpdateServiceCategoryRequest $request, ServiceCategory $servicecategory): RedirectResponse
    {
        try {
            // Pemeriksaan otorisasi menggunakan Gate
            Gate::authorize('update', $servicecategory);

            // Validasi data sudah dilakukan oleh FormRequest
            $validated = $request->validated();

            // Sanitasi dan normalisasi data
            $validated['name'] = trim($validated['name']);
            $validated['is_global'] = $validated['is_global'] ?? $servicecategory->is_global;
            $validated['is_mcu'] = $validated['is_mcu'] ?? $servicecategory->is_mcu;

            // Pengecekan duplikasi nama (case-insensitive) kecuali untuk record yang sedang diupdate
            $existingCategory = ServiceCategory::whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])
                ->where('id', '!=', $servicecategory->id)
                ->first();

            if ($existingCategory) {
                Log::warning('Percobaan update kategori layanan dengan nama yang sudah ada', [
                    'name' => $validated['name'],
                    'existing_id' => $existingCategory->id,
                    'updating_id' => $servicecategory->id,
                    'user_id' => Auth::id()
                ]);

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Nama kategori layanan sudah digunakan');
            }

            // Transaksi database dengan rollback
            DB::beginTransaction();

            $servicecategory->update($validated);

            DB::commit();

            Log::info('Kategori layanan berhasil diperbarui', [
                'service_category_id' => $servicecategory->id,
                'name' => $servicecategory->name,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('servicecategories.index')
                ->with('success', 'Kategori layanan berhasil diperbarui');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal memperbarui kategori layanan', [
                'service_category_id' => $servicecategory->id,
                'error' => $e->getMessage(),
                'input' => $request->all(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kategori layanan');
        }
    }

    /**
     * Menghapus kategori layanan dari database
     *
     * @param ServiceCategory $servicecategory
     * @return RedirectResponse
     */
    public function destroy(ServiceCategory $servicecategory): RedirectResponse
    {
        try {
            // Pemeriksaan otorisasi menggunakan Gate
            Gate::authorize('delete', $servicecategory);

            // Pengecekan relasi sebelum penghapusan
            if ($servicecategory->services()->exists()) {
                Log::warning('Percobaan menghapus kategori layanan yang masih memiliki layanan', [
                    'service_category_id' => $servicecategory->id,
                    'services_count' => $servicecategory->services()->count(),
                    'user_id' => Auth::id()
                ]);

                return redirect()->route('servicecategories.index')
                    ->with('error', 'Kategori layanan tidak dapat dihapus karena masih memiliki layanan terkait');
            }

            // Transaksi database dengan rollback
            DB::beginTransaction();

            $categoryName = $servicecategory->name;
            $categoryId = $servicecategory->id;

            $servicecategory->delete();

            DB::commit();

            Log::info('Kategori layanan berhasil dihapus', [
                'service_category_id' => $categoryId,
                'name' => $categoryName,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('servicecategories.index')
                ->with('success', 'Kategori layanan berhasil dihapus');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal menghapus kategori layanan', [
                'service_category_id' => $servicecategory->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('servicecategories.index')
                ->with('error', 'Gagal menghapus kategori layanan');
        }
    }
}
