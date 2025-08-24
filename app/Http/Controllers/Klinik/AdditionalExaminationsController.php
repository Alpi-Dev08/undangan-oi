<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreAdditionalExaminationRequest;
use App\Http\Requests\Klinik\UpdateAditionalExaminationRequest;
use App\Models\Klinik\Examination;
use App\Models\Klinik\AdditionalExamination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class AdditionalExaminationsController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar pemeriksaan tambahan
     *
     * @return Response
     */
    public function index(): Response
    {
        Log::info('AdditionalExaminationsController: Mengakses halaman index pemeriksaan tambahan', [
            'user_id' => $this->user?->id
        ]);

        // TODO: Implementasi logic untuk menampilkan daftar pemeriksaan tambahan
        return response()->view('klinik.additional-examinations.index');
    }

    /**
     * Menampilkan form untuk membuat pemeriksaan tambahan baru
     *
     * @return Response
     */
    public function create(): Response
    {
        Log::info('AdditionalExaminationsController: Mengakses halaman create pemeriksaan tambahan', [
            'user_id' => $this->user?->id
        ]);

        // TODO: Implementasi logic untuk menampilkan form create
        return response()->view('klinik.additional-examinations.create');
    }

    /**
     * Menyimpan pemeriksaan tambahan baru ke database
     * Menggunakan database transaction untuk memastikan konsistensi data
     *
     * @param StoreAdditionalExaminationRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdditionalExaminationRequest $request): RedirectResponse
    {
        // Validasi authorization
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('AdditionalExaminationsController: Unauthorized access attempt', [
                'user_id' => $this->user?->id,
                'action' => 'store'
            ]);
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        Log::info('AdditionalExaminationsController: Memulai proses store pemeriksaan tambahan', [
            'user_id' => $this->user->id,
            'examination_id' => $request->examination_id
        ]);

        // Mulai database transaction
        DB::beginTransaction();

        try {
            // Validasi data
            $validated = $request->validated();

            // Cari examination yang terkait
            $examination = Examination::findOrFail($request->examination_id);

            // Siapkan data untuk disimpan
            $validated['additional_value'] = json_encode($request->additional ?? []);

            // Simpan additional examination
            $additionalExamination = AdditionalExamination::create($validated);

            Log::info('AdditionalExaminationsController: Berhasil menyimpan pemeriksaan tambahan', [
                'user_id' => $this->user->id,
                'additional_examination_id' => $additionalExamination->id,
                'examination_id' => $examination->id
            ]);

            // Jika pemeriksaan selesai, update status examination
            if ($request->boolean('selesai')) {
                $examination->update(['status' => 'waiting payment']);

                Log::info('AdditionalExaminationsController: Status examination diupdate ke waiting payment', [
                    'examination_id' => $examination->id,
                    'old_status' => $examination->getOriginal('status'),
                    'new_status' => 'waiting payment'
                ]);

                // Commit transaction
                DB::commit();

                return redirect()
                    ->route('transactions.create', ['id' => $examination->id])
                    ->with('success', 'Other Examination successfully created');
            }

            // Commit transaction
            DB::commit();

            return redirect()
                ->route('examinations.edit', ['examination' => $request->examination_id])
                ->with('success', 'Additional Examination has been created !!');

        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            Log::error('AdditionalExaminationsController: Error saat menyimpan pemeriksaan tambahan', [
                'user_id' => $this->user->id,
                'examination_id' => $request->examination_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail pemeriksaan tambahan tertentu
     *
     * @param AdditionalExamination $additionalexamination
     * @return Response
     */
    public function show(AdditionalExamination $additionalexamination): Response
    {
        Log::info('AdditionalExaminationsController: Mengakses detail pemeriksaan tambahan', [
            'user_id' => $this->user?->id,
            'additional_examination_id' => $additionalexamination->id
        ]);

        // TODO: Implementasi logic untuk menampilkan detail
        return response()->view('klinik.additional-examinations.show', compact('additionalexamination'));
    }

    /**
     * Menampilkan form untuk mengedit pemeriksaan tambahan
     *
     * @param AdditionalExamination $additionalexamination
     * @return Response
     */
    public function edit(AdditionalExamination $additionalexamination): Response
    {
        Log::info('AdditionalExaminationsController: Mengakses halaman edit pemeriksaan tambahan', [
            'user_id' => $this->user?->id,
            'additional_examination_id' => $additionalexamination->id
        ]);

        // TODO: Implementasi logic untuk menampilkan form edit
        return response()->view('klinik.additional-examinations.edit', compact('additionalexamination'));
    }

    /**
     * Mengupdate pemeriksaan tambahan yang sudah ada
     * Menggunakan database transaction untuk memastikan konsistensi data
     *
     * @param UpdateAditionalExaminationRequest $request
     * @param AdditionalExamination $additionalexamination
     * @return RedirectResponse
     */
    public function update(UpdateAditionalExaminationRequest $request, AdditionalExamination $additionalexamination): RedirectResponse
    {
        // Validasi authorization
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('AdditionalExaminationsController: Unauthorized access attempt', [
                'user_id' => $this->user?->id,
                'action' => 'update',
                'additional_examination_id' => $additionalexamination->id
            ]);
            abort(403, 'Sorry !! You are Unauthorized to update any master data !');
        }

        Log::info('AdditionalExaminationsController: Memulai proses update pemeriksaan tambahan', [
            'user_id' => $this->user->id,
            'additional_examination_id' => $additionalexamination->id,
            'examination_id' => $request->examination_id
        ]);

        // Mulai database transaction
        DB::beginTransaction();

        try {
            // Validasi data
            $validated = $request->validated();

            // Cari examination yang terkait
            $examination = Examination::findOrFail($request->examination_id);

            // Siapkan data untuk diupdate
            $validated['additional_value'] = json_encode($request->additional ?? []);

            // Handle file upload jika ada
            if ($request->hasFile('file')) {
                $validated['file'] = $this->handleFileUpload($request, $examination);
            }

            // Update additional examination
            $additionalexamination->update($validated);

            Log::info('AdditionalExaminationsController: Berhasil mengupdate pemeriksaan tambahan', [
                'user_id' => $this->user->id,
                'additional_examination_id' => $additionalexamination->id,
                'examination_id' => $examination->id
            ]);

            // Jika pemeriksaan selesai, update status examination
            if ($request->boolean('selesai')) {
                $examination->update(['status' => 'done']);

                Log::info('AdditionalExaminationsController: Status examination diupdate ke done', [
                    'examination_id' => $examination->id,
                    'old_status' => $examination->getOriginal('status'),
                    'new_status' => 'done'
                ]);

                // Commit transaction
                DB::commit();

                return redirect()
                    ->route('transactions.create', ['id' => $examination->id])
                    ->with('success', 'Other Examination successfully updated');
            }

            // Commit transaction
            DB::commit();

            return redirect()
                ->route('examinations.edit', ['examination' => $request->examination_id])
                ->with('success', 'Additional Examination has been updated !!');

        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            Log::error('AdditionalExaminationsController: Error saat mengupdate pemeriksaan tambahan', [
                'user_id' => $this->user->id,
                'additional_examination_id' => $additionalexamination->id,
                'examination_id' => $request->examination_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate data. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus pemeriksaan tambahan dari database
     *
     * @param AdditionalExamination $additionalexamination
     * @return RedirectResponse
     */
    public function destroy(AdditionalExamination $additionalexamination): RedirectResponse
    {
        Log::info('AdditionalExaminationsController: Memulai proses hapus pemeriksaan tambahan', [
            'user_id' => $this->user?->id,
            'additional_examination_id' => $additionalexamination->id
        ]);

        // Validasi authorization
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('AdditionalExaminationsController: Unauthorized delete attempt', [
                'user_id' => $this->user?->id,
                'additional_examination_id' => $additionalexamination->id
            ]);
            abort(403, 'Sorry !! You are Unauthorized to delete any master data !');
        }

        // Mulai database transaction
        DB::beginTransaction();

        try {
            $additionalexamination->delete();

            Log::info('AdditionalExaminationsController: Berhasil menghapus pemeriksaan tambahan', [
                'user_id' => $this->user->id,
                'additional_examination_id' => $additionalexamination->id
            ]);

            // Commit transaction
            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Additional Examination has been deleted !!');

        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            Log::error('AdditionalExaminationsController: Error saat menghapus pemeriksaan tambahan', [
                'user_id' => $this->user->id,
                'additional_examination_id' => $additionalexamination->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
        }
    }

    /**
     * Handle upload file untuk pemeriksaan tambahan
     *
     * @param UpdateAditionalExaminationRequest $request
     * @param Examination $examination
     * @return string
     */
    private function handleFileUpload(UpdateAditionalExaminationRequest $request, Examination $examination): string
    {
        $uploadedFiles = [];
        $files = $request->file('file');

        foreach ($files as $key => $file) {
            if ($file->isValid()) {
                $originalName = $file->getClientOriginalName();
                $fileName = $key . '.' . $originalName;
                $storagePath = 'public/examinations/' . $examination->examination_code;

                // Store file
                $file->storeAs($storagePath, $fileName);
                $uploadedFiles[$key] = $fileName;

                Log::info('AdditionalExaminationsController: File berhasil diupload', [
                    'user_id' => $this->user->id,
                    'examination_code' => $examination->examination_code,
                    'file_name' => $fileName,
                    'original_name' => $originalName
                ]);
            }
        }

        return json_encode($uploadedFiles);
    }
}
