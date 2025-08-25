<?php

namespace App\Http\Controllers\Klinik;

use Exception;
use Illuminate\View\View;
use App\Exports\DrugsExport;
use App\Imports\DrugsImport;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\DataTables\Klinik\DrugsDataTable;
use App\Models\Klinik\{Drug, DrugUsage, Unit};
use Illuminate\Support\Facades\{Auth, DB, Log};
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\{Request, RedirectResponse, Response};
use App\Http\Requests\Klinik\{StoreDrugRequest, UpdateDrugRequest};

class DrugsController extends Controller
{
    private ?object $user;

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
     * Menampilkan daftar obat
     *
     * @param DrugsDataTable $dataTable
     * @return Response
     */
    public function index(DrugsDataTable $dataTable): JsonResponse|View
    {
        Log::info('Mengakses halaman daftar obat', ['user_id' => $this->user?->id]);

        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Akses ditolak untuk melihat data obat', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data master!');
        }

        return $dataTable->render('pages.klinik.drugs.index');
    }

    /**
     * Menampilkan form untuk membuat obat baru
     *
     * @return View
     */
    public function create(): View
    {
        Log::info('Mengakses form pembuatan obat', ['user_id' => $this->user?->id]);

        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk membuat data obat', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data master!');
        }

        $unit = Unit::all();

        return view('pages.klinik.drugs.create', compact('unit'));
    }

    /**
     * Menyimpan obat baru ke database
     *
     * @param StoreDrugRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDrugRequest $request): RedirectResponse
    {
        Log::info('Memulai proses penyimpanan obat baru', ['user_id' => $this->user?->id]);

        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk membuat data obat', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat data master!');
        }

        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $drug = Drug::create($validated);

            DB::commit();

            Log::info('Obat berhasil dibuat', [
                'user_id' => $this->user->id,
                'drug_id' => $drug->id,
                'drug_name' => $drug->name
            ]);

            session()->flash('success', 'Obat berhasil dibuat!');
            return redirect()->route('drugs.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal membuat obat', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menyimpan obat!');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Menampilkan detail obat tertentu
     *
     * @param Drug $drug
     * @return View
     */
    public function show(Drug $drug): View
    {
        Log::info('Mengakses detail obat', [
            'user_id' => $this->user?->id,
            'drug_id' => $drug->id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Akses ditolak untuk melihat detail obat', [
                'user_id' => $this->user?->id,
                'drug_id' => $drug->id
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data master!');
        }

        return view('pages.klinik.drugs.show', compact('drug'));
    }

    /**
     * Menampilkan form untuk mengedit obat
     *
     * @param Drug $drug
     * @return View
     */
    public function edit(Drug $drug): View
    {
        Log::info('Mengakses form edit obat', [
            'user_id' => $this->user?->id,
            'drug_id' => $drug->id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk mengedit obat', [
                'user_id' => $this->user?->id,
                'drug_id' => $drug->id
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data master!');
        }

        $unit = Unit::all();

        return view('pages.klinik.drugs.edit', compact('unit', 'drug'));
    }

    /**
     * Memperbarui data obat di database
     *
     * @param UpdateDrugRequest $request
     * @param Drug $drug
     * @return RedirectResponse
     */
    public function update(UpdateDrugRequest $request, Drug $drug): RedirectResponse
    {
        Log::info('Memulai proses update obat', [
            'user_id' => $this->user?->id,
            'drug_id' => $drug->id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk update obat', [
                'user_id' => $this->user?->id,
                'drug_id' => $drug->id
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit data master!');
        }

        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $oldData = $drug->toArray();
            $drug->update($validated);

            DB::commit();

            Log::info('Obat berhasil diperbarui', [
                'user_id' => $this->user->id,
                'drug_id' => $drug->id,
                'old_data' => $oldData,
                'new_data' => $validated
            ]);

            session()->flash('success', 'Obat berhasil diperbarui!');
            return redirect()->route('drugs.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal memperbarui obat', [
                'user_id' => $this->user->id,
                'drug_id' => $drug->id,
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            session()->flash('error', 'Terjadi kesalahan saat memperbarui obat!');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Menghapus obat dari database
     *
     * @param Drug $drug
     * @return RedirectResponse
     */
    public function destroy(Drug $drug): RedirectResponse
    {
        Log::info('Memulai proses penghapusan obat', [
            'user_id' => $this->user?->id,
            'drug_id' => $drug->id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Akses ditolak untuk menghapus obat', [
                'user_id' => $this->user?->id,
                'drug_id' => $drug->id
            ]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk menghapus data master!');
        }

        DB::beginTransaction();
        try {
            $drugData = $drug->toArray();
            $drug->delete();

            DB::commit();

            Log::info('Obat berhasil dihapus', [
                'user_id' => $this->user->id,
                'deleted_drug' => $drugData
            ]);

            session()->flash('success', 'Obat berhasil dihapus!');
            return redirect()->route('drugs.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal menghapus obat', [
                'user_id' => $this->user->id,
                'drug_id' => $drug->id,
                'error' => $e->getMessage()
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menghapus obat!');
            return redirect()->back();
        }
    }

    /**
     * Menampilkan form dan memproses penambahan stok obat
     *
     * @param Request $request
     * @param int $id
     * @return View|RedirectResponse
     */
    public function detail(Request $request, int $id): View|RedirectResponse
    {
        Log::info('Mengakses detail/penambahan stok obat', [
            'user_id' => $this->user?->id,
            'drug_id' => $id
        ]);

        $drug = Drug::findOrFail($id);

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'date' => 'required|date',
                'user_name' => 'required|string|max:255',
                'quantity' => 'required|integer|min:1',
                'description' => 'nullable|string|max:500',
            ]);

            DB::beginTransaction();
            try {
                $drug->increment('stock', $validated['quantity']);

                DrugUsage::create([
                    'drug_id' => $drug->id,
                    'date' => $validated['date'],
                    'user_name' => $validated['user_name'],
                    'quantity' => $validated['quantity'],
                    'description' => $validated['description'],
                ]);

                DB::commit();

                Log::info('Stok obat berhasil ditambah', [
                    'user_id' => $this->user?->id,
                    'drug_id' => $drug->id,
                    'quantity_added' => $validated['quantity'],
                    'new_stock' => $drug->fresh()->stock
                ]);

                session()->flash('success', 'Data penggunaan obat berhasil disimpan!');
                return redirect()->route('drugs.index');

            } catch (Exception $e) {
                DB::rollBack();

                Log::error('Gagal menambah stok obat', [
                    'user_id' => $this->user?->id,
                    'drug_id' => $drug->id,
                    'error' => $e->getMessage(),
                    'data' => $validated
                ]);

                session()->flash('error', 'Terjadi kesalahan saat menyimpan data!');
                return redirect()->back()->withInput();
            }
        }

        return view('pages.klinik.drugs.addstock', compact('drug'));
    }

    /**
     * Menampilkan form dan memproses pengurangan stok obat
     *
     * @param Request $request
     * @param int $id
     * @return View|RedirectResponse
     */
    public function reduceDetail(Request $request, int $id): View|RedirectResponse
    {
        Log::info('Mengakses pengurangan stok obat', [
            'user_id' => $this->user?->id,
            'drug_id' => $id
        ]);

        $drug = Drug::findOrFail($id);

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'date' => 'required|date',
                'user_name' => 'required|string|max:255',
                'quantity' => 'required|integer|min:1',
                'description' => 'nullable|string|max:500',
            ]);

            // Validasi stok mencukupi
            if ($drug->stock < $validated['quantity']) {
                session()->flash('error', 'Stok tidak mencukupi! Stok tersedia: ' . $drug->stock);
                return redirect()->back()->withInput();
            }

            DB::beginTransaction();
            try {
                $drug->decrement('stock', $validated['quantity']);

                DrugUsage::create([
                    'drug_id' => $drug->id,
                    'date' => $validated['date'],
                    'user_name' => $validated['user_name'],
                    'quantity' => -$validated['quantity'], // Negatif untuk pengurangan
                    'description' => $validated['description'],
                ]);

                DB::commit();

                Log::info('Stok obat berhasil dikurangi', [
                    'user_id' => $this->user?->id,
                    'drug_id' => $drug->id,
                    'quantity_reduced' => $validated['quantity'],
                    'new_stock' => $drug->fresh()->stock
                ]);

                session()->flash('success', 'Data penggunaan obat berhasil disimpan!');
                return redirect()->route('drugs.index');

            } catch (Exception $e) {
                DB::rollBack();

                Log::error('Gagal mengurangi stok obat', [
                    'user_id' => $this->user?->id,
                    'drug_id' => $drug->id,
                    'error' => $e->getMessage(),
                    'data' => $validated
                ]);

                session()->flash('error', 'Terjadi kesalahan saat menyimpan data!');
                return redirect()->back()->withInput();
            }
        }

        return view('pages.klinik.drugs.reducestock', compact('drug'));
    }

    /**
     * Memperbarui detail obat dengan penambahan stok (deprecated - gunakan detail())
     *
     * @param Request $request
     * @param Drug $drug
     * @return RedirectResponse
     */
    public function updateDetail(Request $request, Drug $drug): RedirectResponse
    {
        Log::warning('Menggunakan method deprecated updateDetail', [
            'user_id' => $this->user?->id,
            'drug_id' => $drug->id
        ]);

        $validated = $request->validate([
            'date' => 'required|date',
            'user_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $drug->increment('stock', $validated['quantity']);

            // Simpan ke session (legacy behavior)
            $history = [
                'date' => $validated['date'],
                'user_name' => $validated['user_name'],
                'quantity' => $validated['quantity'],
                'description' => $validated['description'],
            ];

            $histories = session('histories', []);
            if (!isset($histories[$drug->id])) {
                $histories[$drug->id] = [];
            }
            $histories[$drug->id][] = $history;
            session(['histories' => $histories]);

            DB::commit();

            Log::info('Detail obat berhasil diperbarui (legacy)', [
                'user_id' => $this->user?->id,
                'drug_id' => $drug->id,
                'quantity_added' => $validated['quantity']
            ]);

            session()->flash('success', 'Detail obat berhasil diperbarui.');
            return redirect()->route('drugs.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal memperbarui detail obat', [
                'user_id' => $this->user?->id,
                'drug_id' => $drug->id,
                'error' => $e->getMessage()
            ]);

            session()->flash('error', 'Terjadi kesalahan saat memperbarui detail obat!');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Menampilkan detail obat dengan history (deprecated)
     *
     * @param int $id
     * @return View
     */
    public function showDetail(int $id): View
    {
        Log::warning('Menggunakan method deprecated showDetail', [
            'user_id' => $this->user?->id,
            'drug_id' => $id
        ]);

        $drug = Drug::findOrFail($id);
        $histories = session('histories', []);
        $drugHistories = $histories[$drug->id] ?? [];

        return view('pages.klinik.drugs.addstock', compact('drug', 'drugHistories'));
    }

    /**
     * Memperbarui detail obat dengan pengurangan stok (deprecated - gunakan reduceDetail())
     *
     * @param Request $request
     * @param Drug $drug
     * @return RedirectResponse
     */
    public function updateDetailReduce(Request $request, Drug $drug): RedirectResponse
    {
        Log::warning('Menggunakan method deprecated updateDetailReduce', [
            'user_id' => $this->user?->id,
            'drug_id' => $drug->id
        ]);

        $validated = $request->validate([
            'date' => 'required|date',
            'user_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $drug->decrement('stock', $validated['quantity']);

            // Simpan ke session (legacy behavior)
            $history = [
                'date' => $validated['date'],
                'user_name' => $validated['user_name'],
                'quantity' => $validated['quantity'],
                'description' => $validated['description'],
            ];

            $histories1 = session('histories1', []);
            if (!isset($histories1[$drug->id])) {
                $histories1[$drug->id] = [];
            }
            $histories1[$drug->id][] = $history;
            session(['histories1' => $histories1]);

            DB::commit();

            Log::info('Detail obat berhasil diperbarui dengan pengurangan (legacy)', [
                'user_id' => $this->user?->id,
                'drug_id' => $drug->id,
                'quantity_reduced' => $validated['quantity']
            ]);

            session()->flash('success', 'Detail obat berhasil diperbarui.');
            return redirect()->route('drugs.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal memperbarui detail obat dengan pengurangan', [
                'user_id' => $this->user?->id,
                'drug_id' => $drug->id,
                'error' => $e->getMessage()
            ]);

            session()->flash('error', 'Terjadi kesalahan saat memperbarui detail obat!');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Menampilkan detail obat dengan history pengurangan (deprecated)
     *
     * @param int $id
     * @return View
     */
    public function showDetailReduce(int $id): View
    {
        Log::warning('Menggunakan method deprecated showDetailReduce', [
            'user_id' => $this->user?->id,
            'drug_id' => $id
        ]);

        $drug = Drug::findOrFail($id);
        $histories1 = session('histories1', []);
        $drugHistories1 = $histories1[$drug->id] ?? [];

        return view('pages.klinik.drugs.reducestock', compact('drug', 'drugHistories1'));
    }

    /**
     * Mengekspor data obat ke Excel
     *
     * @return BinaryFileResponse
     */
    public function export()
    {
        Log::info('Mengekspor data obat', ['user_id' => $this->user?->id]);

        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Akses ditolak untuk ekspor data obat', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data master!');
        }

        try {
            $filename = 'drugs-' . date('YmdHis') . '.xlsx';

            Log::info('Ekspor data obat berhasil', [
                'user_id' => $this->user->id,
                'filename' => $filename
            ]);

            return Excel::download(new DrugsExport, $filename);

        } catch (Exception $e) {
            Log::error('Gagal mengekspor data obat', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage()
            ]);

            session()->flash('error', 'Terjadi kesalahan saat mengekspor data!');
            return redirect()->back();
        }
    }

    /**
     * Mencari data KFA berdasarkan nama obat
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function kfaSearch(Request $request): JsonResponse
    {
        $request->validate([
            'drug_name' => 'required|string|min:2'
        ]);

        try {
            $drugName = $request->input('drug_name');
            
            // Gunakan KfaDrugSyncService untuk mencari data KFA
            $kfaService = app(\Modules\Klinik\App\Services\KfaDrugSyncService::class);
            $results = $kfaService->searchKfaProducts($drugName);

            Log::info('Pencarian KFA berhasil', [
                'user_id' => $this->user?->id,
                'drug_name' => $drugName,
                'results_count' => count($results)
            ]);

            return response()->json([
                'success' => true,
                'data' => $results
            ]);

        } catch (Exception $e) {
            Log::error('Gagal mencari data KFA', [
                'user_id' => $this->user?->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mencari data KFA'
            ], 500);
        }
    }

    /**
     * Memperbarui kfa_code untuk obat tertentu
     *
     * @param Request $request
     * @param Drug $drug
     * @return JsonResponse
     */
    public function updateKfaCode(Request $request, Drug $drug): JsonResponse
    {
        $request->validate([
            'kfa_code' => 'required|string',
            'kfa_name' => 'required|string',
            'kfa_manufacturer' => 'nullable|string',
            'kfa_strength' => 'nullable|string',
            'kfa_form' => 'nullable|string'
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk update KFA code', [
                'user_id' => $this->user?->id,
                'drug_id' => $drug->id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Maaf! Anda tidak memiliki izin untuk mengedit data master!'
            ], 403);
        }

        DB::beginTransaction();
        try {
            $oldKfaCode = $drug->kfa_code;
            
            $drug->update([
                'kfa_code' => $request->input('kfa_code'),
                'kfa_name' => $request->input('kfa_name'),
                'kfa_manufacturer' => $request->input('kfa_manufacturer'),
                'kfa_strength' => $request->input('kfa_strength'),
                'kfa_form' => $request->input('kfa_form'),
                'kfa_updated_at' => now()
            ]);

            DB::commit();

            Log::info('KFA code berhasil diperbarui', [
                'user_id' => $this->user->id,
                'drug_id' => $drug->id,
                'drug_name' => $drug->name,
                'old_kfa_code' => $oldKfaCode,
                'new_kfa_code' => $request->input('kfa_code'),
                'kfa_name' => $request->input('kfa_name')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'KFA code berhasil diperbarui',
                'data' => [
                    'kfa_code' => $drug->kfa_code,
                    'kfa_name' => $drug->kfa_name
                ]
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal memperbarui KFA code', [
                'user_id' => $this->user->id,
                'drug_id' => $drug->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui KFA code'
            ], 500);
        }
    }

    /**
     * Menampilkan form untuk import obat
     *
     * @return View
     */
    public function import(): View
    {
        Log::info('Mengakses form import obat', ['user_id' => $this->user?->id]);

        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk import data obat', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengimpor data master!');
        }

        return view('pages.klinik.drugs.import');
    }

    /**
     * Memproses file import obat
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function processImport(Request $request): RedirectResponse
    {
        Log::info('Memulai proses import obat', ['user_id' => $this->user?->id]);

        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk import data obat', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengimpor data master!');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $import = new DrugsImport();
            Excel::import($import, $request->file('file'));

            $failures = $import->failures();
            $errors = $import->errors();

            if ($failures->isNotEmpty() || $errors->isNotEmpty()) {
                $errorMessages = [];

                foreach ($failures as $failure) {
                    $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
                }

                foreach ($errors as $error) {
                    $errorMessages[] = $error;
                }

                Log::warning('Import selesai dengan error', [
                    'user_id' => $this->user->id,
                    'errors' => $errorMessages
                ]);

                DB::commit(); // Commit data yang berhasil
                session()->flash('warning', 'Import selesai dengan beberapa error: ' . implode(' | ', $errorMessages));
            } else {
                DB::commit();

                Log::info('Import obat berhasil', [
                    'user_id' => $this->user->id,
                    'filename' => $request->file('file')->getClientOriginalName()
                ]);

                session()->flash('success', 'Data obat berhasil diimpor!');
            }

            return redirect()->route('drugs.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengimpor data obat', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'filename' => $request->file('file')?->getClientOriginalName()
            ]);

            session()->flash('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
