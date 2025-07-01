<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Models\Sbar;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

/**
 * Controller untuk mengelola komunikasi efektif menggunakan metode SBAR
 * (Situation, Background, Assessment, Recommendation)
 */
class KomunikasiEfektifController extends Controller
{
    /**
     * Konstruktor controller
     * Menerapkan middleware otentikasi dan otorisasi
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:komunikasi-efektif-list|komunikasi-efektif-create|komunikasi-efektif-edit|komunikasi-efektif-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:komunikasi-efektif-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:komunikasi-efektif-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:komunikasi-efektif-delete', ['only' => ['destroy']]);
    }

    /**
     * Menampilkan daftar komunikasi efektif
     *
     * @return View
     */
    public function index(): View
    {
        try {
            Log::info('Mengakses halaman daftar komunikasi efektif', [
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            $sbars = Sbar::with('examination')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('pages.klinik.komunikasi-efektif.index', compact('sbars'));
        } catch (Exception $e) {
            Log::error('Error saat mengakses daftar komunikasi efektif', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return view('pages.klinik.komunikasi-efektif.index')
                ->with('error', 'Terjadi kesalahan saat memuat data komunikasi efektif.');
        }
    }

    /**
     * Menampilkan detail komunikasi efektif
     *
     * @param Sbar $sbar
     * @return View
     */
    public function show(Sbar $sbar)
    {
        try {
            Log::info('Mengakses detail komunikasi efektif', [
                'sbar_id' => $sbar->id,
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            $sbar->load('examination');

            return view('pages.klinik.komunikasi-efektif.show', compact('sbar'));
        } catch (Exception $e) {
            Log::error('Error saat mengakses detail komunikasi efektif', [
                'sbar_id' => $sbar->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return redirect()->route('komunikasi-efektif.index')
                ->with('error', 'Terjadi kesalahan saat memuat detail komunikasi efektif.');
        }
    }

    /**
     * Menampilkan form komunikasi efektif
     *
     * @param int $examinationId ID pemeriksaan
     * @return View
     */
    public function showForm(int $examinationId)
    {
        try {
            Log::info('Mengakses form komunikasi efektif', [
                'examination_id' => $examinationId,
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            // Validasi apakah examination_id valid
            if (!$this->isValidExaminationId($examinationId)) {
                Log::warning('ID pemeriksaan tidak valid', [
                    'examination_id' => $examinationId,
                    'user_id' => Auth::id()
                ]);

                return redirect()->back()
                    ->with('error', 'ID pemeriksaan tidak valid.');
            }

            return view('pages.klinik.patients.communication', [
                'examinationId' => $examinationId
            ]);
        } catch (Exception $e) {
            Log::error('Error saat mengakses form komunikasi efektif', [
                'examination_id' => $examinationId,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memuat form komunikasi efektif.');
        }
    }

    /**
     * Menyimpan data komunikasi efektif
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            // Validasi input dengan pesan error kustom
            $validatedData = $request->validate([
                'situation' => [
                    'required',
                    'string',
                    'max:1000'
                ],
                'background' => [
                    'required',
                    'string',
                    'max:1000'
                ],
                'assessment' => [
                    'required',
                    'string',
                    'max:1000'
                ],
                'recommendation' => [
                    'required',
                    'string',
                    'max:1000'
                ],
                'examination_id' => [
                    'required',
                    'integer',
                    'exists:examinations,id'
                ],
                'checklist_verification' => [
                    'nullable',
                    'boolean'
                ]
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

            Log::info('Memulai proses penyimpanan komunikasi efektif', [
                'examination_id' => $validatedData['examination_id'],
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            // Gunakan transaksi database
            DB::beginTransaction();

            try {
                // Cek apakah sudah ada SBAR untuk examination ini
                $existingSbar = Sbar::where('examination_id', $validatedData['examination_id'])->first();

                if ($existingSbar) {
                    DB::rollBack();

                    Log::warning('SBAR sudah ada untuk pemeriksaan ini', [
                        'examination_id' => $validatedData['examination_id'],
                        'existing_sbar_id' => $existingSbar->id,
                        'user_id' => Auth::id()
                    ]);

                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Komunikasi efektif sudah ada untuk pemeriksaan ini.');
                }

                // Buat record SBAR baru
                $sbar = Sbar::create([
                    'examination_id' => $validatedData['examination_id'],
                    'situation' => $validatedData['situation'],
                    'background' => $validatedData['background'],
                    'assessment' => $validatedData['assessment'],
                    'recommendation' => $validatedData['recommendation'],
                    'checklist_verification' => $validatedData['checklist_verification'] ?? false
                ]);

                DB::commit();

                Log::info('Komunikasi efektif berhasil disimpan', [
                    'sbar_id' => $sbar->id,
                    'examination_id' => $validatedData['examination_id'],
                    'user_id' => Auth::id(),
                    'timestamp' => now()
                ]);

                return redirect()->route('komunikasi.efektif.success')
                    ->with('success', 'Data komunikasi efektif berhasil disimpan!');

            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal saat menyimpan komunikasi efektif', [
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (Exception $e) {
            Log::error('Error saat menyimpan komunikasi efektif', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data komunikasi efektif. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan form edit komunikasi efektif
     *
     * @param Sbar $sbar
     * @return View
     */
    public function edit(Sbar $sbar)
    {
        try {
            Log::info('Mengakses form edit komunikasi efektif', [
                'sbar_id' => $sbar->id,
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            $sbar->load('examination');

            return view('pages.klinik.komunikasi-efektif.edit', compact('sbar'));
        } catch (Exception $e) {
            Log::error('Error saat mengakses form edit komunikasi efektif', [
                'sbar_id' => $sbar->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return redirect()->route('komunikasi-efektif.index')
                ->with('error', 'Terjadi kesalahan saat memuat form edit.');
        }
    }

    /**
     * Memperbarui data komunikasi efektif
     *
     * @param Request $request
     * @param Sbar $sbar
     * @return RedirectResponse
     */
    public function update(Request $request, Sbar $sbar): RedirectResponse
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'situation' => [
                    'required',
                    'string',
                    'max:1000'
                ],
                'background' => [
                    'required',
                    'string',
                    'max:1000'
                ],
                'assessment' => [
                    'required',
                    'string',
                    'max:1000'
                ],
                'recommendation' => [
                    'required',
                    'string',
                    'max:1000'
                ],
                'checklist_verification' => [
                    'nullable',
                    'boolean'
                ]
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

            Log::info('Memulai proses update komunikasi efektif', [
                'sbar_id' => $sbar->id,
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            // Gunakan transaksi database
            DB::beginTransaction();

            try {
                $sbar->update([
                    'situation' => $validatedData['situation'],
                    'background' => $validatedData['background'],
                    'assessment' => $validatedData['assessment'],
                    'recommendation' => $validatedData['recommendation'],
                    'checklist_verification' => $validatedData['checklist_verification'] ?? false
                ]);

                DB::commit();

                Log::info('Komunikasi efektif berhasil diperbarui', [
                    'sbar_id' => $sbar->id,
                    'user_id' => Auth::id(),
                    'timestamp' => now()
                ]);

                return redirect()->route('komunikasi-efektif.show', $sbar)
                    ->with('success', 'Data komunikasi efektif berhasil diperbarui!');

            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (ValidationException $e) {
            Log::warning('Validasi gagal saat memperbarui komunikasi efektif', [
                'sbar_id' => $sbar->id,
                'errors' => $e->errors(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (Exception $e) {
            Log::error('Error saat memperbarui komunikasi efektif', [
                'sbar_id' => $sbar->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data komunikasi efektif. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus data komunikasi efektif
     *
     * @param Sbar $sbar
     * @return RedirectResponse
     */
    public function destroy(Sbar $sbar): RedirectResponse
    {
        try {
            Log::info('Memulai proses penghapusan komunikasi efektif', [
                'sbar_id' => $sbar->id,
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            // Gunakan transaksi database
            DB::beginTransaction();

            try {
                $sbar->delete();

                DB::commit();

                Log::info('Komunikasi efektif berhasil dihapus', [
                    'sbar_id' => $sbar->id,
                    'user_id' => Auth::id(),
                    'timestamp' => now()
                ]);

                return redirect()->route('komunikasi-efektif.index')
                    ->with('success', 'Data komunikasi efektif berhasil dihapus!');

            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (Exception $e) {
            Log::error('Error saat menghapus komunikasi efektif', [
                'sbar_id' => $sbar->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return redirect()->route('komunikasi-efektif.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data komunikasi efektif.');
        }
    }

    /**
     * Menampilkan halaman sukses
     *
     * @return View
     */
    public function success()
    {
        try {
            Log::info('Mengakses halaman sukses komunikasi efektif', [
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return view('pages.klinik.patients.success');
        } catch (Exception $e) {
            Log::error('Error saat mengakses halaman sukses', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return redirect()->route('komunikasi-efektif.index')
                ->with('info', 'Data berhasil disimpan!');
        }
    }

    /**
     * Validasi apakah examination ID valid
     *
     * @param int $examinationId
     * @return bool
     */
    private function isValidExaminationId(int $examinationId): bool
    {
        try {
            return DB::table('examinations')
                ->where('id', $examinationId)
                ->exists();
        } catch (Exception $e) {
            Log::error('Error saat validasi examination ID', [
                'examination_id' => $examinationId,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }
}
