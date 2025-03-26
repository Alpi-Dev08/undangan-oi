<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AamDsam\Bpjs\PCare;

class PcareController extends Controller
{
    protected $pcare;

    public function __construct()
    {
        //$this->pcare = new Pcare(config('bpjs.pcare'));
    }

    public function index()
    {
        return view('pages.klinik.pcare.index');
    }

    public function getDokter()
    {
        try {
            $response = new PCare\Dokter(config('bpjs.pcare'));
            $response = $response->index(0, 10);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPeserta($noKartu)
    {
        try {
            $response = new PCare\Peserta(config('bpjs.pcare'));
            $response = $response->keyword($noKartu)->show();
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Tambahkan metode lain sesuai kebutuhan
}
