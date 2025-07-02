<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\PhysicalCategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\{StorePhysicalCategoryRequest, UpdatePhysicalCategoryRequest};
use App\Models\Klinik\PhysicalCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\{Auth, DB, Log};
use Illuminate\View\View;
use Exception;

/**
 * Class PhysicalCategoriesController
 *
 * Handles CRUD operations for Physical Categories
 *
 * @package App\Http\Controllers\Klinik
 */
class PhysicalCategoriesController extends Controller
{
    /**
     * Current authenticated user
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the physical categories
     *
     * @param PhysicalCategoriesDataTable $dataTable
     * @return mixed
     */
    public function index(PhysicalCategoriesDataTable $dataTable)
    {
        try {
            // Check user permissions
            if (!$this->user->can('klinik.read')) {
                Log::warning('Unauthorized access attempt to physical categories index', [
                    'user_id' => $this->user->id,
                    'user_email' => $this->user->email
                ]);
                abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }

            Log::info('Physical categories index accessed', [
                'user_id' => $this->user->id,
                'user_email' => $this->user->email
            ]);

            return $dataTable->render('pages.klinik.physicalcategories.index');
        } catch (Exception $e) {
            Log::error('Error accessing physical categories index', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data kategori fisik.');
        }
    }

    /**
     * Show the form for creating a new physical category
     *
     * @return View
     */
    public function create(): View
    {
        // Check user permissions
        if (!$this->user->can('klinik.create')) {
            Log::warning('Unauthorized access attempt to physical category create form', [
                'user_id' => $this->user->id
            ]);
            abort(403, 'Anda tidak memiliki izin untuk membuat kategori fisik.');
        }

        Log::info('Physical category create form accessed', [
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.physicalcategories.create');
    }

    /**
     * Store a newly created physical category in storage
     *
     * @param StorePhysicalCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StorePhysicalCategoryRequest $request): RedirectResponse
    {
        // Check user permissions
        if (!$this->user->can('klinik.create')) {
            Log::warning('Unauthorized attempt to create physical category', [
                'user_id' => $this->user->id
            ]);
            abort(403, 'Anda tidak memiliki izin untuk membuat kategori fisik.');
        }

        DB::beginTransaction();

        try {
            // Check for duplicate name (case-insensitive)
            $existingCategory = PhysicalCategory::whereRaw('LOWER(name) = ?', [strtolower($request->name)])
                ->first();

            if ($existingCategory) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kategori fisik dengan nama tersebut sudah ada.');
            }

            $physicalCategory = PhysicalCategory::create([
                'name' => trim($request->name)
            ]);

            DB::commit();

            Log::info('Physical category created successfully', [
                'user_id' => $this->user->id,
                'category_id' => $physicalCategory->id,
                'category_name' => $physicalCategory->name
            ]);

            return redirect()->route('klinik.physicalcategories.index')
                ->with('success', 'Kategori fisik berhasil dibuat.');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error creating physical category', [
                'user_id' => $this->user->id,
                'request_data' => $request->validated(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan kategori fisik.');
        }
    }

    /**
     * Display the specified physical category
     *
     * @param PhysicalCategory $physicalCategory
     * @return View
     */
    public function show(PhysicalCategory $physicalCategory): View
    {
        // Check user permissions
        if (!$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to view physical category', [
                'user_id' => $this->user->id,
                'category_id' => $physicalCategory->id
            ]);
            abort(403, 'Anda tidak memiliki izin untuk melihat kategori fisik.');
        }

        Log::info('Physical category viewed', [
            'user_id' => $this->user->id,
            'category_id' => $physicalCategory->id
        ]);

        return view('pages.klinik.physicalcategories.show', compact('physicalCategory'));
    }

    /**
     * Show the form for editing the specified physical category
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id)
    {
        // Check user permissions
        if (!$this->user->can('klinik.update')) {
            Log::warning('Unauthorized access attempt to physical category edit form', [
                'user_id' => $this->user->id,
                'category_id' => $id
            ]);
            abort(403, 'Anda tidak memiliki izin untuk mengedit kategori fisik.');
        }

        try {
            $physicalCategory = PhysicalCategory::findOrFail($id);

            Log::info('Physical category edit form accessed', [
                'user_id' => $this->user->id,
                'category_id' => $physicalCategory->id
            ]);

            return view('pages.klinik.physicalcategories.edit', compact('physicalCategory'));

        } catch (Exception $e) {
            Log::error('Error accessing physical category edit form', [
                'user_id' => $this->user->id,
                'category_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('klinik.physicalcategories.index')
                ->with('error', 'Kategori fisik tidak ditemukan.');
        }
    }

    /**
     * Update the specified physical category in storage
     *
     * @param UpdatePhysicalCategoryRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdatePhysicalCategoryRequest $request, int $id): RedirectResponse
    {
        // Check user permissions
        if (!$this->user->can('klinik.update')) {
            Log::warning('Unauthorized attempt to update physical category', [
                'user_id' => $this->user->id,
                'category_id' => $id
            ]);
            abort(403, 'Anda tidak memiliki izin untuk mengedit kategori fisik.');
        }

        DB::beginTransaction();

        try {
            $physicalCategory = PhysicalCategory::findOrFail($id);

            // Check for duplicate name (case-insensitive) excluding current record
            $existingCategory = PhysicalCategory::whereRaw('LOWER(name) = ?', [strtolower($request->name)])
                ->where('id', '!=', $id)
                ->first();

            if ($existingCategory) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kategori fisik dengan nama tersebut sudah ada.');
            }

            $oldName = $physicalCategory->name;

            $physicalCategory->update([
                'name' => trim($request->name)
            ]);

            DB::commit();

            Log::info('Physical category updated successfully', [
                'user_id' => $this->user->id,
                'category_id' => $physicalCategory->id,
                'old_name' => $oldName,
                'new_name' => $physicalCategory->name
            ]);

            return redirect()->route('klinik.physicalcategories.index')
                ->with('success', 'Kategori fisik berhasil diperbarui.');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error updating physical category', [
                'user_id' => $this->user->id,
                'category_id' => $id,
                'request_data' => $request->validated(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui kategori fisik.');
        }
    }

    /**
     * Remove the specified physical category from storage
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        // Check user permissions
        if (!$this->user->can('klinik.delete')) {
            Log::warning('Unauthorized attempt to delete physical category', [
                'user_id' => $this->user->id,
                'category_id' => $id
            ]);
            abort(403, 'Anda tidak memiliki izin untuk menghapus kategori fisik.');
        }

        DB::beginTransaction();

        try {
            $physicalCategory = PhysicalCategory::findOrFail($id);

            // Check if category has related physicals
            if ($physicalCategory->physicals()->exists()) {
                return redirect()->back()
                    ->with('error', 'Kategori fisik tidak dapat dihapus karena masih memiliki data fisik terkait.');
            }

            $categoryName = $physicalCategory->name;
            $physicalCategory->delete();

            DB::commit();

            Log::info('Physical category deleted successfully', [
                'user_id' => $this->user->id,
                'category_id' => $id,
                'category_name' => $categoryName
            ]);

            return redirect()->route('klinik.physicalcategories.index')
                ->with('success', 'Kategori fisik berhasil dihapus.');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error deleting physical category', [
                'user_id' => $this->user->id,
                'category_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus kategori fisik.');
        }
    }
}
