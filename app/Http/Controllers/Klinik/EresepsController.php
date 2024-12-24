<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\DrugsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klinik\Eresep;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;

class EresepsController extends Controller
{
   
    public function index()
    {
        $ereseps = Eresep::with('examination')->orderBy('created_at', 'desc')->get();
        return view('pages.klinik.ereseps.index', compact('ereseps'));
    }


    public function show($id)
    {
        $eresep = Eresep::with('examination')->findOrFail($id);
        return view('pages.klinik.ereseps.show', compact('eresep'));
    }        

    public function createEresepFromExaminations()
    {
        $examinations = Examination::all();

        foreach ($examinations as $examination) {
            $exists = Eresep::where('examination_id', $examination->id)->exists();

            if (!$exists) {
                Eresep::create([
                    'examination_id' => $examination->id,
                    'eresep_number' => 'ERES-' . $examination->id,
                ]);
            }
        }

        return response()->json(['message' => 'E-resep berhasil di-generate dari semua examination yang ada']);
    }
    
}
