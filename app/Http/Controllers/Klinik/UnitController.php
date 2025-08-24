<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\UnitDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\{StoreUnitRequest, UpdateUnitRequest};
use App\Models\Klinik\Unit;
use Illuminate\Http\{RedirectResponse, Response};
use Illuminate\Support\Facades\{Auth, DB, Log};
use Illuminate\View\View;
use Exception;

/**
 * Controller untuk mengelola unit klinik
 * Menangani CRUD operations untuk unit
 */
class UnitController extends Controller
{
    public $user;

    /**
     * Inisialisasi middleware untuk autentikasi
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar unit
     *
     * @param UnitDataTable $dataTable
     * @return Response|View
     */
    public function index(UnitDataTable $dataTable)
    {
        Log::info('Mengakses halaman index unit', ['user_id' => $this->user?->id]);

        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Akses ditolak untuk melihat unit', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data unit!');
        }

        return $dataTable->render('pages.klinik.units.index');
    }

    /**
     * Menampilkan form untuk membuat unit baru
     *
     * @return View
     */
    public function create(): View
    {
        Log::info('Mengakses form create unit', ['user_id' => $this->user?->id]);

        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk membuat unit', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat unit!');
        }

        return view('pages.klinik.units.create');
    }

    /**
     * Menyimpan unit baru ke database
     *
     * @param StoreUnitRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUnitRequest $request): RedirectResponse
    {
        Log::info('Memulai proses store unit', [
            'user_id' => $this->user?->id,
            'unit_name' => $request->name
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk menyimpan unit', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat unit!');
        }

        try {
            DB::beginTransaction();

            // Validasi data sudah dilakukan di StoreUnitRequest
            $validated = $request->validated();

            // Buat unit baru
            $unit = Unit::create($validated);

            DB::commit();

            Log::info('Berhasil menyimpan unit', [
                'unit_id' => $unit->id,
                'unit_name' => $unit->name
            ]);

            session()->flash('success', 'Unit berhasil dibuat!');
            return redirect()->route('units.index');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan unit', [
                'error' => $e->getMessage(),
                'unit_name' => $request->name
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menyimpan unit!');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Menampilkan detail unit
     *
     * @param Unit $unit
     * @return Response
     */
    public function show(Unit $unit)
    {
        Log::info('Mengakses detail unit', [
            'user_id' => $this->user?->id,
            'unit_id' => $unit->id
        ]);

        // TODO: Implementasi show method
        return response()->json(['message' => 'Method belum diimplementasi']);
    }

    /**
     * Menampilkan form edit unit
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id)
    {
        Log::info('Mengakses form edit unit', [
            'user_id' => $this->user?->id,
            'unit_id' => $id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk edit unit', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit unit!');
        }

        try {
            $unit = Unit::findOrFail($id);

            Log::info('Berhasil memuat form edit unit', ['unit_id' => $id]);

            return view('pages.klinik.units.edit', compact('unit'));

        } catch (Exception $e) {
            Log::error('Gagal memuat form edit unit', [
                'error' => $e->getMessage(),
                'unit_id' => $id
            ]);

            session()->flash('error', 'Unit tidak ditemukan!');
            return redirect()->route('units.index');
        }
    }

    /**
     * Update unit yang sudah ada
     *
     * @param UpdateUnitRequest $request
     * @param Unit $unit
     * @return RedirectResponse
     */
    public function update(UpdateUnitRequest $request, Unit $unit): RedirectResponse
    {
        Log::info('Memulai proses update unit', [
            'user_id' => $this->user?->id,
            'unit_id' => $unit->id,
            'unit_name' => $request->name
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk update unit', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit unit!');
        }

        try {
            DB::beginTransaction();

            // Validasi data sudah dilakukan di UpdateUnitRequest
            $validated = $request->validated();

            // Update unit
            $unit->update($validated);

            DB::commit();

            Log::info('Berhasil update unit', [
                'unit_id' => $unit->id,
                'unit_name' => $unit->name
            ]);

            session()->flash('success', 'Unit berhasil diperbarui!');
            return redirect()->route('units.index');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal update unit', [
                'error' => $e->getMessage(),
                'unit_id' => $unit->id
            ]);

            session()->flash('error', 'Terjadi kesalahan saat memperbarui unit!');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Hapus unit
     *
     * @param Unit $unit
     * @return RedirectResponse
     */
    public function destroy(Unit $unit): RedirectResponse
    {
        Log::info('Memulai proses hapus unit', [
            'user_id' => $this->user?->id,
            'unit_id' => $unit->id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Akses ditolak untuk hapus unit', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk menghapus unit!');
        }

        try {
            DB::beginTransaction();

            // Cek apakah unit masih digunakan oleh drugs
            if ($unit->drugs()->exists()) {
                Log::warning('Unit tidak dapat dihapus karena masih digunakan', [
                    'unit_id' => $unit->id,
                    'drugs_count' => $unit->drugs()->count()
                ]);

                session()->flash('error', 'Unit tidak dapat dihapus karena masih digunakan oleh obat!');
                return redirect()->route('units.index');
            }

            $unit->delete();

            DB::commit();

            Log::info('Berhasil hapus unit', ['unit_id' => $unit->id]);

            session()->flash('success', 'Unit berhasil dihapus!');
            return redirect()->route('units.index');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal hapus unit', [
                'error' => $e->getMessage(),
                'unit_id' => $unit->id
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menghapus unit!');
            return redirect()->route('units.index');
        }
    }
}
