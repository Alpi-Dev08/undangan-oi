<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User; 

class PDFUploadController extends Controller
{
    public function uploadPDF(Request $request, $patient_code)
    {
        $request->validate([
            'pdfFile' => 'required|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('pdfFile')) {
            $file = $request->file('pdfFile');
            $fileName = $patient_code . '_' . time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('pdfs', $fileName, 'public');

            $user = User::whereHas('patient', function($query) use ($patient_code) {
                $query->where('patient_code', $patient_code);
            })->first();

            if ($user) {
                $user->patient->pdf_path = $filePath;
                $user->patient->save();

                return response()->json([
                    'success' => true,
                    'filePath' => asset('storage/' . $filePath),
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Patient not found']);
            }
        }

        return response()->json(['success' => false]);
    }

    public function getPatientPDF($patient_code)
    {
        $user = User::whereHas('patient', function($query) use ($patient_code) {
            $query->where('patient_code', $patient_code);
        })->first();

        if ($user) {
            return view('patient.pdf', ['pdfPath' => $user->patient->pdf_path]);
        } else {
            return redirect()->back()->with('error', 'Patient not found');
        }
    }
}

