<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\HealthProfesionalTypesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\{
    StoreHealthProfesionalTypeRequest,
    UpdateHealthProfesionalTypeRequest
};
use App\Models\Klinik\{
    HealthProfesional,
    HealthProfesionalType
};
use App\Models\User;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Facades\{Auth, DB, Log};
use Illuminate\View\View;
use Throwable;

/**
 * Controller untuk mengelola tipe tenaga kesehatan (Health Professional Types)
 *
 * Menangani operasi CRUD untuk tipe tenaga kesehatan seperti:
 * - Dokter, Perawat, Bidan, Apoteker, dll
 */
class HealthProfesionalTypesController extends Controller
{
    private ?User $user;

    /**
     * Konstruktor controller dengan middleware otentikasi dan otorisasi
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function (Request $request, $next) {
            $this->user = Auth::guard('web')->user();

            Log::info('HealthProfesionalTypesController accessed', [
                'user_id' => $this->user?->id,
                'action' => $request->route()?->getActionName(),
                'ip' => $request->ip()
            ]);

            return $next($request);
        });
    }

    /**
     * Menampilkan daftar tipe tenaga kesehatan
     *
     * @param HealthProfesionalTypesDataTable $dataTable
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(HealthProfesionalTypesDataTable $dataTable): JsonResponse|View
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to health professional types index', [
                'user_id' => $this->user?->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to view any health professional types !');
        }

        Log::info('Health professional types index accessed', [
            'user_id' => $this->user->id
        ]);

        return $dataTable->render('pages.klinik.healthprofesionaltypes.index');
    }

    /**
     * Menampilkan form untuk membuat tipe tenaga kesehatan baru
     *
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized access attempt to create health professional type', [
                'user_id' => $this->user?->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to create any health professional types !');
        }

        Log::info('Health professional type create form accessed', [
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.healthprofesionaltypes.create');
    }

    /**
     * Menyimpan tipe tenaga kesehatan baru
     *
     * @param StoreHealthProfesionalTypeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreHealthProfesionalTypeRequest $request): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized access attempt to store health professional type', [
                'user_id' => $this->user?->id,
                'ip' => $request->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to create any health professional types !');
        }

        DB::beginTransaction();

        try {
            $validated = $request->validated();

            $healthProfesionalType = HealthProfesionalType::create($validated);

            DB::commit();

            Log::info('Health professional type created successfully', [
                'user_id' => $this->user->id,
                'health_professional_type_id' => $healthProfesionalType->id,
                'name' => $healthProfesionalType->name
            ]);

            return redirect()->route('healthprofesionaltypes.index')
                ->with('success', 'Tipe tenaga kesehatan berhasil ditambahkan!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Error creating health professional type', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->validated()
            ]);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail tipe tenaga kesehatan
     *
     * @param HealthProfesionalType $healthprofesionaltype
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(HealthProfesionalType $healthprofesionaltype)
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to view health professional type', [
                'user_id' => $this->user?->id,
                'health_professional_type_id' => $healthprofesionaltype->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to view this health professional type !');
        }

        try {
            $healthprofesionaltype->load(['healthProfesional']);

            Log::info('Health professional type detail viewed', [
                'user_id' => $this->user->id,
                'health_professional_type_id' => $healthprofesionaltype->id
            ]);

            return view('pages.klinik.healthprofesionaltypes.show', compact('healthprofesionaltype'));
        } catch (Throwable $e) {
            Log::error('Error loading health professional type detail', [
                'user_id' => $this->user->id,
                'health_professional_type_id' => $healthprofesionaltype->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memuat detail. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan form edit tipe tenaga kesehatan
     *
     * @param HealthProfesionalType $healthprofesionaltype
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(HealthProfesionalType $healthprofesionaltype): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized access attempt to edit health professional type', [
                'user_id' => $this->user?->id,
                'health_professional_type_id' => $healthprofesionaltype->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to update any health professional types !');
        }

        Log::info('Health professional type edit form accessed', [
            'user_id' => $this->user->id,
            'health_professional_type_id' => $healthprofesionaltype->id
        ]);

        return view('pages.klinik.healthprofesionaltypes.edit', compact('healthprofesionaltype'));
    }

    /**
     * Memperbarui data tipe tenaga kesehatan
     *
     * @param UpdateHealthProfesionalTypeRequest $request
     * @param HealthProfesionalType $healthprofesionaltype
     * @return RedirectResponse
     */
    public function update(UpdateHealthProfesionalTypeRequest $request, HealthProfesionalType $healthprofesionaltype): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized access attempt to update health professional type', [
                'user_id' => $this->user?->id,
                'health_professional_type_id' => $healthprofesionaltype->id,
                'ip' => $request->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to update any health professional types !');
        }

        DB::beginTransaction();

        try {
            $validated = $request->validated();

            $healthprofesionaltype->update($validated);

            DB::commit();

            Log::info('Health professional type updated successfully', [
                'user_id' => $this->user->id,
                'health_professional_type_id' => $healthprofesionaltype->id,
                'name' => $healthprofesionaltype->name
            ]);

            return redirect()->route('healthprofesionaltypes.index')
                ->with('success', 'Tipe tenaga kesehatan berhasil diperbarui!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Error updating health professional type', [
                'user_id' => $this->user->id,
                'health_professional_type_id' => $healthprofesionaltype->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus tipe tenaga kesehatan
     *
     * @param HealthProfesionalType $healthprofesionaltype
     * @return RedirectResponse
     */
    public function destroy(HealthProfesionalType $healthprofesionaltype): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Unauthorized access attempt to delete health professional type', [
                'user_id' => $this->user?->id,
                'health_professional_type_id' => $healthprofesionaltype->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to delete any health professional types !');
        }

        DB::beginTransaction();

        try {
            // Cek apakah tipe ini masih digunakan oleh health professionals
            $healthProfesionalCount = HealthProfesional::where('health_profesional_type_id', $healthprofesionaltype->id)->count();

            if ($healthProfesionalCount > 0) {
                Log::warning('Attempt to delete health professional type with existing relations', [
                    'user_id' => $this->user->id,
                    'health_professional_type_id' => $healthprofesionaltype->id,
                    'related_count' => $healthProfesionalCount
                ]);

                return back()->with('error', 'Tidak dapat menghapus tipe tenaga kesehatan yang masih digunakan oleh ' . $healthProfesionalCount . ' tenaga kesehatan.');
            }

            $healthprofesionaltype->delete();

            DB::commit();

            Log::info('Health professional type deleted successfully', [
                'user_id' => $this->user->id,
                'health_professional_type_id' => $healthprofesionaltype->id,
                'name' => $healthprofesionaltype->name
            ]);

            return redirect()->route('healthprofesionaltypes.index')
                ->with('success', 'Tipe tenaga kesehatan berhasil dihapus!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Error deleting health professional type', [
                'user_id' => $this->user->id,
                'health_professional_type_id' => $healthprofesionaltype->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
        }
    }
}
