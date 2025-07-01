<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\PackagesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klinik\Package;
use App\Http\Requests\Klinik\StorePackageRequest;
use App\Http\Requests\Klinik\UpdatePackageRequest;
use App\Models\Klinik\PackageDetail;
use App\Models\Klinik\Service;
use App\Models\Klinik\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Throwable;

/**
 * Controller untuk mengelola paket layanan klinik
 *
 * @package App\Http\Controllers\Klinik
 */
class PackagesController extends Controller
{
    /**
     * User yang sedang login
     */
    public ?object $user;

    /**
     * Constructor - Setup middleware dan user authentication
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });

        // Middleware untuk otorisasi
        $this->middleware('can:klinik.read')->only(['index', 'show']);
        $this->middleware('can:klinik.create')->only(['create', 'store']);
        $this->middleware('can:klinik.update')->only(['edit', 'update']);
        $this->middleware('can:klinik.delete')->only(['destroy']);
    }

    /**
     * Menampilkan daftar paket layanan
     *
     * @param PackagesDataTable $dataTable
     * @return Response
     */
    public function index(PackagesDataTable $dataTable): Response
    {
        Log::info('Mengakses halaman daftar paket layanan', [
            'user_id' => $this->user?->id,
            'user_name' => $this->user?->name
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Akses ditolak untuk melihat daftar paket layanan', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data paket layanan.');
        }

        return $dataTable->render('pages.klinik.packages.index');
    }

    /**
     * Menampilkan form untuk membuat paket layanan baru
     *
     * @return View
     */
    public function create()
    {
        Log::info('Mengakses form pembuatan paket layanan', [
            'user_id' => $this->user?->id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk membuat paket layanan', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat paket layanan.');
        }

        try {
            $service_categories = ServiceCategory::select('id', 'name')
                ->orderBy('name')
                ->get();

            Log::info('Data kategori layanan berhasil dimuat', [
                'categories_count' => $service_categories->count()
            ]);

            return view('pages.klinik.packages.create', compact('service_categories'));
        } catch (Throwable $e) {
            Log::error('Gagal memuat data kategori layanan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors('Terjadi kesalahan saat memuat data kategori layanan.');
        }
    }

    /**
     * Menyimpan paket layanan baru ke database
     *
     * @param StorePackageRequest $request
     * @return RedirectResponse
     */
    public function store(StorePackageRequest $request): RedirectResponse
    {
        Log::info('Memulai proses pembuatan paket layanan', [
            'user_id' => $this->user?->id,
            'data' => $request->validated()
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk membuat paket layanan', [
                'user_id' => $this->user?->id,
                'permission' => 'klinik.create'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat paket layanan.');
        }

        // Validasi data
        $validated = $request->validated();

        // Validasi tambahan untuk service_id
        $request->validate([
            'service_id' => 'required|array|min:1',
            'service_id.*' => 'required|exists:services,id'
        ], [
            'service_id.required' => 'Minimal satu layanan harus dipilih.',
            'service_id.array' => 'Format layanan tidak valid.',
            'service_id.min' => 'Minimal satu layanan harus dipilih.',
            'service_id.*.exists' => 'Layanan yang dipilih tidak valid.'
        ]);

        // Cek duplikasi nama paket
        $existingPackage = Package::where('name', $validated['name'])
            ->whereNull('deleted_at')
            ->first();

        if ($existingPackage) {
            Log::warning('Nama paket sudah ada', [
                'name' => $validated['name'],
                'existing_id' => $existingPackage->id
            ]);

            return back()
                ->withInput()
                ->withErrors(['name' => 'Nama paket sudah digunakan. Silakan gunakan nama lain.']);
        }

        DB::beginTransaction();
        try {
            // Buat paket baru
            $package = Package::create($validated);

            Log::info('Paket layanan berhasil dibuat', [
                'package_id' => $package->id,
                'package_name' => $package->name
            ]);

            // Hapus detail paket yang ada (jika ada)
            PackageDetail::where('package_id', $package->id)->delete();

            // Tambahkan detail paket baru
            $packageDetails = [];
            foreach ($request->service_id as $service_id) {
                // Validasi service exists
                $service = Service::find($service_id);
                if (!$service) {
                    throw new Exception("Layanan dengan ID {$service_id} tidak ditemukan.");
                }

                $packageDetails[] = [
                    'package_id' => $package->id,
                    'service_id' => $service->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            PackageDetail::insert($packageDetails);

            Log::info('Detail paket layanan berhasil ditambahkan', [
                'package_id' => $package->id,
                'services_count' => count($packageDetails)
            ]);

            DB::commit();

            Log::info('Paket layanan berhasil dibuat lengkap dengan detail', [
                'package_id' => $package->id,
                'user_id' => $this->user->id
            ]);

            return redirect()
                ->route('packages.index')
                ->with('success', 'Paket layanan berhasil dibuat!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal membuat paket layanan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->user?->id,
                'data' => $validated
            ]);

            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat membuat paket layanan. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail paket layanan
     *
     * @param Package $package
     * @return View
     */
    public function show(Package $package)
    {
        Log::info('Mengakses detail paket layanan', [
            'package_id' => $package->id,
            'user_id' => $this->user?->id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Akses ditolak untuk melihat detail paket layanan', [
                'package_id' => $package->id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.read'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat detail paket layanan.');
        }

        try {
            $package->load(['package_details.service']);

            return view('pages.klinik.packages.show', compact('package'));
        } catch (Throwable $e) {
            Log::error('Gagal memuat detail paket layanan', [
                'package_id' => $package->id,
                'error' => $e->getMessage()
            ]);

            return back()->withErrors('Terjadi kesalahan saat memuat detail paket layanan.');
        }
    }

    /**
     * Menampilkan form untuk mengedit paket layanan
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        Log::info('Mengakses form edit paket layanan', [
            'package_id' => $id,
            'user_id' => $this->user?->id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk mengedit paket layanan', [
                'package_id' => $id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit paket layanan.');
        }

        try {
            $package = Package::findOrFail($id);

            $packageDetail = PackageDetail::where('package_id', $id)
                ->pluck('service_id')
                ->toArray();

            $service_categories = ServiceCategory::select('id', 'name')
                ->orderBy('name')
                ->get();

            Log::info('Data edit paket layanan berhasil dimuat', [
                'package_id' => $package->id,
                'services_count' => count($packageDetail),
                'categories_count' => $service_categories->count()
            ]);

            return view('pages.klinik.packages.edit', compact([
                'package',
                'packageDetail',
                'service_categories'
            ]));

        } catch (Throwable $e) {
            Log::error('Gagal memuat data edit paket layanan', [
                'package_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('packages.index')
                ->withErrors('Paket layanan tidak ditemukan atau terjadi kesalahan.');
        }
    }

    /**
     * Memperbarui paket layanan di database
     *
     * @param UpdatePackageRequest $request
     * @param Package $package
     * @return RedirectResponse
     */
    public function update(UpdatePackageRequest $request, Package $package): RedirectResponse
    {
        Log::info('Memulai proses update paket layanan', [
            'package_id' => $package->id,
            'user_id' => $this->user?->id,
            'data' => $request->validated()
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk update paket layanan', [
                'package_id' => $package->id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.update'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit paket layanan.');
        }

        // Validasi data
        $validated = $request->validated();

        // Validasi tambahan untuk service_id
        $request->validate([
            'service_id' => 'required|array|min:1',
            'service_id.*' => 'required|exists:services,id'
        ], [
            'service_id.required' => 'Minimal satu layanan harus dipilih.',
            'service_id.array' => 'Format layanan tidak valid.',
            'service_id.min' => 'Minimal satu layanan harus dipilih.',
            'service_id.*.exists' => 'Layanan yang dipilih tidak valid.'
        ]);

        // Cek duplikasi nama paket (kecuali paket saat ini)
        $existingPackage = Package::where('name', $validated['name'])
            ->where('id', '!=', $package->id)
            ->whereNull('deleted_at')
            ->first();

        if ($existingPackage) {
            Log::warning('Nama paket sudah ada saat update', [
                'name' => $validated['name'],
                'existing_id' => $existingPackage->id,
                'current_id' => $package->id
            ]);

            return back()
                ->withInput()
                ->withErrors(['name' => 'Nama paket sudah digunakan. Silakan gunakan nama lain.']);
        }

        DB::beginTransaction();
        try {
            // Update paket
            $package->update($validated);

            Log::info('Data paket layanan berhasil diupdate', [
                'package_id' => $package->id,
                'package_name' => $package->name
            ]);

            // Hapus detail paket yang ada
            PackageDetail::where('package_id', $package->id)->delete();

            // Tambahkan detail paket baru
            $packageDetails = [];
            foreach ($request->service_id as $service_id) {
                // Validasi service exists
                $service = Service::find($service_id);
                if (!$service) {
                    throw new Exception("Layanan dengan ID {$service_id} tidak ditemukan.");
                }

                $packageDetails[] = [
                    'package_id' => $package->id,
                    'service_id' => $service->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            PackageDetail::insert($packageDetails);

            Log::info('Detail paket layanan berhasil diupdate', [
                'package_id' => $package->id,
                'services_count' => count($packageDetails)
            ]);

            DB::commit();

            Log::info('Paket layanan berhasil diupdate lengkap dengan detail', [
                'package_id' => $package->id,
                'user_id' => $this->user->id
            ]);

            return redirect()
                ->route('packages.index')
                ->with('success', 'Paket layanan berhasil diperbarui!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal update paket layanan', [
                'package_id' => $package->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->user?->id,
                'data' => $validated
            ]);

            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat memperbarui paket layanan. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus paket layanan dari database
     *
     * @param Package $package
     * @return RedirectResponse
     */
    public function destroy(Package $package): RedirectResponse
    {
        Log::info('Memulai proses hapus paket layanan', [
            'package_id' => $package->id,
            'package_name' => $package->name,
            'user_id' => $this->user?->id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Akses ditolak untuk hapus paket layanan', [
                'package_id' => $package->id,
                'user_id' => $this->user?->id,
                'permission' => 'klinik.delete'
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk menghapus paket layanan.');
        }

        DB::beginTransaction();
        try {
            // Hapus detail paket terlebih dahulu
            PackageDetail::where('package_id', $package->id)->delete();

            // Hapus paket (soft delete)
            $package->delete();

            DB::commit();

            Log::info('Paket layanan berhasil dihapus', [
                'package_id' => $package->id,
                'user_id' => $this->user->id
            ]);

            return redirect()
                ->route('packages.index')
                ->with('success', 'Paket layanan berhasil dihapus!');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal menghapus paket layanan', [
                'package_id' => $package->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->user?->id
            ]);

            return back()->withErrors('Terjadi kesalahan saat menghapus paket layanan. Silakan coba lagi.');
        }
    }
}
