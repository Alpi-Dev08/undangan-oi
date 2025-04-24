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

    public function getPeserta(Request $request, $nomorPencarian)
    {
        $jenisId = $request->query('jenisId', 'noPeserta');

        try {
            $response = new PCare\Peserta(config('bpjs.pcare'));
            if($jenisId==='nik'){
                $response = $response->jenisKartu($jenisId);
            }
            $response = $response->keyword($nomorPencarian)->show();

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getRiwayatPendaftaran(Request $request,$tanggalPendaftaran = null){

        $start = $request->query('start', 0);
        $limit = $request->query('limit', 10);

        $tglDaftar = date('Y-m-d');
        if($tanggalPendaftaran) {
            $tglDaftar = $tanggalPendaftaran;
        }
        $bpjs = new PCare\Pendaftaran(config('bpjs.pcare'));
        return $bpjs->tanggalDaftar($tglDaftar)->index($start, $limit);
    }

    // Tambahkan metode lain sesuai kebutuhan
}
