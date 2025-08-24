<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Models\Sbar;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Klinik\Examination;

/**
 * Class SbarController
 *
 * Mengelola operasi CRUD untuk data SBAR (Situation, Background, Assessment, Recommendation)
 *
 * @package App\Http\Controllers\Klinik
 */
class SbarController extends Controller
{
    /**
     * User yang sedang login
     *
     * @var \App\Models\User|null
     */
    public $user;

    /**
     * Constructor - Setup middleware dan user authentication
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar SBAR yang sudah ada
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        Gate::authorize('klinik.read');

        try {
            $sbarList = Sbar::with(['examination'])
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('SBAR index accessed', [
                'user_id' => $this->user->id,
                'user_email' => $this->user->email,
                'sbar_count' => $sbarList->count()
            ]);

            return view('pages.klinik.sbar.index', compact('sbarList'));
        } catch (Exception $e) {
            Log::error('Error accessing SBAR index', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage()
            ]);

            return view('pages.klinik.sbar.index', ['sbarList' => collect()])
                ->with('error', 'Terjadi kesalahan saat memuat data SBAR.');
        }
    }

    /**
     * Menyimpan data SBAR baru oleh perawat
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('klinik.create');

        // Validasi input yang diberikan perawat
        $validatedData = $request->validate([
            'situation' => 'required|string|max:1000',
            'background' => 'required|string|max:1000',
            'assessment' => 'required|string|max:1000',
            'recommendation' => 'required|string|max:1000',
            'examination_id' => 'required|integer|exists:examinations,id',
        ], [
            'situation.required' => 'Situasi wajib diisi.',
            'situation.max' => 'Situasi maksimal 1000 karakter.',
            'background.required' => 'Latar belakang wajib diisi.',
            'background.max' => 'Latar belakang maksimal 1000 karakter.',
            'assessment.required' => 'Penilaian wajib diisi.',
            'assessment.max' => 'Penilaian maksimal 1000 karakter.',
            'recommendation.required' => 'Rekomendasi wajib diisi.',
            'recommendation.max' => 'Rekomendasi maksimal 1000 karakter.',
            'examination_id.required' => 'ID pemeriksaan wajib diisi.',
            'examination_id.exists' => 'ID pemeriksaan tidak valid.'
        ]);

        DB::beginTransaction();

        try {
            // Validasi keberadaan examination
            $examination = Examination::find($validatedData['examination_id']);
            if (!$examination) {
                Log::warning('Attempt to create SBAR with invalid examination', [
                    'user_id' => $this->user->id,
                    'examination_id' => $validatedData['examination_id']
                ]);

                return back()
                    ->withInput()
                    ->with('error', 'Pemeriksaan tidak ditemukan.');
            }

            // Cek apakah SBAR sudah ada untuk examination ini
            $existingSbar = Sbar::where('examination_id', $validatedData['examination_id'])->first();
            if ($existingSbar) {
                Log::warning('Attempt to create duplicate SBAR', [
                    'user_id' => $this->user->id,
                    'examination_id' => $validatedData['examination_id'],
                    'existing_sbar_id' => $existingSbar->id
                ]);

                return back()
                    ->withInput()
                    ->with('error', 'SBAR sudah ada untuk pemeriksaan ini.');
            }

            // Simpan data SBAR baru
            $sbar = Sbar::create([
                'situation' => trim($validatedData['situation']),
                'background' => trim($validatedData['background']),
                'assessment' => trim($validatedData['assessment']),
                'recommendation' => trim($validatedData['recommendation']),
                'examination_id' => $validatedData['examination_id'],
                'checklist_verification' => false, // Default tidak terverifikasi
            ]);

            DB::commit();

            Log::info('SBAR created successfully', [
                'user_id' => $this->user->id,
                'sbar_id' => $sbar->id,
                'examination_id' => $sbar->examination_id
            ]);

            return redirect()
                ->route('komunikasi.efektif.success')
                ->with('success', 'Data SBAR berhasil ditambahkan!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error creating SBAR', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'request_data' => $validatedData
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data SBAR. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan SBAR yang diisi ke halaman dokter
     *
     * @param int $examinationId
     * @return View|RedirectResponse
     * @throws AuthorizationException
     */
    public function showForDoctor(int $examinationId)
    {
        Gate::authorize('klinik.read');

        try {
            // Ambil SBAR terkait berdasarkan pemeriksaan (examination_id)
            $sbar = Sbar::with(['examination'])
                ->where('examination_id', $examinationId)
                ->first();

            if (!$sbar) {
                Log::warning('SBAR not found for examination', [
                    'user_id' => $this->user->id,
                    'examination_id' => $examinationId
                ]);

                return redirect()
                    ->back()
                    ->with('error', 'SBAR belum tersedia untuk pemeriksaan ini.');
            }

            Log::info('SBAR shown to doctor', [
                'user_id' => $this->user->id,
                'sbar_id' => $sbar->id,
                'examination_id' => $examinationId
            ]);

            return view('pages.klinik.examinations._editform', compact('sbar'));
        } catch (Exception $e) {
            Log::error('Error showing SBAR for doctor', [
                'user_id' => $this->user->id,
                'examination_id' => $examinationId,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memuat data SBAR.');
        }
    }

    /**
     * Menampilkan detail SBAR
     *
     * @param Sbar $sbar
     * @return View
     * @throws AuthorizationException
     */
    public function show(Sbar $sbar): View
    {
        Gate::authorize('klinik.read');

        Log::info('SBAR detail viewed', [
            'user_id' => $this->user->id,
            'sbar_id' => $sbar->id
        ]);

        return view('pages.klinik.sbar.show', compact('sbar'));
    }

    /**
     * Menampilkan form untuk mengedit data SBAR
     *
     * @param int $id
     * @return View|RedirectResponse
     * @throws AuthorizationException
     */
    public function edit(int $id)
    {
        Gate::authorize('klinik.update');

        try {
            $sbar = Sbar::with(['examination'])->findOrFail($id);

            Log::info('SBAR edit form accessed', [
                'user_id' => $this->user->id,
                'sbar_id' => $sbar->id
            ]);

            return view('pages.klinik.sbar.edit', compact('sbar'));
        } catch (Exception $e) {
            Log::error('Error accessing SBAR edit form', [
                'user_id' => $this->user->id,
                'sbar_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('sbar.index')
                ->with('error', 'Data SBAR tidak ditemukan.');
        }
    }

    /**
     * Memperbarui data SBAR
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        Gate::authorize('klinik.update');

        $validatedData = $request->validate([
            'situation' => 'required|string|max:1000',
            'background' => 'required|string|max:1000',
            'assessment' => 'required|string|max:1000',
            'recommendation' => 'required|string|max:1000',
        ], [
            'situation.required' => 'Situasi wajib diisi.',
            'situation.max' => 'Situasi maksimal 1000 karakter.',
            'background.required' => 'Latar belakang wajib diisi.',
            'background.max' => 'Latar belakang maksimal 1000 karakter.',
            'assessment.required' => 'Penilaian wajib diisi.',
            'assessment.max' => 'Penilaian maksimal 1000 karakter.',
            'recommendation.required' => 'Rekomendasi wajib diisi.',
            'recommendation.max' => 'Rekomendasi maksimal 1000 karakter.'
        ]);

        DB::beginTransaction();

        try {
            $sbar = Sbar::findOrFail($id);

            // Store old data for logging
            $oldData = $sbar->toArray();

            // Update SBAR
            $sbar->update([
                'situation' => trim($validatedData['situation']),
                'background' => trim($validatedData['background']),
                'assessment' => trim($validatedData['assessment']),
                'recommendation' => trim($validatedData['recommendation'])
            ]);

            DB::commit();

            Log::info('SBAR updated successfully', [
                'user_id' => $this->user->id,
                'sbar_id' => $sbar->id,
                'old_data' => $oldData,
                'new_data' => $sbar->fresh()->toArray()
            ]);

            return redirect()
                ->route('sbar.index')
                ->with('success', 'Data SBAR berhasil diperbarui!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error updating SBAR', [
                'user_id' => $this->user->id,
                'sbar_id' => $id,
                'error' => $e->getMessage(),
                'request_data' => $validatedData
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data SBAR. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus data SBAR
     *
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): RedirectResponse
    {
        Gate::authorize('klinik.delete');

        DB::beginTransaction();

        try {
            $sbar = Sbar::findOrFail($id);

            // Store data for logging before deletion
            $deletedData = $sbar->toArray();

            $sbar->delete();

            DB::commit();

            Log::info('SBAR deleted successfully', [
                'user_id' => $this->user->id,
                'deleted_data' => $deletedData
            ]);

            return redirect()
                ->route('sbar.index')
                ->with('success', 'Data SBAR berhasil dihapus!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error deleting SBAR', [
                'user_id' => $this->user->id,
                'sbar_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus data SBAR. Silakan coba lagi.');
        }
    }

    /**
     * Verifikasi SBAR oleh dokter
     *
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function verify(int $id): RedirectResponse
    {
        Gate::authorize('klinik.update');

        DB::beginTransaction();

        try {
            $sbar = Sbar::findOrFail($id);

            // Cek apakah sudah terverifikasi
            if ($sbar->checklist_verification) {
                Log::warning('Attempt to verify already verified SBAR', [
                    'user_id' => $this->user->id,
                    'sbar_id' => $sbar->id
                ]);

                return redirect()
                    ->back()
                    ->with('warning', 'SBAR sudah terverifikasi sebelumnya.');
            }

            // Set verifikasi ke true
            $sbar->update(['checklist_verification' => true]);

            DB::commit();

            Log::info('SBAR verified successfully', [
                'user_id' => $this->user->id,
                'sbar_id' => $sbar->id,
                'verified_by' => $this->user->name
            ]);

            return redirect()
                ->back()
                ->with('success', 'SBAR berhasil diverifikasi!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error verifying SBAR', [
                'user_id' => $this->user->id,
                'sbar_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memverifikasi SBAR. Silakan coba lagi.');
        }
    }
}
