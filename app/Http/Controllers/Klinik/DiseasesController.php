<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\DiseasesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreDiseaseRequest;
use App\Http\Requests\Klinik\UpdateDiseaseRequest;
use App\Models\Klinik\Disease;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Controller untuk mengelola data penyakit (diseases)
 * Menangani operasi CRUD untuk master data penyakit
 */
class DiseasesController extends Controller
{
    public ?object $user;

    /**
     * Konstruktor untuk inisialisasi middleware autentikasi
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar penyakit
     *
     * @param DiseasesDataTable $dataTable
     * @return View
     */
    public function index(DiseasesDataTable $dataTable): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to diseases index', [
                'user_id' => $this->user?->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        Log::info('Diseases index accessed', [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name
        ]);

        return $dataTable->render('pages.klinik.diseases.index');
    }

    /**
     * Menampilkan form untuk membuat penyakit baru
     *
     * @return View
     */
    public function create(): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized access attempt to create disease', [
                'user_id' => $this->user?->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        Log::info('Disease create form accessed', [
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.diseases.create');
    }

    /**
     * Menyimpan penyakit baru ke database
     *
     * @param StoreDiseaseRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDiseaseRequest $request): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized attempt to store disease', [
                'user_id' => $this->user?->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        try {
            DB::beginTransaction();

            $validatedData = $request->validated();
            $disease = Disease::create($validatedData);

            DB::commit();

            Log::info('Disease created successfully', [
                'disease_id' => $disease->id,
                'disease_name' => $disease->name,
                'user_id' => $this->user->id,
                'created_by' => $this->user->name
            ]);

            return redirect()->route('diseases.index')
                ->with('success', 'Disease berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to create disease', [
                'error' => $e->getMessage(),
                'user_id' => $this->user->id,
                'request_data' => $request->validated()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat disease. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail penyakit
     *
     * @param Disease $disease
     * @return View
     */
    public function show(Disease $disease): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to view disease', [
                'user_id' => $this->user?->id,
                'disease_id' => $disease->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to view disease !');
        }

        Log::info('Disease detail viewed', [
            'disease_id' => $disease->id,
            'disease_name' => $disease->name,
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.diseases.show', compact('disease'));
    }

    /**
     * Menampilkan form untuk mengedit penyakit
     *
     * @param Disease $disease
     * @return View
     */
    public function edit(Disease $disease): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized access attempt to edit disease', [
                'user_id' => $this->user?->id,
                'disease_id' => $disease->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        Log::info('Disease edit form accessed', [
            'disease_id' => $disease->id,
            'disease_name' => $disease->name,
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.diseases.edit', compact('disease'));
    }

    /**
     * Memperbarui penyakit di database
     *
     * @param UpdateDiseaseRequest $request
     * @param Disease $disease
     * @return RedirectResponse
     */
    public function update(UpdateDiseaseRequest $request, Disease $disease): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized attempt to update disease', [
                'user_id' => $this->user?->id,
                'disease_id' => $disease->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        try {
            DB::beginTransaction();

            $validatedData = $request->validated();
            $oldData = $disease->toArray();

            $disease->update($validatedData);

            DB::commit();

            Log::info('Disease updated successfully', [
                'disease_id' => $disease->id,
                'old_data' => $oldData,
                'new_data' => $disease->fresh()->toArray(),
                'user_id' => $this->user->id,
                'updated_by' => $this->user->name
            ]);

            return redirect()->route('diseases.index')
                ->with('success', 'Disease berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to update disease', [
                'error' => $e->getMessage(),
                'disease_id' => $disease->id,
                'user_id' => $this->user->id,
                'request_data' => $request->validated()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui disease. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus penyakit dari database
     *
     * @param Disease $disease
     * @return RedirectResponse
     */
    public function destroy(Disease $disease): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Unauthorized attempt to delete disease', [
                'user_id' => $this->user?->id,
                'disease_id' => $disease->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to delete any master data !');
        }

        try {
            DB::beginTransaction();

            $diseaseData = [
                'id' => $disease->id,
                'name' => $disease->name
            ];

            $disease->delete();

            DB::commit();

            Log::info('Disease deleted successfully', [
                'disease_data' => $diseaseData,
                'user_id' => $this->user->id,
                'deleted_by' => $this->user->name
            ]);

            return redirect()->route('diseases.index')
                ->with('success', 'Disease berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to delete disease', [
                'error' => $e->getMessage(),
                'disease_id' => $disease->id,
                'user_id' => $this->user->id
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menghapus disease. Silakan coba lagi.');
        }
    }
}
