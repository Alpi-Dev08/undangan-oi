<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Models\Klinik\Eresep;
use App\Models\Klinik\Examination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Class EresepsController
 *
 * Handles electronic prescription (e-resep) management operations
 *
 * @package App\Http\Controllers\Klinik
 */
class EresepsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_ereseps')->only(['index', 'show']);
        $this->middleware('permission:create_ereseps')->only(['store', 'create', 'createEresepFromExaminations']);
        $this->middleware('permission:edit_ereseps')->only(['edit', 'update']);
        $this->middleware('permission:delete_ereseps')->only(['destroy']);
    }

    /**
     * Display a listing of electronic prescriptions.
     *
     * @return View
     */
    public function index(): View
    {
        try {
            $ereseps = Eresep::with(['examination.patient', 'examination.healthProfesional'])
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('E-resep list accessed', [
                'user_id' => Auth::id(),
                'count' => $ereseps->count()
            ]);

            return view('pages.klinik.ereseps.index', compact('ereseps'));
        } catch (Exception $e) {
            Log::error('Failed to load e-resep list', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.ereseps.index', ['ereseps' => collect()]);
        }
    }

    /**
     * Show the form for creating a new electronic prescription.
     *
     * @return View
     */
    public function create(): View
    {
        try {
            $examinations = Examination::whereDoesntHave('eresep')
                ->with(['patient', 'healthProfesional'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('pages.klinik.ereseps.create', compact('examinations'));
        } catch (Exception $e) {
            Log::error('Failed to load create e-resep form', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.ereseps.create', ['examinations' => collect()]);
        }
    }

    /**
     * Store a newly created electronic prescription in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'examination_id' => 'required|integer|exists:examinations,id',
            'eresep_number' => 'nullable|string|max:50|unique:ereseps,eresep_number'
        ]);

        try {
            DB::beginTransaction();

            // Check if e-resep already exists for this examination
            $existingEresep = Eresep::where('examination_id', $request->examination_id)->first();
            if ($existingEresep) {
                return response()->json([
                    'success' => false,
                    'message' => 'E-resep sudah ada untuk pemeriksaan ini'
                ], 422);
            }

            $eresepNumber = $request->eresep_number ?? 'ERES-' . $request->examination_id . '-' . time();

            $eresep = Eresep::create([
                'examination_id' => $request->examination_id,
                'eresep_number' => $eresepNumber,
            ]);

            DB::commit();

            Log::info('E-resep created successfully', [
                'eresep_id' => $eresep->id,
                'examination_id' => $request->examination_id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'E-resep berhasil dibuat',
                'data' => $eresep->load('examination')
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to create e-resep', [
                'error' => $e->getMessage(),
                'examination_id' => $request->examination_id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat e-resep: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified electronic prescription.
     *
     * @param Eresep $eresep
     * @return View
     */
    public function show(Eresep $eresep): View
    {
        try {
            $eresep->load(['examination.patient', 'examination.healthProfesional', 'examination.serviceCategory']);

            Log::info('E-resep viewed', [
                'eresep_id' => $eresep->id,
                'user_id' => Auth::id()
            ]);

            return view('pages.klinik.ereseps.show', compact('eresep'));
        } catch (Exception $e) {
            Log::error('Failed to load e-resep details', [
                'eresep_id' => $eresep->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            abort(500, 'Gagal memuat detail e-resep');
        }
    }

    /**
     * Show the form for editing the specified electronic prescription.
     *
     * @param Eresep $eresep
     * @return View
     */
    public function edit(Eresep $eresep): View
    {
        try {
            $eresep->load('examination');
            $examinations = Examination::with(['patient', 'healthProfesional'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('pages.klinik.ereseps.edit', compact('eresep', 'examinations'));
        } catch (Exception $e) {
            Log::error('Failed to load edit e-resep form', [
                'eresep_id' => $eresep->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            abort(500, 'Gagal memuat form edit e-resep');
        }
    }

    /**
     * Update the specified electronic prescription in storage.
     *
     * @param Request $request
     * @param Eresep $eresep
     * @return JsonResponse
     */
    public function update(Request $request, Eresep $eresep): JsonResponse
    {
        $request->validate([
            'examination_id' => 'required|integer|exists:examinations,id',
            'eresep_number' => 'required|string|max:50|unique:ereseps,eresep_number,' . $eresep->id
        ]);

        try {
            DB::beginTransaction();

            // Check if examination is already used by another e-resep
            $existingEresep = Eresep::where('examination_id', $request->examination_id)
                ->where('id', '!=', $eresep->id)
                ->first();

            if ($existingEresep) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pemeriksaan sudah digunakan oleh e-resep lain'
                ], 422);
            }

            $eresep->update([
                'examination_id' => $request->examination_id,
                'eresep_number' => $request->eresep_number,
            ]);

            DB::commit();

            Log::info('E-resep updated successfully', [
                'eresep_id' => $eresep->id,
                'examination_id' => $request->examination_id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'E-resep berhasil diperbarui',
                'data' => $eresep->load('examination')
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to update e-resep', [
                'eresep_id' => $eresep->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui e-resep: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified electronic prescription from storage.
     *
     * @param Eresep $eresep
     * @return JsonResponse
     */
    public function destroy(Eresep $eresep): JsonResponse
    {
        try {
            DB::beginTransaction();

            $eresepId = $eresep->id;
            $eresep->delete();

            DB::commit();

            Log::info('E-resep deleted successfully', [
                'eresep_id' => $eresepId,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'E-resep berhasil dihapus'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to delete e-resep', [
                'eresep_id' => $eresep->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus e-resep: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate electronic prescriptions from all examinations that don't have one.
     *
     * @return JsonResponse
     */
    public function createEresepFromExaminations(): JsonResponse
    {
        try {
            DB::beginTransaction();

            $examinations = Examination::whereDoesntHave('eresep')->get();
            $createdCount = 0;

            foreach ($examinations as $examination) {
                Eresep::create([
                    'examination_id' => $examination->id,
                    'eresep_number' => 'ERES-' . $examination->id . '-' . time(),
                ]);
                $createdCount++;
            }

            DB::commit();

            Log::info('Bulk e-resep creation completed', [
                'created_count' => $createdCount,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => "E-resep berhasil di-generate dari {$createdCount} examination",
                'created_count' => $createdCount
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to create bulk e-resep', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat e-resep: ' . $e->getMessage()
            ], 500);
        }
    }
}
