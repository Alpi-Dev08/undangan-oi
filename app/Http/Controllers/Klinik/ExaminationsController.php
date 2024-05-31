<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\ExaminationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreExaminationRequest;
use App\Http\Requests\Klinik\UpdateExaminationRequest;
use App\Models\Klinik\AdditionalCategory;
use App\Models\Klinik\AdditionalExamination;
use App\Models\Klinik\AnamnesisCategory;
use App\Models\Klinik\AnamnesisExamination;
use App\Models\Klinik\Drug;
use App\Models\Klinik\Examination;
use App\Models\Klinik\HealthProfesional;
use App\Models\Klinik\Icdten;
use App\Models\Klinik\LaboratoryExamination;
use App\Models\Klinik\OtherExamination;
use App\Models\Klinik\Package;
use App\Models\Klinik\PemeriksaanAwal;
use App\Models\Klinik\PhysicalCategory;
use App\Models\Klinik\PhysicalExamination;
use App\Models\Klinik\Plan;
use App\Models\Klinik\Service;
use App\Models\Klinik\ServiceCategory;
use App\Models\Klinik\Transaction;
use App\Models\Klinik\TransactionDetail;
use App\Models\Klinik\VitalityExamination;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use QrCode;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class ExaminationsController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();

            return $next($request);
        });
    }

    public function index_()
    {
        $json = '{"resourceType":"Encounter","identifier":[{"system":"http:\/\/sys-ids.kemkes.go.id\/encounter\/10085107","use":"official","value":"E20240529623"}],"status":"arrived","class":{"system":"http:\/\/terminology.hl7.org\/CodeSystem\/v3-ActCode","code":"AMB","display":"ambulatory"},"subject":{"reference":"Patient\/P00491717250","display":"Auni Reza Sukma Permata "},"participant":[{"type":[{"coding":[{"system":"http:\/\/terminology.hl7.org\/CodeSystem\/v3-ParticipationType","code":"ATND","display":"attender"}]}],"individual":{"reference":"Practitioner\/1000652469","display":"Yunianti Lafau"}}],"period":{"start":"2024-05-29T15:43:24+00:00"},"location":[{"location":{"reference":"Location\/a2aa15d0-c67d-4ae7-bb40-457a8af06d0c","display":"Poli Umim"}}],"statusHistory":[{"status":"arrived","period":{"start":"2024-05-29T15:43:24+00:00","end":"2024-05-29T15:43:24+00:00"}}],"serviceProvider":{"reference":"Organization\/b5ba02bc-97f6-4f42-872c-02808dfb787c"}}';

        $data = json_decode($json, true);
        $data['status']='in-progress';

        $data['statusHistory'][] = [
            "status" => "in-progress",
            "period" => [
                "start" => "2024-05-29T20:43:24+00:00"
            ]
        ];

        foreach ($data['statusHistory'] as $key => $value) {
            if ($value['status'] == 'arrived') {
                $data['statusHistory'][$key]['period']['end'] = "2024-05-29T20:43:24+00:00";
            }
        }



        print_r($data['statusHistory']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExaminationsDataTable $dataTable)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.klinik.examinations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || ! $this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        return view('pages.klinik.examinations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExaminationRequest $request)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if ($validated) {
            try {
                Examination::create(['name' => $request->name]);
            } catch (Exception $e) {
                report($e);

                return false;
            }

            session()->flash('success', 'Examination has been created !!');

            return redirect()->route('examinations.index');
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Examination $examination)
    {
            //
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        $examination = Examination::find($id);
        if ($examination->status !== 'done') {
            $examination->status = 'processing';
            $examination->save();
        }

        $user = User::find($examination->user_id);
        $healthprofesionals = HealthProfesional::all();
        $plans = Plan::all();
        $drugs = Drug::all();
        $icdtens = Icdten::all();
        $anamnesiscategories = [];
        $physicalscategories = [];
        $otherscategories = [];
        $additionalsscategories = [];
        $laboratoryexamination= null;
        if ($examination->service_category->is_mcu == 1) {
            $anamnesiscategories = AnamnesisCategory::all();
            $physicalscategories = PhysicalCategory::where('id', '<>', 15)->get();
            $otherscategories =  PhysicalCategory::where('id', 15)->get();
            $additionalsscategories = AdditionalCategory::all();
        }

        if($examination->is_lab){
            $laboratoryexamination = LaboratoryExamination::where('examination_id', $examination->id)->first();
        }

        $examinations = Examination::where('user_id', $examination->user_id)->where('status', 'done')->orderBy('created_at', 'DESC')->get();
        $anamnesisexamination = AnamnesisExamination::where('examination_id', $examination->id)->first();
        $physicalexamination = PhysicalExamination::where('examination_id', $examination->id)->first();
        $otherexamination = OtherExamination::where('examination_id', $examination->id)->first();
        $additionalexamination = AdditionalExamination::where('examination_id', $examination->id)->first();
        //$vitalityexaminations = VitalityExamination::where('user_id', $examination->user_id)->orderBy('created_at', 'desc')->get();

        $info = $user->info;
        $pemeriksaan_awal = PemeriksaanAwal::where('examination_id',$examination->id)->orWhere('user_id', $examination->user_id)->first();

        $qr = QrCode::size(150)->style('square')->generate('https://klinik.dharma.or.id/bukti-penyampaian-infomasi/'.$examination->id);

        return view('pages.klinik.examinations.edit', compact('examination', 'user', 'healthprofesionals', 'info', 'plans', 'icdtens', 'anamnesiscategories', 'anamnesisexamination', 'examinations', 'physicalscategories', 'physicalexamination', 'otherscategories', 'otherexamination', 'additionalsscategories', 'additionalexamination','laboratoryexamination','pemeriksaan_awal','drugs','qr'));
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExaminationRequest $request, Examination $examination)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
        }

        // Validation Data
        $validated = $request->validated();

        $encounter = json_decode($examination->encounter,true);

        if($examination->encounter_id){
            $assessment = explode(' |',$validated['assessment']);
            $assessment_ = [];
            $n = 1;
            foreach ($assessment as $row) {
                $row_ = explode(' - ',$row);
                if(isset($row_[1])) {

                    $reqCondition = [
                        "resourceType"   => "Condition",
                        "clinicalStatus" => [
                            "coding" => [
                                [
                                    "system"  =>
                                        "http://terminology.hl7.org/CodeSystem/condition-clinical",
                                    "code"    => "active",
                                    "display" => "Active",
                                ],
                            ],
                        ],
                        "category"       => [
                            [
                                "coding" => [
                                    [
                                        "system"  =>
                                            "http://terminology.hl7.org/CodeSystem/condition-category",
                                        "code"    => "encounter-diagnosis",
                                        "display" => "Encounter Diagnosis",
                                    ],
                                ],
                            ],
                        ],
                        "code"           => [
                            "coding" => [
                                [
                                    "system"  => "http://hl7.org/fhir/sid/icd-10",
                                    "code"    => $row_[0],
                                    "display" => $row_[1],
                                ],
                            ],
                        ],
                        "subject"        => [
                            "reference" => "Patient/".$examination->patient->his_number,
                            "display"   => $examination->patient->user->name,
                        ],
                        "encounter"      => [
                            "reference" => "Encounter/".$examination->encounter_id,
                        ],
                        "onsetDateTime"  => date('Y-m-d\TH:i:sP'),
                        "recordedDate"   => date('Y-m-d\TH:i:sP')
                    ];

                    $condition = satu_sehat('create','Condition',$reqCondition);

                    if(isset($condition->id)) {
                        $encounter["diagnosis"][] = [
                            "condition" => [
                                "reference" => "Condition/" . $condition->id,
                                "display"   => $row_[1],
                            ],
                            "use"       => [
                                "coding" => [
                                    [
                                        "system"  => "http://terminology.hl7.org/CodeSystem/diagnosis-role",
                                        "code"    => "DD",
                                        "display" => "Discharge diagnosis",
                                    ],
                                ],
                            ],
                            "rank"      => $n,
                        ];

                        $n++;
                    }

                }
            }

            $encounter['status']='finished';

            $encounter['statusHistory'][] = [
                "status" => "finished",
                "period" => [
                    "start" => date('Y-m-d\TH:i:sP'),
                    "end" => date('Y-m-d\TH:i:sP')
                ]
            ];

            foreach ($encounter['statusHistory'] as $key => $value) {
                if ($value['status'] == 'in-progress') {
                    $encounter['statusHistory'][$key]['period']['end'] = date('Y-m-d\TH:i:sP');
                }
            }

            satu_sehat('update','Encounter',$encounter,$examination->encounter_id);
        }

        // Process Data
        if ($validated) {
            // Process Data
            try {
                $validated['status'] = 'done';
                $validated['encounter'] = json_encode($encounter);
                $validated['resep'] = json_encode($request->resep);
                $examination->update($validated);
            } catch (Exception $e) {
                report($e);

                return false;
            }

            session()->flash('success', 'Examination has been updated !!');

            if ($examination->status == 'waiting payment') {
                return redirect()->route('transactions.create', ['id' => $examination->id]);
            }

            return redirect()->route('examinations.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Examination $examination)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
        }

        $examination->delete();

        session()->flash('success', 'Examination has been deleted !!');

        return redirect()->route('examinations.index');
    }

    public function invoice(Request $request)
    {
        $id = $request->id;
        $examination = Examination::find($id);
        $user = User::find($examination->user_id);
        $info = $user->info;
        $transaction = Transaction::where('examination_id', $examination->id)->first();
        $transaction_detail = TransactionDetail::where('transaction_id', $transaction->id)->get();

        // get the default inner page
        return view('pages.klinik.examinations.invoice', compact(['user', 'info', 'examination', 'transaction', 'transaction_detail',
        ]));
    }

    public function payments(Request $request)
    {
        $id = $request->id;
        $user = $id != '' ? User::find($id) : auth()->user();
        $examination = LaboratoryExamination::find($request->examination);
        $info = $user->info;

        // get the default inner page
        return view('pages.klinik.examinations.payments', compact(['user', 'info', 'examination',
        ]));
    }

    public function createPayment(Request $request)
    {
        $id = $request->id;
        $transaction = Transaction::find($id);
        $transaction->status = 'paid';
        $transaction->save();

        $examination = Examination::find($transaction->examination_id);
        $examination->status = 'done';
        $examination->save();

        return redirect()->route('transactions.index');
    }

    public function services(Request $request)
    {
        $id = $request->id;
        $examination = Examination::find($id);
        $examinations = Examination::where('user_id', $examination->user_id)->where('status', 'done')->orderBy('created_at', 'DESC')->get();
        $user = User::find($examination->user_id);
        $info = $user->info;

        $pemeriksaan_awal = PemeriksaanAwal::where('user_id', $examination->user_id)->first();

        $services = Service::where('service_category_id', $examination->service_category_id)->get();
        $servicecategories = ServiceCategory::where('is_global', 1)->get();

        return view('pages.klinik.examinations.services', compact(['user', 'info', 'examination', 'services', 'servicecategories', 'examinations','pemeriksaan_awal'
        ]));
    }

    public function storeservices(Request $request)
    {
        $examination = Examination::find($request->examination_id);
        $transaction = Transaction::where('examination_id', $examination->id)->first();

        if ($examination->is_appointment == 1) {
            $examination->examination_date = date('Y-m-d H:i:s');
            $examination->appointment_status = 1;
            $examination->save();
        }

        $total = 0;

        if ($examination->package_id != null) {
            $package = Package::find($examination->package_id);
            TransactionDetail::create(['transaction_id' => $transaction->id, 'status' => 'waiting payment', 'service_id' => $package->id, 'name' => $package->name, 'price' => $package->price, 'total' => $package->price,
            ]);

            $total = $package->price;
        } else {
            TransactionDetail::where('transaction_id', $transaction->id)->delete();
            foreach ($request->service_id as $service_id) {
                $service = Service::find($service_id);

                TransactionDetail::create(['transaction_id' => $transaction->id, 'status' => 'waiting payment', 'service_id' => $service->id, 'name' => $service->name, 'price' => $service->price, 'total' => $service->price,
                ]);

                $total = $total + $service->price;
            }
        }

        $transaction->amount = $total;
        $transaction->save();

        if ($request->payment == 1) {
            return redirect()->route('transactions.edit', ['transaction' => $transaction->id]);
        } else {
            // get the default inner page
            if (Auth()->user()->hasRole('admin')) {
                return redirect()->route('patients.index');
            }

            return redirect()->route('examinations.vitality', ['id' => $examination->id]);
        }
    }

    public function vitality(Request $request)
    {
        $id = $request->id;
        $examination = Examination::find($id);
        $vitalityexamination = VitalityExamination::where('examination_id', $examination->id)->first();

        if($examination->encounter_id) {
            $encounter           = json_decode($examination->encounter, true);
            $encounter['status'] = 'in-progress';

            $encounter['statusHistory'][] = [
                "status" => "in-progress",
                "period" => [
                    "start" => "2024-05-29T20:43:24+00:00"
                ]
            ];

            foreach ($encounter['statusHistory'] as $key => $value) {
                if ($value['status'] == 'arrived') {
                    $encounter['statusHistory'][$key]['period']['end'] = date('Y-m-d\TH:i:sP');
                }
            }

            satu_sehat('update', 'Encounter', $encounter, $examination->encounter_id);

            $examination->encounter = json_encode($encounter);
            $examination->save();
        }

        $user = User::find($examination->user_id);
        $info = $user->info;
        $pemeriksaan_awal = PemeriksaanAwal::where('user_id', $examination->user_id)->first();

        // get the default inner page
        return view('pages.klinik.examinations.vitality', compact(['user', 'info', 'examination', 'vitalityexamination','pemeriksaan_awal']));
    }

    public function pdf(Request $request)
    {
        $examination = Examination::find($request->id);
        $user = User::find($examination->user_id);
        $info = $user->info;

        $data = $request->all();

        // get the default inner page
        /*return view('pages.klinik.examinations.pdf', compact([
            'user', 'info', 'examination'
        ]));*/

        $pdf = Pdf::loadView('pages.klinik.examinations.pdf', compact(['user', 'info', 'examination',
        ]));
        Storage::put('public/examinations/'.$examination->examination_code.'/1.medical-record.pdf', $pdf->output());
        //return $pdf->download('rekam-medis_'.$user->name.'.pdf');

        $pdfMerge = PDFMerger::init();
        $files = Storage::disk('public')->files('examinations/'.$examination->examination_code);

        foreach ($files as $key => $value) {
            if (file_exists(storage_path('app/public/'.$value))) {
                $pdfMerge->addPDF(storage_path('app/public/'.$value), 'all');
            }
        }

        $fileName = $examination->examination_code.'.pdf';
        $pdfMerge->merge();
        $pdfMerge->save(public_path($fileName));

        return response()->download(public_path($fileName));
    }

    public function sehat(Request $request)
    {
        $examination = Examination::find($request->id);
        $user = User::find($examination->user_id);
        $info = $user->info;

        // get the default inner page
        $data = json_decode(json_encode($request->all()));
        /*echo json_encode($data);exit;
        return view('pages.klinik.examinations.sehat', compact([
            'user', 'info', 'examination', 'data'
        ]));*/


        $pdf = Pdf::loadView('pages.klinik.examinations.sehat', compact(['user', 'info', 'examination', 'data',
        ]));

        return $pdf->download('surat_keterangan_sehat_'.$user->name.'.pdf');
    }

    public function sakit(Request $request)
    {
        $examination = Examination::find($request->id);
        $user = User::find($examination->user_id);
        $info = $user->info;

        $data = json_decode(json_encode($request->all()));

        // get the default inner page
        /*return view('pages.klinik.examinations.sakit', compact([
            'user', 'info', 'examination', 'data'
        ]));*/

        $pdf = Pdf::loadView('pages.klinik.examinations.sakit', compact(['user', 'info', 'examination', 'data',
        ]));

        return $pdf->download('surat_keterangan_sakit_'.$user->name.'.pdf');
    }

    public function hakkewajiban(Request $request)
    {
        $examination = Examination::find($request->id);
        $user = User::find($examination->user_id);
        $info = $user->info;

        // get the default inner page
        $data = json_decode(json_encode($request->all()));
        //echo json_encode($data);exit;
        /*return view('pages.klinik.examinations.hakkewajiban', compact([
            'user', 'info', 'examination', 'data'
        ]));*/


        $pdf = Pdf::loadView('pages.klinik.examinations.hakkewajiban', compact(['user', 'info', 'examination', 'data',
        ]));

        return $pdf->download('bukti_penyampaian_informasi_'.$user->name.'.pdf');
    }

    public function persetujuan(Request $request)
    {
        $examination = Examination::find($request->id);
        $user = User::find($examination->user_id);
        $info = $user->info;

        // get the default inner page
        $data = json_decode(json_encode($request->all()));
        //echo json_encode($data);exit;
       /* return view('pages.klinik.examinations.persetujuan', compact([
            'user', 'info', 'examination', 'data'
        ]));*/


        $pdf = Pdf::loadView('pages.klinik.examinations.persetujuan', compact(['user', 'info', 'examination', 'data',
        ]));

        return $pdf->download('surat_keterangan_persetujuan_'.$user->name.'.pdf');
    }

    public function psikososial(Request $request)
    {
        $data = $request->all();
        $examination = Examination::where('id', $request->examination_id);

        unset($data['_token']);
        unset($data['examination_id']);
        unset($data['_method']);
        unset($data['user_id']);

        if($examination){
            $examination->update(['psikososial'=>json_encode($data)]);
        }

        return redirect()->route('examinations.edit', ['examination'=>$request->examination_id])->with('success', 'Vitality Examination has been updated !!');
    }

    public function penandaan_operasi(Request $request)
    {
        $examination = Examination::find($request->id);
        $user = User::find($examination->user_id);
        $info = $user->info;

        // get the default inner page
        $data = json_decode(json_encode($request->all()));
        //echo json_encode($data);exit;
        /*return view('pages.klinik.examinations.operasi', compact([
            'user', 'info', 'examination', 'data'
        ]));*/


        $pdf = Pdf::loadView('pages.klinik.examinations.operasi', compact(['user', 'info', 'examination', 'data',
        ]));

        return $pdf->download('penandaan_lokasi_operasi'.$user->name.'.pdf');
    }
}
