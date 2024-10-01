<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KomunikasiEfektifController extends Controller
{
    // Display the form
    public function showForm($examinationId)
    {
        // Pastikan untuk mengganti 'pages.klinik.patients.form' dengan nama file view yang sesuai
        return view('pages.klinik.patients.communication', ['examinationId' => $examinationId]);
    }

    // Handle form submission
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'situation' => 'required|string',
            'background' => 'required|string',
            'assessment' => 'required|string',
            'recommendation' => 'required|string',
            'examination_id' => 'required|integer', //  examination_id 
            'patient_id' => 'required|integer', //try
            'dokter_id'=> 'required|integer' //try
        ]);

        return redirect()->route('komunikasi.efektif.success')
                         ->with('success', 'Data berhasil disimpan!');
    }

    // Optional: Success page or message
    public function success()
    {
        return view('pages.klinik.patients.success'); // Create this view to show a success message
    }
}
