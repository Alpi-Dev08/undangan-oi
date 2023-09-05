<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\LaboratoryExaminationsDataTable;
    use App\Http\Controllers\Controller;

    use App\Http\Requests\Klinik\StoreLaboratoryExaminationRequest;
    use App\Http\Requests\Klinik\UpdateLaboratoryExaminationRequest;
    use App\Models\Klinik\Examination;
    use App\Models\Klinik\HealthProfesional;
    use App\Models\Klinik\LaboratoryExamination;
    use App\Models\Klinik\LaboratoryExaminationType;
    use App\Models\Klinik\MedicalRecord;
    use App\Models\Klinik\PackageDetail;
    use App\Models\Klinik\Patient;
    use App\Models\Klinik\Service;
    use App\Models\Klinik\ServiceCategory;
    use App\Models\Klinik\Transaction;
    use App\Models\Klinik\TransactionDetail;
    use App\Models\User;
    use Carbon\Carbon;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Haruncpi\LaravelIdGenerator\IdGenerator;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Storage;
    use Log;
    use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
    use Barryvdh\DomPDF\Facade\Pdf;


    class LaboratoryExaminationsController extends Controller
    {
        public $user;

        public function __construct()
        {
            $this->middleware(function ($request, $next) {
                $this->user = Auth::guard('web')->user();
                return $next($request);
            });
        }

        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index(LaboratoryExaminationsDataTable $dataTable)
        {
            return $dataTable->render('pages.klinik.laboratoryexaminations.index');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param StoreLaboratoryExaminationRequest $request
         *
         * @return Response
         */
        public function store(StoreLaboratoryExaminationRequest $request)
        {
            // Validation Data
            $validated = $request->validated();

            // Process Data
            try {
                $user = User::find($request->user_id);


                if ($request->examination_id) {
                    $examination = Examination::find($request->examination_id);
                    $transaction = Transaction::where('examination_id', $request->examination_id)->first();
                } else {
                    $examination_code = IdGenerator::generate(['table' => 'examinations', 'field' => 'examination_code', 'length' => 12, 'prefix' => 'E' . date('Ymd')]);
                    $medical_record   = MedicalRecord::where('user_id', $request->user_id)->first();
                    if ($medical_record) {
                        $medical_record_id = $medical_record->medical_record_code;
                    } else {

                        $medical_record_id = IdGenerator::generate(['table' => 'medical_records', 'field' => 'medical_record_code', 'length' => 13, 'prefix' => 'MR' . date('Ymd')]);

                        $medical_record                      = new MedicalRecord();
                        $medical_record->medical_record_code = $medical_record_id;
                        $medical_record->user_id             = $user->id;
                        $medical_record->save();
                    }

                    $examination                        = new Examination();
                    $examination->user_id               = $user->id;
                    $examination->patient_id            = $user->patient->id;
                    $examination->medical_record_id     = $medical_record->id;
                    $examination->health_profesional_id = $request->health_profesional_id ?? '';
                    $examination->service_category_id   = 15;
                    $examination->location_id           = $request->location_id;
                    $examination->examination_code      = $examination_code;
                    $examination->examination_date      = date('Y-m-d H:i:s');
                    $examination->total                 = 0;
                    $examination->status                = 'waiting payment';
                    $examination->is_lab                = '1';
                    $examination->save();

                    $inv = IdGenerator::generate(['table' => 'transactions', 'field' => 'invoice_number', 'length' => 14, 'prefix' => 'INV' . date('Ymd')]);

                    $transactions                 = new Transaction();
                    $transactions->examination_id = $examination->id;
                    $transactions->invoice_number = $inv;
                    $transactions->amount         = $examination->total;
                    $transactions->status         = 'waiting payment';
                    $transactions->save();

                    $transaction = $transactions;

                    $service                            = Service::find(147);
                    $transaction_detail                 = new TransactionDetail();
                    $transaction_detail->transaction_id = $transactions->id;
                    $transaction_detail->service_id     = 147;
                    $transaction_detail->name           = $service->name ?? "-";
                    $transaction_detail->quantity       = 1;
                    $transaction_detail->price          = $service->price ?? 0;
                    $transaction_detail->total          = ($service->price ?? 0) * 1;
                    $transaction_detail->save();

                    $transaction->amount = $transaction->amount + $transaction_detail->total;
                    $transaction->save();


                    $validated['examination_id'] = $examination->id;

                }
                $dokter = HealthProfesional::find($request->health_profesional_id);
                $info   = $dokter->user->info;

                $validated['laboratory_name'] = $request->laboratory_name ?? "";
                $validated['status']          = 'waiting payment';
                $laboratoryexamination        = LaboratoryExamination::create($validated);

            } catch (Exception $e) {
                report($e);
                return false;
            }

            session()->flash('success', 'Laboratory Examination has been created !!');

            return redirect()->route('examinations.invoice', ['id' => $examination->id]);


            return false;
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return Response
         */
        public function create()
        {
            if (is_null($this->user) || !$this->user->can('hms.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }
            return view('pages.hms.laboratoryexaminations.create');
        }

        public function company(Request $request)
        {
            $transaction = Transaction::find($request->transaction);
            $companies   = Company::all();
            return view('pages.hms.laboratoryexaminations.company', compact('transaction', 'companies'));
        }


        /**
         * Show the form for editing the specified resource.
         *
         * @param  $id
         *
         * @return Response
         */
        public function edit($id)
        {
            if (is_null($this->user) || !$this->user->can('hms.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
            }

            $laboratoryexamination = LaboratoryExamination::find($id);
            $examination           = Examination::find($laboratoryexamination->examination_id);
            $types                 = json_decode($laboratoryexamination->laboratory_examination_types, true);
            $user                  = User::find($examination->user_id);
            $info                  = $user->info;

            $healthprofesionals = HealthProfesional::all();

            return view('pages.klinik.laboratoryexaminations.edit', compact('laboratoryexamination', 'examination', 'types', 'user', 'info', 'healthprofesionals'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param UpdateLaboratoryExaminationRequest $request
         * @param LaboratoryExamination              $laboratoryexamination
         *
         * @return Response
         */
        public function update(Request $request, LaboratoryExamination $laboratoryexamination)
        {
            if (is_null($this->user) || !$this->user->can('hms.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
            }

            if ($request->hasFile('file')) {
                $_file       = $request->file('file');
                $destination = $_file->getClientOriginalName();
                Storage::disk('public')->putFileAs('file', $_file, $_file->getClientOriginalName());
                $request->destination = 'file/' . $destination;

                $laboratoryexaminations         = LaboratoryExamination::find($laboratoryexamination->id);
                $laboratoryexaminations->file   = $request->destination;
                $laboratoryexaminations->status = 'done';
                $laboratoryexaminations->save();
            }

            session()->flash('success', 'LaboratoryExamination has been updated !!');
            return redirect()->route('laboratoryexaminations.index');


            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param LaboratoryExamination $laboratoryexamination
         *
         * @return Response
         */
        public function destroy(LaboratoryExamination $laboratoryexamination)
        {
            if (is_null($this->user) || !$this->user->can('hms.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $laboratoryexamination->delete();

            session()->flash('success', 'LaboratoryExamination has been deleted !!');
            return redirect()->route('laboratoryexaminations.index');
        }

        public function lab(Request $request)
        {

            $user               = User::find($request->id);
            $info               = $user->info;
            $healthprofesionals = HealthProfesional::all();

            return view('pages.klinik.laboratoryexaminations.lab', compact('user', 'info', 'healthprofesionals'));
        }

        public function download(Request $request)
        {
            $laboratoryexaminations = LaboratoryExamination::find($request->id);

            $examination           = Examination::find($laboratoryexaminations->examination_id);
            $patient                = Patient::find($examination->patient_id);
            $user                   = User::find($patient->user_id);
            $result                 = [];
            if ($laboratoryexaminations->hasil) {
                $result = json_encode(array_merge($result, json_decode($laboratoryexaminations->hasil, true)));
                $result = json_decode($result);
            }

            $pdf = Pdf::loadView('pages.klinik.laboratoryexaminations.pdf', compact(['laboratoryexaminations','examination','patient','user','result']));
            Storage::put('public/examinations/'.$examination->examination_code.'/2.lab-result.pdf', $pdf->output());
            return $pdf->download('laboratory-examination.pdf');
        }

        public function result(Request $request)
        {
            $laboratoryexaminations = LaboratoryExamination::find($request->id);
            $examination            = Examination::find($laboratoryexaminations->examination_id);
            $patient                = Patient::find($examination->patient_id);
            $user                   = User::find($patient->user_id);
            $medical_record         = MedicalRecord::find($examination->medical_record_id);
            $type                   = LaboratoryExaminationType::all();
            $result                 = [];
            if ($laboratoryexaminations->hasil) {
                $result = json_encode(array_merge($result, json_decode($laboratoryexaminations->hasil, true)));
                $result = json_decode($result);
            }

            return view('pages.klinik.laboratoryexaminations.result', compact('laboratoryexaminations', 'examination', 'patient', 'user', 'medical_record', 'result', 'type'));
        }

        public function resultUpdate(Request $request, LaboratoryExamination $laboratoryexaminations)
        {
            $laboratoryexamination = LaboratoryExamination::find($request->laboratoryexaminations);
            $result                = [];
            if ($request->id[0]) {
                $jumlah = 0;
                foreach ($request->id as $key => $value) {
                    if ($request->id[$key] != null) {
                        $jumlah++;
                    }
                }
                for ($i = 0; $i < $jumlah; $i++) {
                    $item     = LaboratoryExaminationType::find($request->id[$i]);
                    $itemName = $item->name;
                    $data_    = [
                        "id"            => $request->id[$i],
                        "ItemName"      => $itemName,
                        "hasil"         => $request->hasil[$i],
                        "satuan"         => $request->satuan[$i],
                        "keterangan"         => $request->keterangan[$i],
                        "nilai_rujukan" => $item->nilai_rujukan,
                    ];

                    $result[] = $data_;
                }

                $laboratoryexamination->hasil = json_encode($result);
            } else {
                $laboratoryexamination->hasil = null;

            }

            $laboratoryexamination->save();
            return redirect()->route('laboratoryexaminations.result', ["id" => $laboratoryexamination->id]);
        }
    }
