<?php

    namespace App\Http\Controllers;

    use App\Models\Klinik\Examination;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\File;
    use Barryvdh\DomPDF\Facade as PDF;

    class PagesController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         */
        public function index(Request $request)
        {
            // Get view file location from menu config
            $view = theme()->getOption('page', 'view');
            // Check if the page view file exist
            if (view()->exists('pages.' . $view)) {
                if ($request->id) {
                    $user = User::where('id', $request->id)->first();
                } else {
                    $user = Auth::user();
                }
                return view('pages.' . $view, compact('user'));
            }

            // Get the default inner page
            return redirect('/');
        }

        /**
         * Temporary function to replace icon duotone
         */
        public function replaceIcons()
        {
            $fileContent = file_get_contents(public_path('icon_replacement.txt'));
            $lines       = explode("\n", $fileContent);

            $patterns     = [];
            $replacements = [];
            foreach ($lines as $line) {
                $el = explode(' - ', $line);
                if (empty($line)) {
                    continue;
                }
                $patterns[]     = trim($el[0]);
                $replacements[] = trim($el[1]);
            }

            $files    = File::allFiles(resource_path());
            $filtered = array_filter($files, function ($str) {
                return strpos($str, ".php") !== false;
            });

            foreach ($filtered as $file) {
                $bladeFileContent = file_get_contents($file->getPathname());

                $bladeFileContent = str_replace($patterns, $replacements, $bladeFileContent);

                file_put_contents($file->getPathname(), $bladeFileContent);
            }
        }

        public function bukti_penyampaian_informasi($id)
        {
            $examination = Examination::find($id);
            $user        = User::find($examination->user_id);
            $info        = $user->info;

            //echo json_encode($data);exit;
            return view('pages.klinik.examinations.hakkewajiban_', compact([
                'user',
                'info',
                'examination',
            ]));
        }

        public function get_bukti_penyampaian_informasi($id)
        {
            $examination = Examination::find($id);

            if ($examination->bukti_penyampaian_informasi) {
                return response()->json([
                    'status' => 'success'
                ]);
            }
            return response()->json([
                'status' => 'failed'
            ]);
        }

        public function store_bukti_penyampaian_informasi(Request $request)
        {
            $examination = Examination::find($request->id);

            $base64_string = $request->signature;
            $file          = 'storage/signature/bukti_penyampaian_' . $examination->examination_code . '.png';
            $output_file   = public_path($file);
            $this->base64_to_jpeg($base64_string, $output_file);

            $examination->bukti_penyampaian_informasi = $file;
            $examination->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Bukti Penyampaian Informasi Berhasil Disimpan',
            ]);
        }

        function base64_to_jpeg($base64_string, $output_file)
        {
            // open the output file for writing
            $ifp  = fopen($output_file, 'wb');
            $data = explode(',', $base64_string);
            // we could add validation here with ensuring count( $data ) > 1
            fwrite($ifp, base64_decode($data[1]));
            // clean up the file resource
            fclose($ifp);
            return $output_file;
        }

        public function generatePDF($id)
        {
            $examination = Examination::find($id);
            if (!$examination) {
                return response()->json(['message' => 'Examination not found'], 404);
            }

            $user = User::find($examination->user_id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $info = $user->info;
            $signature = $examination->signature; // Assuming you have a field for the signature

            $pdf = PDF::loadView('pages.klinik.examinations.hakkewajiban_', compact('user', 'info', 'examination', 'signature'));

            return $pdf->download('Bukti_Penyampaian_Informasi_' . $user->name . '.pdf');
        }

        public function store(Request $request)
        {
            $signature = $request->input('signature'); 
            \Log::info('Signature received: ' . $signature);  

            return view('pages.klinik.examinations.persetujuan', ['signature' => $signature]);
        }



    }
