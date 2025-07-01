<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\HealthcareCategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreHealthcareCategoryRequest;
use App\Http\Requests\Klinik\UpdateHealthcareCategoryRequest;
use App\Models\Klinik\HealthcareCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Class HealthcareCategoriesController
 *
 * Handles healthcare category management operations
 *
 * @package App\Http\Controllers\Klinik
 */
class HealthcareCategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_healthcare_categories')->only(['index', 'show']);
        $this->middleware('permission:create_healthcare_categories')->only(['create', 'store']);
        $this->middleware('permission:edit_healthcare_categories')->only(['edit', 'update']);
        $this->middleware('permission:delete_healthcare_categories')->only(['destroy']);
    }

    /**
     * Display a listing of healthcare categories.
     *
     * @param HealthcareCategoriesDataTable $dataTable
     * @return View
     */
    public function index(HealthcareCategoriesDataTable $dataTable)
    {
        try {
            Log::info('Healthcare categories list accessed', [
                'user_id' => Auth::id()
            ]);

            return $dataTable->render('pages.klinik.healthcarecategories.index');
        } catch (Exception $e) {
            Log::error('Failed to load healthcare categories list', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.healthcarecategories.index')
                ->with('error', 'Gagal memuat daftar kategori layanan kesehatan');
        }
    }

    /**
     * Show the form for creating a new healthcare category.
     *
     * @return View
     */
    public function create()
    {
        try {
            Log::info('Healthcare category create form accessed', [
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.healthcarecategories.create');
        } catch (Exception $e) {
            Log::error('Failed to load create healthcare category form', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('healthcarecategories.index')
                ->with('error', 'Gagal memuat form pembuatan kategori layanan kesehatan');
        }
    }

    /**
     * Store a newly created healthcare category in storage.
     *
     * @param StoreHealthcareCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreHealthcareCategoryRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $healthcareCategory = HealthcareCategory::create($request->validated());

            DB::commit();

            Log::info('Healthcare category created successfully', [
                'healthcare_category_id' => $healthcareCategory->id,
                'name' => $healthcareCategory->name,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('healthcarecategories.index')
                ->with('success', 'Kategori layanan kesehatan berhasil dibuat');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to create healthcare category', [
                'error' => $e->getMessage(),
                'request_data' => $request->validated(),
                'user_id' => Auth::id()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat kategori layanan kesehatan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified healthcare category.
     *
     * @param HealthcareCategory $healthcarecategory
     * @return View
     */
    public function show(HealthcareCategory $healthcarecategory)
    {
        try {
            $healthcarecategory->load('healthcare');

            Log::info('Healthcare category viewed', [
                'healthcare_category_id' => $healthcarecategory->id,
                'name' => $healthcarecategory->name,
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.healthcarecategories.show', compact('healthcarecategory'));
        } catch (Exception $e) {
            Log::error('Failed to load healthcare category details', [
                'healthcare_category_id' => $healthcarecategory->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('healthcarecategories.index')
                ->with('error', 'Gagal memuat detail kategori layanan kesehatan');
        }
    }

    /**
     * Show the form for editing the specified healthcare category.
     *
     * @param HealthcareCategory $healthcarecategory
     * @return View
     */
    public function edit(HealthcareCategory $healthcarecategory)
    {
        try {
            Log::info('Healthcare category edit form accessed', [
                'healthcare_category_id' => $healthcarecategory->id,
                'name' => $healthcarecategory->name,
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.healthcarecategories.edit', compact('healthcarecategory'));
        } catch (Exception $e) {
            Log::error('Failed to load edit healthcare category form', [
                'healthcare_category_id' => $healthcarecategory->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('healthcarecategories.index')
                ->with('error', 'Gagal memuat form edit kategori layanan kesehatan');
        }
    }

    /**
     * Update the specified healthcare category in storage.
     *
     * @param UpdateHealthcareCategoryRequest $request
     * @param HealthcareCategory $healthcarecategory
     * @return RedirectResponse
     */
    public function update(UpdateHealthcareCategoryRequest $request, HealthcareCategory $healthcarecategory): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $oldData = $healthcarecategory->toArray();
            $healthcarecategory->update($request->validated());

            DB::commit();

            Log::info('Healthcare category updated successfully', [
                'healthcare_category_id' => $healthcarecategory->id,
                'old_data' => $oldData,
                'new_data' => $healthcarecategory->fresh()->toArray(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('healthcarecategories.index')
                ->with('success', 'Kategori layanan kesehatan berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to update healthcare category', [
                'healthcare_category_id' => $healthcarecategory->id,
                'error' => $e->getMessage(),
                'request_data' => $request->validated(),
                'user_id' => Auth::id()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kategori layanan kesehatan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified healthcare category from storage.
     *
     * @param HealthcareCategory $healthcarecategory
     * @return RedirectResponse
     */
    public function destroy(HealthcareCategory $healthcarecategory): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Check if healthcare category has related healthcare records
            if ($healthcarecategory->healthcare()->exists()) {
                return redirect()->route('healthcarecategories.index')
                    ->with('error', 'Tidak dapat menghapus kategori layanan kesehatan yang masih memiliki data layanan terkait');
            }

            $healthcareCategoryData = $healthcarecategory->toArray();
            $healthcarecategory->delete();

            DB::commit();

            Log::info('Healthcare category deleted successfully', [
                'healthcare_category_data' => $healthcareCategoryData,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('healthcarecategories.index')
                ->with('success', 'Kategori layanan kesehatan berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to delete healthcare category', [
                'healthcare_category_id' => $healthcarecategory->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('healthcarecategories.index')
                ->with('error', 'Gagal menghapus kategori layanan kesehatan: ' . $e->getMessage());
        }
    }
}
