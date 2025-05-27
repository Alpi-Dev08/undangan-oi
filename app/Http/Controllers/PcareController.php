<?php

    namespace App\Http\Controllers;

    use AamDsam\Bpjs\PCare;
    use Exception;
    use Illuminate\Http\Request;
    use Log;

    class PcareController extends Controller
    {
        protected $pcare;

        public function __construct()
        {
            //$this->pcare = new Pcare(config('bpjs.pcare'));
        }

        public function getDokter(Request $request)
        {
            if (request()->ajax()) {
                try {
                    $keyword = $request->input('keyword', '');
                    $start   = $request->input('start', 0);
                    $limit   = $request->input('limit', 10);

                    $response = new PCare\Dokter(config('bpjs.pcare'));
                    $response = $response->index($start, $limit);

                    return response()->json($response);
                } catch (Exception $e) {
                    Log::error('PCare Dokter Error: ' . $e->getMessage());
                    return response()->json([
                        'status'  => false,
                        'message' => 'Terjadi kesalahan saat mengambil data dokter: ' . $e->getMessage()
                    ], 500);
                }
            }
            return view('pages.klinik.pcare.dokter');
        }

        // API untuk mendapatkan data dokter

        public function index()
        {
            return view('pages.klinik.pcare.index');
        }

        public function getDiagnosa(Request $request)
        {
            if (request()->ajax()) {
                try {
                    $keyword = $request->keyword;
                    $start   = $request->input('start', 0);
                    $limit   = $request->input('limit', 10);

                    $response = new PCare\Diagnosa(config('bpjs.pcare'));
                    $response = $response->keyword($keyword)->index($start, $limit);

                    // Add pagination metadata if available
                    if (isset($response->response) && isset($response->response->list)) {
                        $response->pagination = [
                            'start'       => $start,
                            'limit'       => $limit,
                            'total'       => isset($response->response->total) ? $response->response->total : count($response->response->list),
                            'currentPage' => floor($start / $limit) + 1,
                            'totalPages'  => isset($response->response->total) ? ceil($response->response->total / $limit) : 1
                        ];
                    }

                    return response()->json($response);
                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            }

            return view('pages.klinik.pcare.diagnosa');
        }

        public function getKesadaran(Request $request)
        {
            if (request()->ajax()) {
                try {
                    $keyword = $request->keyword;
                    $start   = $request->input('start', 0);
                    $limit   = $request->input('limit', 10);

                    $response = new PCare\Kesadaran(config('bpjs.pcare'));
                    $response = $response->index();

                    // Add pagination metadata if available
                    if (isset($response->response) && isset($response->response->list)) {
                        $response->pagination = [
                            'start'       => $start,
                            'limit'       => $limit,
                            'total'       => isset($response->response->total) ? $response->response->total : count($response->response->list),
                            'currentPage' => floor($start / $limit) + 1,
                            'totalPages'  => isset($response->response->total) ? ceil($response->response->total / $limit) : 1
                        ];
                    }

                    return response()->json($response);
                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            }

            return view('pages.klinik.pcare.kesadaran');
        }

        public function getPoli(Request $request)
        {
            if (request()->ajax()) {
                try {
                    $keyword = $request->keyword;
                    $start   = $request->input('start', 0);
                    $limit   = $request->input('limit', 10);

                    $response = new PCare\Poli(config('bpjs.pcare'));
                    $response = $response->fktp()->index($start, $limit);

                    // Add pagination metadata if available
                    if (isset($response->response) && isset($response->response->list)) {
                        $response->pagination = [
                            'start'       => $start,
                            'limit'       => $limit,
                            'total'       => isset($response->response->total) ? $response->response->total : count($response->response->list),
                            'currentPage' => floor($start / $limit) + 1,
                            'totalPages'  => isset($response->response->total) ? ceil($response->response->total / $limit) : 1
                        ];
                    }

                    return response()->json($response);
                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            }

            return view('pages.klinik.pcare.poli');
        }

        public function getProvider(Request $request)
        {
            if (request()->ajax()) {
                try {
                    $start = $request->input('start', 0);
                    $limit = $request->input('limit', 10);

                    $response = new PCare\Provider(config('bpjs.pcare'));
                    $response = $response->index($start, $limit);

                    // Add pagination metadata if available
                    if (isset($response->response) && isset($response->response->list)) {
                        $response->pagination = [
                            'start'       => $start,
                            'limit'       => $limit,
                            'total'       => isset($response->response->total) ? $response->response->total : count($response->response->list),
                            'currentPage' => floor($start / $limit) + 1,
                            'totalPages'  => isset($response->response->total) ? ceil($response->response->total / $limit) : 1
                        ];
                    }

                    return response()->json($response);
                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            }

            return view('pages.klinik.pcare.provider');
        }

        /**
         * API untuk mendapatkan data spesialis
         *
         * @param Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function getSpesialis(Request $request)
        {
            if (request()->ajax()) {
                try {
                    $response = new PCare\Spesialis(config('bpjs.pcare'));
                    $response = $response->index();

                    // Log response
                    Log::info('PCare Spesialis Response', ['response' => $response]);

                    return response()->json($response);
                } catch (Exception $e) {
                    Log::error('PCare Spesialis Error', ['error' => $e->getMessage()]);
                    return response()->json([
                        'status'  => false,
                        'message' => 'Terjadi kesalahan saat mengambil data spesialis: ' . $e->getMessage(),
                        'error'   => $e->getMessage()
                    ], 500);
                }
            }

            return view('pages.klinik.pcare.spesialis');
        }

        /**
         * API untuk mendapatkan data sub spesialis
         *
         * @param Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function getSubSpesialis(Request $request)
        {
            if (request()->ajax()) {
                try {
                    $keyword = $request->keyword;

                    $response = new PCare\Spesialis(config('bpjs.pcare'));
                    $response = $response->getSubSpesialis($keyword)->index();
                    // Log response
                    Log::info('PCare Sub Spesialis Response', ['response' => $response]);

                    return response()->json($response);
                } catch (Exception $e) {
                    Log::error('PCare Sub Spesialis Error', ['error' => $e->getMessage()]);
                    return response()->json([
                        'status'  => false,
                        'message' => 'Terjadi kesalahan saat mengambil data sub spesialis: ' . $e->getMessage(),
                        'error'   => $e->getMessage()
                    ], 500);
                }
            }

            return view('pages.klinik.pcare.subspesialis');
        }

        public function getSarana(Request $request)
        {
            if (request()->ajax()) {
                try {
                    $response = new PCare\Spesialis(config('bpjs.pcare'));
                    $response = $response->sarana()->index();

                    // Log response
                    Log::info('PCare Sarana Response', ['response' => $response]);

                    return response()->json($response);
                } catch (Exception $e) {
                    Log::error('PCare Sarana Error', ['error' => $e->getMessage()]);
                    return response()->json([
                        'status'  => false,
                        'message' => 'Terjadi kesalahan saat mengambil data sarana: ' . $e->getMessage(),
                        'error'   => $e->getMessage()
                    ], 500);
                }
            }

            return view('pages.klinik.pcare.sarana');
        }

        public function getKhusus(Request $request)
        {
            if (request()->ajax()) {
                try {
                    $response = new PCare\Spesialis(config('bpjs.pcare'));
                    $response = $response->khusus()->index();

                    // Log response
                    Log::info('PCare Khusus Response', ['response' => $response]);

                    return response()->json($response);
                } catch (Exception $e) {
                    Log::error('PCare Khusus Error', ['error' => $e->getMessage()]);
                    return response()->json([
                        'status'  => false,
                        'message' => 'Terjadi kesalahan saat mengambil data khusus: ' . $e->getMessage(),
                        'error'   => $e->getMessage()
                    ], 500);
                }
            }

            return view('pages.klinik.pcare.khusus');
        }

        public function rujukanSubspesialis(Request $request)
        {
            if (request()->ajax()) {
                try {
                    $kodeSarana       = $request->kodeSarana;
                    $kodeSubSpesialis = $request->kodeSubSpesialis;
                    $tanggalRujuk     = "25-04-2025";


                    $response = new PCare\Spesialis(config('bpjs.pcare'));
                    $response = $response->rujuk()
                                         ->subSpesialis($kodeSubSpesialis)
                                         ->sarana($kodeSarana)
                                         ->tanggalRujuk($tanggalRujuk)
                                         ->index();

                    //return response()->json($response);
                    $json     = '{
                      "response": {
                        "count": 36,
                        "list": [
                          {
                            "kdppk": "0114R049",
                            "nmppk": "RSUD CEMPAKA PUTIH",
                            "alamatPpk": "JALAN RAWASARI SELATAN NO. 1",
                            "telpPpk": "021-4224243",
                            "kelas": "D",
                            "nmkc": "JAKARTA PUSAT",
                            "distance": 951.0729,
                            "jadwal": "Senin : 07:30 - 14:00, 08:00 - 17:00;14:00 - 19:00",
                            "jmlRujuk": 0,
                            "kapasitas": 0,
                            "persentase": 0
                          },
                          {
                            "kdppk": "0114R052",
                            "nmppk": "RSUD KEMAYORAN",
                            "alamatPpk": "Jl. Serdang Baru I",
                            "telpPpk": "(021) 4251005",
                            "kelas": "D",
                            "nmkc": "JAKARTA PUSAT",
                            "distance": 2505.416,
                            "jadwal": "Senin : 07:30 - 14:00, 08:00 - 17:00;14:00 - 19:00",
                            "jmlRujuk": 0,
                            "kapasitas": 0,
                            "persentase": 0
                          }
                        ]
                      },
                      "metaData": {
                        "message": "OK",
                        "code": 200
                      }
                    }';
                    $response = json_decode($json, true);
                    return response()->json($response);
                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            }
            return view('pages.klinik.pcare.rujukansubspesialis');
        }


        public function getPeserta(Request $request, $nomorPencarian)
        {
            $jenisId = $request->query('jenisId', 'noPeserta');

            try {
                $response = new PCare\Peserta(config('bpjs.pcare'));
                if ($jenisId === 'nik') {
                    $response = $response->jenisKartu($jenisId);
                }
                $response = $response->keyword($nomorPencarian)->show();

                return response()->json($response);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        public function getRiwayatPendaftaran(Request $request, $tanggalPendaftaran = null)
        {

            $start = $request->query('start', 0);
            $limit = $request->query('limit', 10);

            $tglDaftar = date('Y-m-d');
            if ($tanggalPendaftaran) {
                $tglDaftar = $tanggalPendaftaran;
            }
            $bpjs = new PCare\Pendaftaran(config('bpjs.pcare'));
            return $bpjs->tanggalDaftar('27-05-2025')->index($start, $limit);
        }

        public function submitPendaftaran(Request $request)
        {
            try {
                // Validate the request
                $validated = $request->validate([
                    'kdProviderPeserta' => 'required|string',
                    'tglDaftar'         => 'required|string',
                    'noKartu'           => 'required|string',
                    'kdPoli'            => 'required|string',
                    'keluhan'           => 'nullable|string',
                    'kunjSakit'         => 'required|boolean',
                    'sistole'           => 'nullable|integer',
                    'diastole'          => 'nullable|integer',
                    'beratBadan'        => 'nullable|numeric',
                    'tinggiBadan'       => 'nullable|numeric',
                    'respRate'          => 'nullable|integer',
                    'lingkarPerut'      => 'nullable|numeric',
                    'heartRate'         => 'nullable|integer',
                    'rujukBalik'        => 'nullable|integer',
                    'kdTkp'             => 'required|string',
                ]);
  // Format date from DD-MM-YYYY to YYYY-MM-DD for database
                $tglDaftar = date('d-m-Y', strtotime($request->tglDaftar));

                // Prepare data for PCare API
                $data = [
                    'kdProviderPeserta' => '0114A026',
                    'tglDaftar'         => '27-05-2025',
                    'noKartu'           => '0001113569638',
                    'kdPoli'            => '001',
                    'keluhan'           => null,
                    'kunjSakit'         => true,
                    'sistole'           => (int) $request->sistole,
                    'diastole'          => (int) $request->diastole,
                    'beratBadan'        => (float) $request->beratBadan,
                    'tinggiBadan'       => (float) $request->tinggiBadan,
                    'respRate'          => (int) $request->respRate,
                    'lingkarPerut'      => (float) $request->lingkarPerut,
                    'heartRate'         => (int) $request->heartRate,
                    'rujukBalik'        => (int) $request->rujukBalik,
                    'kdTkp'             => 10,
                ];

                // Call PCare API to register patient
                $response = new PCare\Pendaftaran(config('bpjs.pcare'));
                $result   = $response->store($data);

                // Log the response
                Log::info('PCare Pendaftaran Response', ['response' => $result]);

                return response()->json([
                    'status'  => true,
                    'message' => 'Pendaftaran berhasil',
                    'data'    => $result
                ]);
            } catch (Exception $e) {
                Log::error('PCare Pendaftaran Error', ['error' => $e->getMessage()]);
                return response()->json([
                    'status'  => false,
                    'message' => 'Terjadi kesalahan saat melakukan pendaftaran: ' . $e->getMessage(),
                    'error'   => $e->getMessage()
                ], 500);
            }
        }
    }
