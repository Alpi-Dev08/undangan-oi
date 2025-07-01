<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\PhysicalsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StorePhysicalRequest;
use App\Http\Requests\Klinik\UpdatePhysicalRequest;
use App\Models\Klinik\Physical;
use App\Models\Klinik\PhysicalCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Class PhysicalsController
 *
 * Mengelola operasi CRUD untuk data fisik pemeriksaan
 *
 * @package App\Http\Controllers\Klinik
 */
class PhysicalsController extends Controller
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
     * Menampilkan daftar data fisik pemeriksaan
     *
     * @param PhysicalsDataTable $dataTable
     * @return View
     * @throws AuthorizationException
     */
    public function index(PhysicalsDataTable $dataTable)
    {
        Gate::authorize('klinik.read');

        Log::info('Physical index accessed', [
            'user_id' => $this->user->id,
            'user_email' => $this->user->email
        ]);

        return $dataTable->render('pages.klinik.physicals.index');
    }

    /**
     * Menampilkan form untuk membuat data fisik pemeriksaan baru
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create()
    {
        Gate::authorize('klinik.create');

        try {
            $categories = PhysicalCategory::orderBy('name')->get();

            Log::info('Physical create form accessed', [
                'user_id' => $this->user->id,
                'categories_count' => $categories->count()
            ]);

            return view('pages.klinik.physicals.create', compact('categories'));
        } catch (Exception $e) {
            Log::error('Error accessing physical create form', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memuat form. Silakan coba lagi.');
        }
    }

    /**
     * Menyimpan data fisik pemeriksaan baru ke database
     *
     * @param StorePhysicalRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StorePhysicalRequest $request): RedirectResponse
    {
        Gate::authorize('klinik.create');

        DB::beginTransaction();

        try {
            // Check for duplicate name (case-insensitive)
            $existingPhysical = Physical::whereRaw('LOWER(name) = ?', [strtolower($request->name)])
                ->first();

            if ($existingPhysical) {
                Log::warning('Attempt to create duplicate physical', [
                    'user_id' => $this->user->id,
                    'name' => $request->name,
                    'existing_id' => $existingPhysical->id
                ]);

                return back()
                    ->withInput()
                    ->with('error', 'Data fisik dengan nama tersebut sudah ada.');
            }

            // Validate physical category exists
            $category = PhysicalCategory::find($request->physical_category_id);
            if (!$category) {
                Log::warning('Attempt to create physical with invalid category', [
                    'user_id' => $this->user->id,
                    'category_id' => $request->physical_category_id
                ]);

                return back()
                    ->withInput()
                    ->with('error', 'Kategori fisik tidak valid.');
            }

            // Sanitize and validate JSON options
            $options = null;
            if ($request->filled('options')) {
                $decodedOptions = json_decode($request->options, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::warning('Invalid JSON options provided', [
                        'user_id' => $this->user->id,
                        'options' => $request->options,
                        'json_error' => json_last_error_msg()
                    ]);

                    return back()
                        ->withInput()
                        ->with('error', 'Format opsi tidak valid.');
                }
                $options = $request->options;
            }

            // Create physical
            $physical = Physical::create([
                'name' => trim($request->name),
                'physical_category_id' => $request->physical_category_id,
                'options' => $options
            ]);

            DB::commit();

            Log::info('Physical created successfully', [
                'user_id' => $this->user->id,
                'physical_id' => $physical->id,
                'name' => $physical->name,
                'category_id' => $physical->physical_category_id
            ]);

            return redirect()
                ->route('physicals.index')
                ->with('success', 'Data fisik berhasil dibuat!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error creating physical', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'request_data' => $request->validated()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail data fisik pemeriksaan
     *
     * @param Physical $physical
     * @return View
     * @throws AuthorizationException
     */
    public function show(Physical $physical): View
    {
        Gate::authorize('klinik.read');

        Log::info('Physical detail viewed', [
            'user_id' => $this->user->id,
            'physical_id' => $physical->id
        ]);

        return view('pages.klinik.physicals.show', compact('physical'));
    }

    /**
     * Menampilkan form untuk mengedit data fisik pemeriksaan
     *
     * @param int $id
     * @return View|RedirectResponse
     * @throws AuthorizationException
     */
    public function edit(int $id)
    {
        Gate::authorize('klinik.update');

        try {
            $physical = Physical::findOrFail($id);
            $categories = PhysicalCategory::orderBy('name')->get();

            Log::info('Physical edit form accessed', [
                'user_id' => $this->user->id,
                'physical_id' => $physical->id
            ]);

            return view('pages.klinik.physicals.edit', compact('physical', 'categories'));
        } catch (Exception $e) {
            Log::error('Error accessing physical edit form', [
                'user_id' => $this->user->id,
                'physical_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('physicals.index')
                ->with('error', 'Data fisik tidak ditemukan.');
        }
    }

    /**
     * Memperbarui data fisik pemeriksaan di database
     *
     * @param UpdatePhysicalRequest $request
     * @param Physical $physical
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdatePhysicalRequest $request, Physical $physical): RedirectResponse
    {
        Gate::authorize('klinik.update');

        DB::beginTransaction();

        try {
            // Check for duplicate name (case-insensitive) excluding current record
            $existingPhysical = Physical::whereRaw('LOWER(name) = ?', [strtolower($request->name)])
                ->where('id', '!=', $physical->id)
                ->first();

            if ($existingPhysical) {
                Log::warning('Attempt to update physical with duplicate name', [
                    'user_id' => $this->user->id,
                    'physical_id' => $physical->id,
                    'name' => $request->name,
                    'existing_id' => $existingPhysical->id
                ]);

                return back()
                    ->withInput()
                    ->with('error', 'Data fisik dengan nama tersebut sudah ada.');
            }

            // Validate physical category exists
            $category = PhysicalCategory::find($request->physical_category_id);
            if (!$category) {
                Log::warning('Attempt to update physical with invalid category', [
                    'user_id' => $this->user->id,
                    'physical_id' => $physical->id,
                    'category_id' => $request->physical_category_id
                ]);

                return back()
                    ->withInput()
                    ->with('error', 'Kategori fisik tidak valid.');
            }

            // Sanitize and validate JSON options
            $options = null;
            if ($request->filled('options')) {
                $decodedOptions = json_decode($request->options, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::warning('Invalid JSON options provided for update', [
                        'user_id' => $this->user->id,
                        'physical_id' => $physical->id,
                        'options' => $request->options,
                        'json_error' => json_last_error_msg()
                    ]);

                    return back()
                        ->withInput()
                        ->with('error', 'Format opsi tidak valid.');
                }
                $options = $request->options;
            }

            // Store old data for logging
            $oldData = $physical->toArray();

            // Update physical
            $physical->update([
                'name' => trim($request->name),
                'physical_category_id' => $request->physical_category_id,
                'options' => $options
            ]);

            DB::commit();

            Log::info('Physical updated successfully', [
                'user_id' => $this->user->id,
                'physical_id' => $physical->id,
                'old_data' => $oldData,
                'new_data' => $physical->fresh()->toArray()
            ]);

            return redirect()
                ->route('physicals.index')
                ->with('success', 'Data fisik berhasil diperbarui!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error updating physical', [
                'user_id' => $this->user->id,
                'physical_id' => $physical->id,
                'error' => $e->getMessage(),
                'request_data' => $request->validated()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus data fisik pemeriksaan dari database
     *
     * @param Physical $physical
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Physical $physical): RedirectResponse
    {
        Gate::authorize('klinik.delete');

        DB::beginTransaction();

        try {
            // Check if physical is being used in examinations
            $isUsed = DB::table('physical_examinations')
                ->join('physicals', 'physical_examinations.physical_id', '=', 'physicals.id')
                ->where('physicals.id', $physical->id)
                ->exists();

            if ($isUsed) {
                Log::warning('Attempt to delete physical that is in use', [
                    'user_id' => $this->user->id,
                    'physical_id' => $physical->id
                ]);

                return back()->with('error', 'Data fisik tidak dapat dihapus karena sedang digunakan dalam pemeriksaan.');
            }

            // Store data for logging before deletion
            $deletedData = $physical->toArray();

            $physical->delete();

            DB::commit();

            Log::info('Physical deleted successfully', [
                'user_id' => $this->user->id,
                'deleted_data' => $deletedData
            ]);

            return redirect()
                ->route('physicals.index')
                ->with('success', 'Data fisik berhasil dihapus!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error deleting physical', [
                'user_id' => $this->user->id,
                'physical_id' => $physical->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
        }
    }
}
