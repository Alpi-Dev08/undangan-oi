<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Models\Klinik\{Examination, Prescription, PrescriptionItem};
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Facades\{Auth, DB, Log};

class PrescriptionsController extends Controller
{
    /**
     * Menampilkan daftar resep yang masuk.
     *
     * - Mendukung filter sederhana (status, kata kunci pasien/kode pemeriksaan)
     * - Menggunakan transaksi DB untuk konsistensi baca sesuai kebiasaan proyek
     * - Logging tiap langkah dan nilai kembali
     */
    public function index(Request $request)
    {
        Log::info('Akses halaman daftar resep', [
            'actor_id' => Auth::id(),
            'filters' => $request->only(['status', 'q']),
        ]);

        DB::beginTransaction();
        try {
            $query = Prescription::with(['examination.patient', 'doctor'])
                ->orderByDesc('id');

            if ($status = $request->string('status')->toString()) {
                $query->where('status', $status);
            }
            if ($q = $request->string('q')->toString()) {
                $query->where(function ($sub) use ($q) {
                    $sub->whereHas('examination', function ($ex) use ($q) {
                        $ex->where('examination_code', 'like', "%$q%");
                    })->orWhereHas('examination.patient', function ($pa) use ($q) {
                        $pa->where('patient_code', 'like', "%$q%");
                    });
                });
            }

            $prescriptions = $query->paginate(15);

            DB::commit();
            Log::info('Berhasil memuat daftar resep', ['count' => $prescriptions->total()]);

            return view('pages.klinik.prescriptions.index', compact('prescriptions'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memuat daftar resep', [
                'error' => $e->getMessage(),
            ]);
            return view('pages.klinik.prescriptions.index', [
                'prescriptions' => collect(),
                'error' => 'Gagal memuat daftar resep',
            ]);
        }
    }

    /**
     * Cetak resep (view khusus cetak) untuk satu prescription.
     *
     * - Memuat relasi pemeriksaan, pasien, dokter, dan item
     * - Transaksi baca + logging
     */
    public function print(Prescription $prescription)
    {
        Log::info('Akses cetak resep', [
            'actor_id' => Auth::id(),
            'prescription_id' => $prescription->id,
        ]);

        DB::beginTransaction();
        try {
            $prescription->load(['examination.patient', 'doctor', 'items']);
            DB::commit();
            Log::info('Data cetak resep dimuat', ['items' => $prescription->items->count()]);
            return view('pages.klinik.prescriptions.print', compact('prescription'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memuat data cetak resep', [
                'error' => $e->getMessage(),
            ]);
            abort(500, 'Gagal memuat data cetak resep');
        }
    }

    /**
     * Ubah status resep (saved/printed/dispensed/cancelled).
     *
     * - Validasi nilai status
     * - Transaksi commit/rollback dan logging
     * - Mengembalikan JSON atau redirect sesuai kebutuhan
     */
    public function updateStatus(Request $request, Prescription $prescription)
    {
        Log::info('Permintaan ubah status resep', [
            'actor_id' => Auth::id(),
            'prescription_id' => $prescription->id,
            'input' => $request->all(),
        ]);

        $validated = $request->validate([
            'status' => ['required', 'in:saved,printed,dispensed,cancelled'],
        ]);

        DB::beginTransaction();
        try {
            $prescription->status = $validated['status'];
            $prescription->save();
            DB::commit();
            Log::info('Status resep diperbarui', [
                'prescription_id' => $prescription->id,
                'status' => $prescription->status,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status resep diperbarui',
                    'data' => $prescription,
                ]);
            }

            return redirect()->back()->with('success', 'Status resep diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui status resep', [
                'error' => $e->getMessage(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui status resep',
                    'error' => $e->getMessage(),
                ], 422);
            }

            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui status resep']);
        }
    }

    /**
     * Menyimpan data resep untuk sebuah pemeriksaan.
     *
     * - Melakukan validasi input header dan items
     * - Menggunakan transaksi database (begin/commit/rollback)
     * - Logging setiap tahapan proses dan hasil return
     * - Mendukung respons JSON atau redirect sesuai kebutuhan
     */
    public function store(Request $request)
    {
        Log::info('Mulai proses simpan resep', [
            'actor_id' => Auth::id(),
            'expects_json' => $request->expectsJson(),
        ]);

        // Validasi dasar
        $validated = $request->validate([
            'examination_id'        => ['required', 'integer', 'exists:examinations,id'],
            'resep_date'            => ['nullable', 'date'],
            'catatan_umum'          => ['nullable', 'string'],
            'items'                 => ['required', 'array', 'min:1'],
            'items.*.drug_id'       => ['nullable', 'integer', 'exists:drugs,id'],
            'items.*.drug_name'     => ['nullable', 'string'],
            'items.*.kfa_code'      => ['nullable', 'string'],
            'items.*.qty'           => ['required', 'integer', 'min:1'],
            'items.*.unit'          => ['nullable', 'string'],
            'items.*.dosis'         => ['nullable', 'string'],
            'items.*.aturan_pakai'  => ['nullable', 'string'],
            'items.*.keterangan'    => ['nullable', 'string'],
            'items.*.perintah_perawat' => ['nullable', 'string'],
        ]);

        Log::info('Validasi input resep berhasil', [
            'examination_id' => $validated['examination_id'],
            'items_count' => count($validated['items'] ?? []),
        ]);

        DB::beginTransaction();
        try {
            $examination = Examination::findOrFail($validated['examination_id']);
            Log::info('Examination ditemukan', ['examination_id' => $examination->id]);

            $prescription = Prescription::create([
                'examination_id' => $examination->id,
                'doctor_id'      => Auth::id(),
                'resep_date'     => $validated['resep_date'] ?? now()->toDateString(),
                'catatan_umum'   => $validated['catatan_umum'] ?? null,
                'status'         => 'saved',
            ]);
            Log::info('Header resep dibuat', ['prescription_id' => $prescription->id]);

            $totalItems = 0;
            foreach ($validated['items'] as $index => $item) {
                $row = PrescriptionItem::create([
                    'prescription_id'  => $prescription->id,
                    'drug_id'          => $item['drug_id'] ?? null,
                    'drug_name'        => $item['drug_name'] ?? null,
                    'kfa_code'         => $item['kfa_code'] ?? null,
                    'qty'              => (int)($item['qty'] ?? 1),
                    'unit'             => $item['unit'] ?? null,
                    'dosis'            => $item['dosis'] ?? null,
                    'aturan_pakai'     => $item['aturan_pakai'] ?? null,
                    'keterangan'       => $item['keterangan'] ?? null,
                    'perintah_perawat' => $item['perintah_perawat'] ?? null,
                ]);
                $totalItems++;
                Log::info('Item resep berhasil dibuat', [
                    'prescription_item_id' => $row->id,
                    'index' => $index,
                ]);
            }

            $prescription->update(['total_items' => $totalItems]);
            Log::info('Total items pada header diperbarui', [
                'prescription_id' => $prescription->id,
                'total_items' => $totalItems,
            ]);

            DB::commit();
            Log::info('Transaksi simpan resep berhasil di-commit', ['prescription_id' => $prescription->id]);

            if ($request->expectsJson()) {
                $response = response()->json([
                    'success' => true,
                    'message' => 'Resep berhasil disimpan',
                    'data'    => $prescription->load('items'),
                ]);
                Log::info('Mengembalikan response JSON sukses untuk simpan resep');
                return $response;
            }

            Log::info('Redirect kembali setelah simpan resep', ['prescription_id' => $prescription->id]);
            return redirect()->back()->with('success', 'Resep berhasil disimpan');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan resep, transaksi di-rollback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->expectsJson()) {
                $response = response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan resep',
                    'error'   => $e->getMessage(),
                ], 422);
                Log::warning('Mengembalikan response JSON gagal untuk simpan resep');
                return $response;
            }

            Log::warning('Redirect back dengan error setelah gagal simpan resep');
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan resep: '.$e->getMessage()])->withInput();
        }
    }
}