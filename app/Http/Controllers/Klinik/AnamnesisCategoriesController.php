<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\AnamnesisCategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klinik\AnamnesisCategory;
use App\Http\Requests\Klinik\StoreAnamnesisCategoryRequest;
use App\Http\Requests\Klinik\UpdateAnamnesisCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AnamnesisCategoriesController extends Controller
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
     * Menampilkan daftar kategori anamnesis
     *
     * @param AnamnesisCategoriesDataTable $dataTable
     * @return Response
     */
    public function index(AnamnesisCategoriesDataTable $dataTable)
    {
        // Validasi authorization
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('AnamnesisCategoriesController: Unauthorized access attempt', [
                'user_id' => $this->user?->id,
                'action' => 'index'
            ]);
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        Log::info('AnamnesisCategoriesController: Mengakses halaman index kategori anamnesis', [
            'user_id' => $this->user->id
        ]);

        return $dataTable->render('pages.klinik.anamnesiscategories.index');
    }

    /**
     * Menampilkan form untuk membuat kategori anamnesis baru
     *
     * @return Response
     */
    public function create()
    {
        // Validasi authorization
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('AnamnesisCategoriesController: Unauthorized access attempt', [
                'user_id' => $this->user?->id,
                'action' => 'create'
            ]);
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        Log::info('AnamnesisCategoriesController: Mengakses halaman create kategori anamnesis', [
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.anamnesiscategories.create');
    }

    /**
     * Menyimpan kategori anamnesis baru ke database
     * Menggunakan database transaction untuk memastikan konsistensi data
     *
     * @param StoreAnamnesisCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAnamnesisCategoryRequest $request): RedirectResponse
    {
        // Validasi authorization
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('AnamnesisCategoriesController: Unauthorized access attempt', [
                'user_id' => $this->user?->id,
                'action' => 'store'
            ]);
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        Log::info('AnamnesisCategoriesController: Memulai proses store kategori anamnesis', [
            'user_id' => $this->user->id,
            'category_name' => $request->name
        ]);

        // Mulai database transaction
        DB::beginTransaction();

        try {
            // Validasi data
            $validated = $request->validated();

            // Simpan kategori anamnesis
            $anamnesisCategory = AnamnesisCategory::create($validated);

            Log::info('AnamnesisCategoriesController: Berhasil menyimpan kategori anamnesis', [
                'user_id' => $this->user->id,
                'category_id' => $anamnesisCategory->id,
                'category_name' => $anamnesisCategory->name
            ]);

            // Commit transaction
            DB::commit();

            return redirect()
                ->route('anamnesiscategories.index')
                ->with('success', 'AnamnesisCategory has been created !!');

        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            Log::error('AnamnesisCategoriesController: Error saat menyimpan kategori anamnesis', [
                'user_id' => $this->user->id,
                'category_name' => $request->name,
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
     * Menampilkan form untuk mengedit kategori anamnesis
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        // Validasi authorization
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('AnamnesisCategoriesController: Unauthorized access attempt', [
                'user_id' => $this->user?->id,
                'action' => 'edit',
                'category_id' => $id
            ]);
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        Log::info('AnamnesisCategoriesController: Mengakses halaman edit kategori anamnesis', [
            'user_id' => $this->user->id,
            'category_id' => $id
        ]);

        $anamnesiscategory = AnamnesisCategory::findOrFail($id);

        return view('pages.klinik.anamnesiscategories.edit', compact('anamnesiscategory'));
    }

    /**
     * Mengupdate kategori anamnesis yang sudah ada
     * Menggunakan database transaction untuk memastikan konsistensi data
     *
     * @param UpdateAnamnesisCategoryRequest $request
     * @param AnamnesisCategory $anamnesiscategory
     * @return RedirectResponse
     */
    public function update(UpdateAnamnesisCategoryRequest $request, AnamnesisCategory $anamnesiscategory): RedirectResponse
    {
        // Validasi authorization
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('AnamnesisCategoriesController: Unauthorized access attempt', [
                'user_id' => $this->user?->id,
                'action' => 'update',
                'category_id' => $anamnesiscategory->id
            ]);
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        Log::info('AnamnesisCategoriesController: Memulai proses update kategori anamnesis', [
            'user_id' => $this->user->id,
            'category_id' => $anamnesiscategory->id,
            'old_name' => $anamnesiscategory->name,
            'new_name' => $request->name
        ]);

        // Mulai database transaction
        DB::beginTransaction();

        try {
            // Validasi data
            $validated = $request->validated();

            // Update kategori anamnesis
            $anamnesiscategory->update($validated);

            Log::info('AnamnesisCategoriesController: Berhasil mengupdate kategori anamnesis', [
                'user_id' => $this->user->id,
                'category_id' => $anamnesiscategory->id,
                'category_name' => $anamnesiscategory->name
            ]);

            // Commit transaction
            DB::commit();

            return redirect()
                ->route('anamnesiscategories.index')
                ->with('success', 'Anamnesis Category has been updated !!');

        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            Log::error('AnamnesisCategoriesController: Error saat mengupdate kategori anamnesis', [
                'user_id' => $this->user->id,
                'category_id' => $anamnesiscategory->id,
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
     * Menghapus kategori anamnesis dari database
     * Menggunakan database transaction untuk memastikan konsistensi data
     *
     * @param AnamnesisCategory $anamnesiscategory
     * @return RedirectResponse
     */
    public function destroy(AnamnesisCategory $anamnesiscategory): RedirectResponse
    {
        // Validasi authorization
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('AnamnesisCategoriesController: Unauthorized access attempt', [
                'user_id' => $this->user?->id,
                'action' => 'destroy',
                'category_id' => $anamnesiscategory->id
            ]);
            abort(403, 'Sorry !! You are Unauthorized to delete any master data !');
        }

        Log::info('AnamnesisCategoriesController: Memulai proses hapus kategori anamnesis', [
            'user_id' => $this->user->id,
            'category_id' => $anamnesiscategory->id,
            'category_name' => $anamnesiscategory->name
        ]);

        // Mulai database transaction
        DB::beginTransaction();

        try {
            // Hapus kategori anamnesis (soft delete)
            $anamnesiscategory->delete();

            Log::info('AnamnesisCategoriesController: Berhasil menghapus kategori anamnesis', [
                'user_id' => $this->user->id,
                'category_id' => $anamnesiscategory->id
            ]);

            // Commit transaction
            DB::commit();

            return redirect()
                ->route('anamnesiscategories.index')
                ->with('success', 'Anamnesis Category has been deleted !!');

        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            Log::error('AnamnesisCategoriesController: Error saat menghapus kategori anamnesis', [
                'user_id' => $this->user->id,
                'category_id' => $anamnesiscategory->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
        }
    }
}
