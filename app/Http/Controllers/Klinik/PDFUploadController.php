<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Models\Klinik\Patient;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;

/**
 * Class PDFUploadController
 *
 * Mengelola upload dan tampilan file PDF untuk pasien
 *
 * @package App\Http\Controllers\Klinik
 */
class PDFUploadController extends Controller
{
    /**
     * Constructor
     *
     * Menerapkan middleware otentikasi dan otorisasi
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:patients.view')->only(['getPatientPDF']);
        $this->middleware('permission:patients.edit')->only(['uploadPDF']);
    }

    /**
     * Upload file PDF untuk pasien
     *
     * @param Request $request
     * @param string $patient_code
     * @return JsonResponse
     */
    public function uploadPDF(Request $request, string $patient_code): JsonResponse
    {
        Log::info('Memulai upload PDF untuk pasien', [
            'patient_code' => $patient_code,
            'user_id' => Auth::id()
        ]);

        try {
            // Validasi input
            $request->validate([
                'pdfFile' => 'required|file|mimes:pdf|max:10240', // Max 10MB
            ], [
                'pdfFile.required' => 'File PDF wajib diunggah',
                'pdfFile.mimes' => 'File harus berformat PDF',
                'pdfFile.max' => 'Ukuran file maksimal 10MB'
            ]);

            if (!$request->hasFile('pdfFile')) {
                Log::warning('File PDF tidak ditemukan dalam request', [
                    'patient_code' => $patient_code
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'File PDF tidak ditemukan'
                ], Response::HTTP_BAD_REQUEST);
            }

            DB::beginTransaction();

            // Cari pasien berdasarkan patient_code
            $patient = Patient::whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })->where('patient_code', $patient_code)->first();

            if (!$patient) {
                Log::warning('Pasien tidak ditemukan', [
                    'patient_code' => $patient_code
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Pasien tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }

            // Hapus file PDF lama jika ada
            if ($patient->pdf_path && Storage::disk('public')->exists($patient->pdf_path)) {
                Storage::disk('public')->delete($patient->pdf_path);
                Log::info('File PDF lama berhasil dihapus', [
                    'old_file' => $patient->pdf_path
                ]);
            }

            // Upload file baru
            $file = $request->file('pdfFile');
            $fileName = $this->generateFileName($patient_code, $file->getClientOriginalName());
            $filePath = $file->storeAs('pdfs/patients', $fileName, 'public');

            if (!$filePath) {
                Log::error('Gagal menyimpan file PDF', [
                    'patient_code' => $patient_code,
                    'file_name' => $fileName
                ]);

                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan file PDF'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Update path PDF di database
            $patient->update(['pdf_path' => $filePath]);

            DB::commit();

            Log::info('File PDF berhasil diunggah', [
                'patient_code' => $patient_code,
                'file_path' => $filePath,
                'file_size' => $file->getSize()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File PDF berhasil diunggah',
                'data' => [
                    'file_path' => asset('storage/' . $filePath),
                    'file_name' => $fileName,
                    'file_size' => $this->formatFileSize($file->getSize())
                ]
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error saat upload PDF', [
                'patient_code' => $patient_code,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengunggah file PDF'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Tampilkan PDF pasien
     *
     * @param string $patient_code
     * @return View|RedirectResponse
     */
    public function getPatientPDF(string $patient_code): View|RedirectResponse
    {
        Log::info('Mengakses PDF pasien', [
            'patient_code' => $patient_code,
            'user_id' => Auth::id()
        ]);

        try {
            // Cari pasien berdasarkan patient_code
            $patient = Patient::with('user')
                ->whereHas('user', function ($query) {
                    $query->whereNull('deleted_at');
                })
                ->where('patient_code', $patient_code)
                ->first();

            if (!$patient) {
                Log::warning('Pasien tidak ditemukan saat mengakses PDF', [
                    'patient_code' => $patient_code
                ]);

                return redirect()->back()->with('error', 'Pasien tidak ditemukan');
            }

            if (!$patient->pdf_path || !Storage::disk('public')->exists($patient->pdf_path)) {
                Log::warning('File PDF tidak ditemukan', [
                    'patient_code' => $patient_code,
                    'pdf_path' => $patient->pdf_path
                ]);

                return redirect()->back()->with('error', 'File PDF tidak ditemukan');
            }

            Log::info('PDF pasien berhasil diakses', [
                'patient_code' => $patient_code,
                'pdf_path' => $patient->pdf_path
            ]);

            return view('pages.klinik.patients.pdf', [
                'patient' => $patient,
                'pdfPath' => asset('storage/' . $patient->pdf_path)
            ]);

        } catch (Exception $e) {
            Log::error('Error saat mengakses PDF pasien', [
                'patient_code' => $patient_code,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengakses file PDF');
        }
    }

    /**
     * Generate nama file yang unik
     *
     * @param string $patientCode
     * @param string $originalName
     * @return string
     */
    private function generateFileName(string $patientCode, string $originalName): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $timestamp = now()->format('Y-m-d_H-i-s');

        return "{$patientCode}_{$timestamp}_{$baseName}.{$extension}";
    }

    /**
     * Format ukuran file menjadi human readable
     *
     * @param int $bytes
     * @return string
     */
    private function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}

