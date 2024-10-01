<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sbar; 
use App\Models\Examination;
use App\Models\User; // Model untuk user, termasuk perawat dan dokter

class SbarController extends Controller
{
    // Fungsi untuk menampilkan daftar SBAR yang sudah ada
    public function index()
    {
        $sbarList = Sbar::all();
        return view('pages.klinik.sbar.index', compact('sbarList'));
    }

    // Fungsi untuk menyimpan data SBAR baru oleh perawat
    public function store(Request $request)
    {
        // Validasi input yang diberikan perawat
        $validatedData = $request->validate([
            'situation' => 'required|string',
            'background' => 'required|string',
            'assessment' => 'required|string',
            'recommendation' => 'required|string',
            'examination_id' => 'required|integer|exists:examinations,id', // Pastikan pemeriksaan valid
        ]);

        // Simpan data SBAR baru yang diisi oleh perawat
        Sbar::create([
            'situation' => $request->situation,
            'background' => $request->background,
            'assessment' => $request->assessment,
            'recommendation' => $request->recommendation,
            'examination_id' => $request->examination_id,
            'patient_id' => auth()->user()->id, // Perawat yang mengisi SBAR
            'checklist_verification' => false, // Default tidak terverifikasi
        ]);

        return redirect()->route('komunikasi.efektif.success')
                         ->with('success', 'Data SBAR berhasil ditambahkan!');
    }

    // Fungsi untuk menampilkan SBAR yang diisi ke halaman dokter
    public function showForDoctor($examinationId)
    {
        // Ambil SBAR terkait berdasarkan pemeriksaan (examination_id)
        $sbar = Sbar::where('examination_id', $examinationId)->first();

        if (!$sbar) {
            return redirect()->back()->with('error', 'SBAR belum tersedia untuk pemeriksaan ini.');
        }

        return view('pages.klinik.examinations._editform', compact('sbar'));
    }

    // Fungsi untuk mengedit data SBAR
    public function edit($id)
    {
        $sbar = Sbar::findOrFail($id);
        return view('pages.klinik.sbar.edit', compact('sbar'));
    }

    // Fungsi untuk memperbarui data SBAR
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'situation' => 'required|string',
            'background' => 'required|string',
            'assessment' => 'required|string',
            'recommendation' => 'required|string',
        ]);

        $sbar = Sbar::findOrFail($id);
        $sbar->update($validatedData);

        return redirect()->route('sbar.index')->with('success', 'Data SBAR berhasil diperbarui!');
    }

    // Fungsi untuk menghapus data SBAR
    public function destroy($id)
    {
        $sbar = Sbar::findOrFail($id);
        $sbar->delete();

        return redirect()->route('sbar.index')->with('success', 'Data SBAR berhasil dihapus!');
    }

    // Fungsi untuk verifikasi SBAR oleh dokter
    public function verify($id)
    {
        $sbar = Sbar::find($id);
        $sbar->checklist_verification = true; // Set verifikasi ke true
        $sbar->save();

        return redirect()->back()->with('success', 'SBAR berhasil diverifikasi');
    }
}