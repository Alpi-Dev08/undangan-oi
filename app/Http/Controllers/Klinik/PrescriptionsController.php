<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Models\Klinik\{Examination, Prescription, PrescriptionItem};
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Facades\{Auth, DB, Log};
use Barryvdh\DomPDF\Facade\Pdf;

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

            $resepDate = $validated['resep_date'] ?? now()->toDateString();

            // Cek resep existing (idempotent) berdasarkan pemeriksaan + tanggal
            $existing = Prescription::where('examination_id', $examination->id)
                ->whereDate('resep_date', $resepDate)
                ->orderByDesc('id')
                ->first();

            if ($existing) {
                // Jika status final, cegah perubahan
                if (in_array($existing->status, ['dispensed', 'cancelled'])) {
                    DB::rollBack();
                    Log::warning('Resep existing status final, tidak dapat diubah', [
                        'prescription_id' => $existing->id,
                        'status' => $existing->status,
                    ]);

                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Resep pada tanggal ini berstatus final dan tidak dapat diubah.',
                            'status'  => $existing->status,
                        ], 409);
                    }
                    return redirect()->back()->with('error', 'Resep pada tanggal ini berstatus final dan tidak dapat diubah.');
                }

                // Jika belum ada konfirmasi update, minta konfirmasi via front-end (Swal)
                if (!$request->boolean('confirm_update')) {
                    DB::rollBack();
                    Log::info('Konfirmasi update dibutuhkan untuk resep existing', [
                        'prescription_id' => $existing->id,
                    ]);
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Resep untuk tanggal ini sudah ada. Konfirmasi untuk memperbarui? ',
                            'requires_confirmation' => true,
                            'prescription_id' => $existing->id,
                        ], 409);
                    }
                    return redirect()->back()->with('warning', 'Resep sudah ada pada tanggal ini. Konfirmasi untuk memperbarui.');
                }

                // Lakukan UPDATE: perbarui header dan ganti items
                $existing->update([
                    'doctor_id'    => Auth::id(),
                    'resep_date'   => $resepDate,
                    'catatan_umum' => $validated['catatan_umum'] ?? null,
                    'status'       => 'saved',
                ]);
                Log::info('Header resep existing diperbarui', ['prescription_id' => $existing->id]);

                // Ganti semua item
                $deleted = $existing->items()->delete();
                Log::info('Item lama dihapus', ['prescription_id' => $existing->id, 'deleted_count' => $deleted]);

                $prescription = $existing;
                $action = 'updated';
            } else {
                // CREATE baru
                $prescription = Prescription::create([
                    'examination_id' => $examination->id,
                    'doctor_id'      => Auth::id(),
                    'resep_date'     => $resepDate,
                    'catatan_umum'   => $validated['catatan_umum'] ?? null,
                    'status'         => 'saved',
                ]);
                Log::info('Header resep baru dibuat', ['prescription_id' => $prescription->id]);
                $action = 'created';
            }

            // Tulis ulang items
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
                Log::info('Item resep ditulis', [
                    'prescription_item_id' => $row->id,
                    'index' => $index,
                ]);
            }

            $prescription->update(['total_items' => $totalItems]);
            Log::info('Total items pada header diperbarui', [
                'prescription_id' => $prescription->id,
                'total_items' => $totalItems,
                'action' => $action,
            ]);

            DB::commit();
            Log::info('Transaksi simpan/update resep di-commit', [
                'prescription_id' => $prescription->id,
                'action' => $action,
            ]);

            if ($request->expectsJson()) {
                $response = response()->json([
                    'success' => true,
                    'message' => $action === 'updated' ? 'Resep diperbarui' : 'Resep berhasil disimpan',
                    'action'  => $action,
                    'data'    => $prescription->load('items'),
                ]);
                Log::info('Response JSON sukses simpan/update resep');
                return $response;
            }

            Log::info('Redirect back simpan/update resep', ['prescription_id' => $prescription->id, 'action' => $action]);
            return redirect()->back()->with('success', $action === 'updated' ? 'Resep diperbarui' : 'Resep berhasil disimpan');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal simpan/update resep, rollback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->expectsJson()) {
                $response = response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan resep',
                    'error'   => $e->getMessage(),
                ], 422);
                Log::warning('Response JSON gagal simpan/update resep');
                return $response;
            }

            Log::warning('Redirect back error simpan/update resep');
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan resep: '.$e->getMessage()])->withInput();
        }
    }

    /**
     * Mengunduh resep sebagai PDF menggunakan DomPDF.
     *
     * - Memuat relasi pemeriksaan, pasien, dokter, dan item
     * - Transaksi baca + logging (commit/rollback)
     * - Menggunakan view yang sama dengan cetak HTML agar konsisten
     */
    public function pdf(Prescription $prescription)
    {
        Log::info('Akses unduh PDF resep', [
            'actor_id' => Auth::id(),
            'prescription_id' => $prescription->id,
        ]);

        DB::beginTransaction();
        try {
            // Muat relasi yang diperlukan
            $prescription->load(['examination.patient', 'doctor', 'items']);

            DB::commit();
            Log::info('Data resep untuk PDF dimuat', [
                'prescription_id' => $prescription->id,
                'items' => $prescription->items->count(),
            ]);

            // Siapkan PDF dari view print yang sudah compact
            $pdf = Pdf::loadView('pages.klinik.prescriptions.print', compact('prescription'));

            // Set ukuran kertas dan opsi kualitas
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                // Pastikan Dompdf boleh akses URL/asset jika diperlukan dan batasi root ke public
                'isRemoteEnabled' => true,
                'chroot' => public_path(),
            ]);

            $filenameParts = [
                'Resep',
                $prescription->examination?->examination_code,
                ($prescription->examination?->patient?->patient_code ?? 'Pasien'),
                ($prescription->resep_date ?? now()->toDateString()),
            ];
            $filename = implode('_', array_filter($filenameParts)) . '.pdf';

            Log::info('Mengirim file PDF resep untuk diunduh', [
                'filename' => $filename,
            ]);

            return $pdf->download($filename);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menyiapkan PDF resep', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            abort(500, 'Gagal menyiapkan PDF resep');
        }
    }

    /**
     * Cek dan muat resep existing berdasarkan pemeriksaan saja (abaikan tanggal).
     *
     * - Mengembalikan JSON berisi data resep jika ditemukan
     * - Menggunakan transaksi DB (PostgreSQL default) untuk konsistensi baca
     * - Logging setiap langkah dan nilai kembali
     */
    public function check(Request $request): JsonResponse
    {
        Log::info('Cek resep existing dimulai', [
            'actor_id' => Auth::id(),
            'examination_id' => $request->get('examination_id'),
        ]);

        $validated = $request->validate([
            'examination_id' => 'required|integer'
        ]);

        DB::beginTransaction();
        try {
            $existing = Prescription::with(['examination.patient', 'doctor', 'items.drug'])
                ->where('examination_id', $validated['examination_id'])
                ->orderByDesc('id')
                ->first();

            DB::commit();

            if (!$existing) {
                Log::info('Tidak ada resep existing untuk pemeriksaan yang diberikan', [
                    'examination_id' => $validated['examination_id']
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Resep tidak ditemukan untuk pemeriksaan ini.',
                ], 404);
            }

            Log::info('Resep existing ditemukan', [
                'prescription_id' => $existing->id,
                'items_count' => $existing->items->count(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Resep ditemukan',
                'data' => $existing,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memuat resep existing', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat resep existing.',
            ], 500);
        }
    }
}
