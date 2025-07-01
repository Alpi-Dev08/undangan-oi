<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\PhysicalCategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StorePhysicalCategoryRequest;
use App\Http\Requests\Klinik\UpdatePhysicalCategoryRequest;
use App\Models\Klinik\PhysicalCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(PhysicalCategoriesDataTable $dataTable)
    {
        try {
            Gate::authorize('klinik.view');

            Log::info('Physical categories index accessed', [
                'user_id' => $this->user->id,
                'user_email' => $this->user->email
            ]);

            return $dataTable->render('pages.klinik.phyisicalcategories.index');
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): View
    {
        Gate::authorize('klinik.create');

        Log::info('Physical category create form accessed', [
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.phyisicalcategories.create');
    }

    /**
     * Store a newly created physical category in storage
     *
     * @param StorePhysicalCategoryRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StorePhysicalCategoryRequest $request): RedirectResponse
    {
        Gate::authorize('klinik.create');

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(PhysicalCategory $physicalCategory): View
    {
        Gate::authorize('klinik.view');

        Log::info('Physical category viewed', [
            'user_id' => $this->user->id,
            'category_id' => $physicalCategory->id
        ]);

        return view('pages.klinik.phyisicalcategories.show', compact('physicalCategory'));
    }

    /**
     * Show the form for editing the specified physical category
     *
     * @param int $id
     * @return View|RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(int $id)
    {
        Gate::authorize('klinik.update');

        try {
            $physicalCategory = PhysicalCategory::findOrFail($id);

            Log::info('Physical category edit form accessed', [
                'user_id' => $this->user->id,
                'category_id' => $physicalCategory->id
            ]);

            return view('pages.klinik.phyisicalcategories.edit', compact('physicalCategory'));

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePhysicalCategoryRequest $request, int $id): RedirectResponse
    {
        Gate::authorize('klinik.update');

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(int $id): RedirectResponse
    {
        Gate::authorize('klinik.delete');

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
