<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\VitalityExaminationsDataTable;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Klinik\StoreVitalityExaminationRequest;
    use App\Http\Requests\Klinik\UpdateVitalityExaminationRequest;
    use App\Models\Klinik\Examination;
    use App\Models\Klinik\VitalityExamination;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Satusehat\Integration\FHIR\Observation;


    class VitalityExaminationsController extends Controller
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
         * @return \Illuminate\Http\Response
         */
        public function index(VitalityExaminationsDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.vitalityexaminations.index');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\Klinik\StoreVitalityExaminationRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreVitalityExaminationRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            //dd($validated);

            // Process Data
            if ($validated) {
                try {
                    $vit = VitalityExamination::create($validated);

                    if($vit) {
                        $this->setObservation($vit);
                    }

                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'Vitality Examination has been created !!');
                return redirect()->route('examinations.index');
            }

            return false;
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }
            return view('pages.klinik.vitalityexaminations.create');
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\Klinik\VitalityExamination $vitalityexamination
         *
         * @return \Illuminate\Http\Response
         */
        public function show(VitalityExamination $vitalityexamination)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  $id
         *
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            if (is_null($this->user) || !$this->user->can('klinik.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
            }

            $vitalityexamination = VitalityExamination::find($id);
            $id                  = $vitalityexamination->examination_id;
            return view('pages.klinik.examinations.vitality', compact('vitalityexamination', 'id'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\Klinik\UpdateVitalityExaminationRequest $request
         * @param \App\Models\Klinik\VitalityExamination                     $vitalityexamination
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateVitalityExaminationRequest $request, VitalityExamination $vitalityexamination)
        {
            if (is_null($this->user) || !$this->user->can('klinik.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                // Process Data
                try {
                    $vitalityexamination->update($validated);

                    $vit = $vitalityexamination;

                    if($vit) {
                        $this->setObservation($vit);
                    }

                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'VitalityExamination has been updated !!');
                return redirect()->route('examinations.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\VitalityExamination $vitalityexamination
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(VitalityExamination $vitalityexamination)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $vitalityexamination->delete();

            session()->flash('success', 'VitalityExamination has been deleted !!');
            return redirect()->route('vitalityexaminations.index');
        }

        public function skrining(Request $request)
        {
            $data = $request->all();
            $vitalityexamination = VitalityExamination::where('examination_id', $request->examination_id);

            unset($data['_token']);
            unset($data['examination_id']);
            unset($data['_method']);
            unset($data['user_id']);

            if($vitalityexamination){
                $vitalityexamination->update(['skrining'=>json_encode($data)]);
            }

            return redirect()->route('examinations.vitality', ['id'=>$request->examination_id])->with('success', 'Vitality Examination has been updated !!');
        }

        private function setObservation($vit){
            $examination         = Examination::where('id', $vit->examination_id)->first();;
            $_encounter = json_decode($examination->encounter);
            $participant = $_encounter->participant[0]->individual;

            $observation = new Observation();
            $observation->setStatus('final');
            $observation->addCategory('vital-signs');
            $observation->setSubject(str_replace('Patient/', '', $_encounter->subject->reference), $_encounter->subject->display);
            $observation->setPerformer(str_replace('Practitioner/','',$participant->reference),$participant->display); // ID SATUSEHAT Dokter, Nama Dokter)
            $observation->setEncounter($examination->encounter_id);

            if($vit->blood_pressure){
                $bloodPressure = explode('/', $vit->blood_pressure);
                foreach ($bloodPressure as $key => $value) {
                    $observation->addCode($key ? '8462-4' : '8480-6');
                    $observation->addComponent([
                        'value'  => (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                        'unit'   => 'mm[Hg]',
                        'system' => 'http://unitsofmeasure.org',
                        'code'   => 'mm[Hg]'

                    ]);
                    $observation->post();
                }
            }

            if($vit->heart_rate){
                $observation->addCode('8867-4');
                $observation->addComponent([
                    'value'  => (float) filter_var($vit->heart_rate, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'unit'   => '{beats}/min',
                    'system' => 'http://unitsofmeasure.org',
                    'code'   => '{beats}/min'

                ]);
                $observation->post();
            }

            if($vit->temperature){
                $observation->addCode('8310-5');
                $observation->addComponent([
                    'value'  => (float) filter_var($vit->temperature, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'unit'   => 'Cel',
                    'system' => 'http://unitsofmeasure.org',
                    'code'   => 'Cel'

                ]);
                $observation->post();
            }

            if($vit->respiratory_rate){
                $observation->addCode('9279-1');
                $observation->addComponent([
                    'value'  => (float) filter_var($vit->respiratory_rate, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    'unit'   => '{breaths}/min',
                    'system' => 'http://unitsofmeasure.org',
                    'code'   => '{breaths}/min'

                ]);
                $observation->post();
            }
        }
    }
