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
                $kyc_iframe = true;

                return view('pages.' . $view, compact('user','kyc_iframe'));
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

            $examination->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Bukti Penyampaian Informasi Berhasil Disimpan',
            ]);
        }




    }
