<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\PersonalDiseaseHistoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\{
    StorePersonalDiseaseHistoryRequest,
    UpdatePersonalDiseaseHistoryRequest
};
use App\Models\Klinik\PersonalDiseaseHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\{Auth, DB, Log};
use Illuminate\View\View;
use Exception;

/**
 * Class PersonalDiseaseHistoryController
 *
 * Mengelola data riwayat penyakit pribadi
 *
 * @package App\Http\Controllers\Klinik
 */
class PersonalDiseaseHistoryController extends Controller
{
    /**
     * Tampilkan daftar riwayat penyakit pribadi
     *
     * @param PersonalDiseaseHistoryDataTable $dataTable
     * @return mixed
     */
    public function index(PersonalDiseaseHistoryDataTable $dataTable)
    {
        Log::info('Mengakses halaman daftar riwayat penyakit pribadi', [
            'user_id' => Auth::id()
        ]);

        try {
            return $dataTable->render('pages.klinik.personal_disease_histories.index');
        } catch (Exception $e) {
            Log::error('Error saat menampilkan daftar riwayat penyakit pribadi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data');
        }
    }

    /**
     * Tampilkan form untuk membuat riwayat penyakit pribadi baru
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        Log::info('Mengakses form pembuatan riwayat penyakit pribadi', [
            'user_id' => Auth::id()
        ]);

        try {
            return view('pages.klinik.personal_disease_histories.create');
        } catch (Exception $e) {
            Log::error('Error saat menampilkan form pembuatan riwayat penyakit pribadi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('personal-disease-histories.index')
                ->with('error', 'Terjadi kesalahan saat memuat form');
        }
    }

    /**
     * Simpan riwayat penyakit pribadi baru ke database
     *
     * @param StorePersonalDiseaseHistoryRequest $request
     * @return RedirectResponse
     */
    public function store(StorePersonalDiseaseHistoryRequest $request): RedirectResponse
    {
        Log::info('Memulai proses pembuatan riwayat penyakit pribadi', [
            'user_id' => Auth::id(),
            'data' => $request->validated()
        ]);

        try {
            DB::beginTransaction();

            // Validasi duplikasi code
            $existingRecord = PersonalDiseaseHistory::where('code', $request->code)->first();
            if ($existingRecord) {
                Log::warning('Kode riwayat penyakit pribadi sudah ada', [
                    'code' => $request->code,
                    'existing_id' => $existingRecord->id
                ]);

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kode riwayat penyakit pribadi sudah digunakan');
            }

            $personalDiseaseHistory = PersonalDiseaseHistory::create($request->validated());

            DB::commit();

            Log::info('Riwayat penyakit pribadi berhasil dibuat', [
                'personal_disease_history_id' => $personalDiseaseHistory->id,
                'code' => $personalDiseaseHistory->code,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('personal-disease-histories.index')
                ->with('success', 'Riwayat penyakit pribadi berhasil dibuat');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error saat membuat riwayat penyakit pribadi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'data' => $request->validated()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data');
        }
    }

    /**
     * Tampilkan form untuk mengedit riwayat penyakit pribadi
     *
     * @param PersonalDiseaseHistory $personalDiseaseHistory
     * @return View|RedirectResponse
     */
    public function edit(PersonalDiseaseHistory $personalDiseaseHistory): View|RedirectResponse
    {
        Log::info('Mengakses form edit riwayat penyakit pribadi', [
            'personal_disease_history_id' => $personalDiseaseHistory->id,
            'user_id' => Auth::id()
        ]);

        try {
            $personal_disease_history = $personalDiseaseHistory;

            return view('pages.klinik.personal_disease_histories.edit',
                compact('personal_disease_history', 'personalDiseaseHistory')
            );
        } catch (Exception $e) {
            Log::error('Error saat menampilkan form edit riwayat penyakit pribadi', [
                'personal_disease_history_id' => $personalDiseaseHistory->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('personal-disease-histories.index')
                ->with('error', 'Terjadi kesalahan saat memuat form edit');
        }
    }

    /**
     * Update riwayat penyakit pribadi di database
     *
     * @param UpdatePersonalDiseaseHistoryRequest $request
     * @param PersonalDiseaseHistory $personalDiseaseHistory
     * @return RedirectResponse
     */
    public function update(UpdatePersonalDiseaseHistoryRequest $request, PersonalDiseaseHistory $personalDiseaseHistory): RedirectResponse
    {
        Log::info('Memulai proses update riwayat penyakit pribadi', [
            'personal_disease_history_id' => $personalDiseaseHistory->id,
            'user_id' => Auth::id(),
            'data' => $request->validated()
        ]);

        try {
            DB::beginTransaction();

            // Validasi duplikasi code (kecuali untuk record yang sedang diupdate)
            $existingRecord = PersonalDiseaseHistory::where('code', $request->code)
                ->where('id', '!=', $personalDiseaseHistory->id)
                ->first();

            if ($existingRecord) {
                Log::warning('Kode riwayat penyakit pribadi sudah digunakan oleh record lain', [
                    'code' => $request->code,
                    'existing_id' => $existingRecord->id,
                    'current_id' => $personalDiseaseHistory->id
                ]);

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kode riwayat penyakit pribadi sudah digunakan');
            }

            $personalDiseaseHistory->update($request->validated());

            DB::commit();

            Log::info('Riwayat penyakit pribadi berhasil diupdate', [
                'personal_disease_history_id' => $personalDiseaseHistory->id,
                'code' => $personalDiseaseHistory->code,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('personal-disease-histories.index')
                ->with('success', 'Riwayat penyakit pribadi berhasil diperbarui');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error saat update riwayat penyakit pribadi', [
                'personal_disease_history_id' => $personalDiseaseHistory->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'data' => $request->validated()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data');
        }
    }

    /**
     * Hapus riwayat penyakit pribadi dari database
     *
     * @param PersonalDiseaseHistory $personalDiseaseHistory
     * @return RedirectResponse
     */
    public function destroy(PersonalDiseaseHistory $personalDiseaseHistory): RedirectResponse
    {
        Log::info('Memulai proses penghapusan riwayat penyakit pribadi', [
            'personal_disease_history_id' => $personalDiseaseHistory->id,
            'code' => $personalDiseaseHistory->code,
            'user_id' => Auth::id()
        ]);

        try {
            DB::beginTransaction();

            // Simpan data untuk log sebelum dihapus
            $deletedData = [
                'id' => $personalDiseaseHistory->id,
                'code' => $personalDiseaseHistory->code,
                'name' => $personalDiseaseHistory->name
            ];

            $personalDiseaseHistory->delete();

            DB::commit();

            Log::info('Riwayat penyakit pribadi berhasil dihapus', [
                'deleted_data' => $deletedData,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('personal-disease-histories.index')
                ->with('success', 'Riwayat penyakit pribadi berhasil dihapus');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error saat menghapus riwayat penyakit pribadi', [
                'personal_disease_history_id' => $personalDiseaseHistory->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('personal-disease-histories.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }
}
