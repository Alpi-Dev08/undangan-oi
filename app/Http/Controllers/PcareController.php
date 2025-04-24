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

    // API untuk mendapatkan data dokter
    public function getDokter(Request $request)
    {
        if(request()->ajax()) {
            try {
                $keyword = $request->input('keyword', '');
                $start   = $request->input('start', 0);
                $limit   = $request->input('limit', 10);

                $response = new PCare\Dokter(config('bpjs.pcare'));
                $response = $response->index($start, $limit);

                return response()->json($response);
            } catch (\Exception $e) {
                Log::error('PCare Dokter Error: ' . $e->getMessage());
                return response()->json([
                    'status'  => false,
                    'message' => 'Terjadi kesalahan saat mengambil data dokter: ' . $e->getMessage()
                ], 500);
            }
        }
        return view('pages.klinik.pcare.dokter');
    }

    public function getDiagnosa(Request $request)
    {
        if(request()->ajax()) {
            try {
                $keyword = $request->keyword;
                $start = $request->input('start', 0);
                $limit = $request->input('limit', 10);

                $response = new PCare\Diagnosa(config('bpjs.pcare'));
                $response = $response->keyword($keyword)->index($start, $limit);

                // Add pagination metadata if available
                if (isset($response->response) && isset($response->response->list)) {
                    $response->pagination = [
                        'start' => $start,
                        'limit' => $limit,
                        'total' => isset($response->response->total) ? $response->response->total : count($response->response->list),
                        'currentPage' => floor($start / $limit) + 1,
                        'totalPages' => isset($response->response->total) ? ceil($response->response->total / $limit) : 1
                    ];
                }

                return response()->json($response);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return view('pages.klinik.pcare.diagnosa');
    }

    public function getKesadaran(Request $request)
    {
        if(request()->ajax()) {
            try {
                $keyword = $request->keyword;
                $start = $request->input('start', 0);
                $limit = $request->input('limit', 10);

                $response = new PCare\Kesadaran(config('bpjs.pcare'));
                $response = $response->index();

                // Add pagination metadata if available
                if (isset($response->response) && isset($response->response->list)) {
                    $response->pagination = [
                        'start' => $start,
                        'limit' => $limit,
                        'total' => isset($response->response->total) ? $response->response->total : count($response->response->list),
                        'currentPage' => floor($start / $limit) + 1,
                        'totalPages' => isset($response->response->total) ? ceil($response->response->total / $limit) : 1
                    ];
                }

                return response()->json($response);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return view('pages.klinik.pcare.kesadaran');
    }

    public function getPoli(Request $request)
    {
        if(request()->ajax()) {
            try {
                $keyword = $request->keyword;
                $start = $request->input('start', 0);
                $limit = $request->input('limit', 10);

                $response = new PCare\Poli(config('bpjs.pcare'));
                $response = $response->fktp()->index($start, $limit);

                // Add pagination metadata if available
                if (isset($response->response) && isset($response->response->list)) {
                    $response->pagination = [
                        'start' => $start,
                        'limit' => $limit,
                        'total' => isset($response->response->total) ? $response->response->total : count($response->response->list),
                        'currentPage' => floor($start / $limit) + 1,
                        'totalPages' => isset($response->response->total) ? ceil($response->response->total / $limit) : 1
                    ];
                }

                return response()->json($response);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return view('pages.klinik.pcare.poli');
    }

    public function getProvider(Request $request)
    {
        if(request()->ajax()) {
            try {
               $start = $request->input('start', 0);
                $limit = $request->input('limit', 10);

                $response = new PCare\Provider(config('bpjs.pcare'));
                $response = $response->index($start, $limit);

                // Add pagination metadata if available
                if (isset($response->response) && isset($response->response->list)) {
                    $response->pagination = [
                        'start' => $start,
                        'limit' => $limit,
                        'total' => isset($response->response->total) ? $response->response->total : count($response->response->list),
                        'currentPage' => floor($start / $limit) + 1,
                        'totalPages' => isset($response->response->total) ? ceil($response->response->total / $limit) : 1
                    ];
                }

                return response()->json($response);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return view('pages.klinik.pcare.provider');
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
