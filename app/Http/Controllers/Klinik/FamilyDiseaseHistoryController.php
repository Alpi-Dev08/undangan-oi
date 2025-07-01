<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\FamilyDiseaseHistoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreFamilyDiseaseHistoryRequest;
use App\Http\Requests\Klinik\UpdateFamilyDiseaseHistoryRequest;
use App\Models\Klinik\FamilyDiseaseHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Class FamilyDiseaseHistoryController
 *
 * Handles family disease history management operations
 *
 * @package App\Http\Controllers\Klinik
 */
class FamilyDiseaseHistoryController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_family_disease_histories')->only(['index', 'show']);
        $this->middleware('permission:create_family_disease_histories')->only(['create', 'store']);
        $this->middleware('permission:edit_family_disease_histories')->only(['edit', 'update']);
        $this->middleware('permission:delete_family_disease_histories')->only(['destroy']);
    }

    /**
     * Display a listing of family disease histories.
     *
     * @param FamilyDiseaseHistoryDataTable $dataTable
     * @return View
     */
    public function index(FamilyDiseaseHistoryDataTable $dataTable): View
    {
        try {
            Log::info('Family disease history list accessed', [
                'user_id' => Auth::id()
            ]);

            return $dataTable->render('pages.klinik.family_disease_histories.index');
        } catch (Exception $e) {
            Log::error('Failed to load family disease history list', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.family_disease_histories.index')
                ->with('error', 'Gagal memuat daftar riwayat penyakit keluarga');
        }
    }

    /**
     * Show the form for creating a new family disease history.
     *
     * @return View
     */
    public function create()
    {
        try {
            Log::info('Family disease history create form accessed', [
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.family_disease_histories.create');
        } catch (Exception $e) {
            Log::error('Failed to load create family disease history form', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('family-disease-histories.index')
                ->with('error', 'Gagal memuat form pembuatan riwayat penyakit keluarga');
        }
    }

    /**
     * Store a newly created family disease history in storage.
     *
     * @param StoreFamilyDiseaseHistoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreFamilyDiseaseHistoryRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $familyDiseaseHistory = FamilyDiseaseHistory::create($request->validated());

            DB::commit();

            Log::info('Family disease history created successfully', [
                'family_disease_history_id' => $familyDiseaseHistory->id,
                'code' => $familyDiseaseHistory->code,
                'name' => $familyDiseaseHistory->name,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('family-disease-histories.index')
                ->with('success', 'Riwayat penyakit keluarga berhasil dibuat');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to create family disease history', [
                'error' => $e->getMessage(),
                'request_data' => $request->validated(),
                'user_id' => Auth::id()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat riwayat penyakit keluarga: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified family disease history.
     *
     * @param FamilyDiseaseHistory $familyDiseaseHistory
     * @return View
     */
    public function show(FamilyDiseaseHistory $familyDiseaseHistory)
    {
        try {
            Log::info('Family disease history viewed', [
                'family_disease_history_id' => $familyDiseaseHistory->id,
                'code' => $familyDiseaseHistory->code,
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.family_disease_histories.show', compact('familyDiseaseHistory'));
        } catch (Exception $e) {
            Log::error('Failed to load family disease history details', [
                'family_disease_history_id' => $familyDiseaseHistory->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('family-disease-histories.index')
                ->with('error', 'Gagal memuat detail riwayat penyakit keluarga');
        }
    }

    /**
     * Show the form for editing the specified family disease history.
     *
     * @param FamilyDiseaseHistory $familyDiseaseHistory
     * @return View
     */
    public function edit(FamilyDiseaseHistory $familyDiseaseHistory)
    {
        try {
            Log::info('Family disease history edit form accessed', [
                'family_disease_history_id' => $familyDiseaseHistory->id,
                'code' => $familyDiseaseHistory->code,
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.family_disease_histories.edit', compact('familyDiseaseHistory'));
        } catch (Exception $e) {
            Log::error('Failed to load edit family disease history form', [
                'family_disease_history_id' => $familyDiseaseHistory->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('family-disease-histories.index')
                ->with('error', 'Gagal memuat form edit riwayat penyakit keluarga');
        }
    }

    /**
     * Update the specified family disease history in storage.
     *
     * @param UpdateFamilyDiseaseHistoryRequest $request
     * @param FamilyDiseaseHistory $familyDiseaseHistory
     * @return RedirectResponse
     */
    public function update(UpdateFamilyDiseaseHistoryRequest $request, FamilyDiseaseHistory $familyDiseaseHistory): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $oldData = $familyDiseaseHistory->toArray();
            $familyDiseaseHistory->update($request->validated());

            DB::commit();

            Log::info('Family disease history updated successfully', [
                'family_disease_history_id' => $familyDiseaseHistory->id,
                'old_data' => $oldData,
                'new_data' => $familyDiseaseHistory->fresh()->toArray(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('family-disease-histories.index')
                ->with('success', 'Riwayat penyakit keluarga berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to update family disease history', [
                'family_disease_history_id' => $familyDiseaseHistory->id,
                'error' => $e->getMessage(),
                'request_data' => $request->validated(),
                'user_id' => Auth::id()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui riwayat penyakit keluarga: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified family disease history from storage.
     *
     * @param FamilyDiseaseHistory $familyDiseaseHistory
     * @return RedirectResponse
     */
    public function destroy(FamilyDiseaseHistory $familyDiseaseHistory): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $familyDiseaseHistoryData = $familyDiseaseHistory->toArray();
            $familyDiseaseHistory->delete();

            DB::commit();

            Log::info('Family disease history deleted successfully', [
                'family_disease_history_data' => $familyDiseaseHistoryData,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('family-disease-histories.index')
                ->with('success', 'Riwayat penyakit keluarga berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to delete family disease history', [
                'family_disease_history_id' => $familyDiseaseHistory->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('family-disease-histories.index')
                ->with('error', 'Gagal menghapus riwayat penyakit keluarga: ' . $e->getMessage());
        }
    }
}
