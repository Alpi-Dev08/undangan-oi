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
