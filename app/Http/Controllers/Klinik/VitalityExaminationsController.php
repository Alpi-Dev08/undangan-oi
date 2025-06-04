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
    use App\FHIR\Observations;

    class VitalityExaminationsController extends Controller
    {
        private const UNAUTHORIZED_VIEW   = 'Sorry !! Anda tidak berwenang untuk melihat data master!';
        private const UNAUTHORIZED_CREATE = 'Sorry !! Anda tidak berwenang untuk membuat data master!';
        private const UNAUTHORIZED_UPDATE = 'Sorry !! Anda tidak berwenang untuk mengubah data master!';
        private const UNAUTHORIZED_DELETE = 'Sorry !! Anda tidak berwenang untuk menghapus data master!';

        protected $user;

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
            $this->authorizeAction('klinik.read', self::UNAUTHORIZED_VIEW);
            return $dataTable->render('pages.klinik.vitalityexaminations.index');
        }

        /**
         * Authorize action based on permission
         *
         * @param string $permission
         * @param string $message
         *
         * @throws \Illuminate\Auth\Access\AuthorizationException
         */
        private function authorizeAction(string $permission, string $message)
        {
            if (is_null($this->user) || !$this->user->can($permission)) {
                abort(403, $message);
            }
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
            $this->authorizeAction('klinik.create', self::UNAUTHORIZED_CREATE);

            $validated = $request->validated();

            try {
                $vit = VitalityExamination::create($validated);
                if ($vit) {
                    $this->setObservation($vit);
                }

                session()->flash('success', 'Vitality Examination has been created !!');
                return redirect()->route('examinations.index');
            } catch (Exception $e) {
                report($e);
                return $this->handleError('Failed to create Vitality Examination');
            }
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $this->authorizeAction('klinik.create', self::UNAUTHORIZED_CREATE);
            return view('pages.klinik.vitalityexaminations.create');
        }

        /**
         * Set observation data for vital signs
         *
         * @param VitalityExamination $vit
         */
        private function setObservation(VitalityExamination $vit)
        {
            $examination = Examination::where('id', $vit->examination_id)->first();
            $_encounter  = json_decode($examination->encounter);
            $participant = $_encounter->participant[0]->individual;

            $observation = $this->createBaseObservation($_encounter, $participant, $examination);

            $this->processBloodPressure($vit, $observation);
            $this->processHeartRate($vit, $observation);
            $this->processTemperature($vit, $observation);
            $this->processRespiratoryRate($vit, $observation);
            $this->processBodyHeight($vit, $observation);
            $this->processBodyWeight($vit, $observation);
        }

        /**
         * Create base observation object with common properties
         */
        private function createBaseObservation($encounter, $participant, $examination)
        {
            $observation = new Observations();
            $observation->setStatus('final');
            $observation->addCategory('vital-signs');
            $observation->setSubject(
                str_replace('Patient/', '', $encounter->subject->reference),
                $encounter->subject->display
            );
            $observation->setPerformer(
                str_replace('Practitioner/', '', $participant->reference),
                $participant->display
            );
            $observation->setEncounter($examination->encounter_id);

            return $observation;
        }

        /**
         * Process blood pressure data
         */
        private function processBloodPressure(VitalityExamination $vit, $observation)
        {
            if (!$vit->blood_pressure) {
                return;
            }

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

        /**
         * Process heart rate data
         */
        private function processHeartRate(VitalityExamination $vit, $observation)
        {
            if (!$vit->heart_rate) {
                return;
            }

            $observation->addCode('8867-4');
            $observation->addComponent([
                'value'  => (float) filter_var($vit->heart_rate, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'unit'   => '{beats}/min',
                'system' => 'http://unitsofmeasure.org',
                'code'   => '{beats}/min'
            ]);
            $observation->post();
        }

        /**
         * Process body height data
         */
        private function processBodyHeight(VitalityExamination $vit, $observation)
        {
            if (!$vit->height) {
                return;
            }

            // Process body height in cm
            $observation->addCode('8302-2');
            $observation->addComponent([
                'value'  => (float) filter_var($vit->height, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'unit'   => 'cm',
                'system' => 'http://unitsofmeasure.org',
                'code'   => 'cm'
            ]);
            $observation->post();
        }

        private function processBodyWeight(VitalityExamination $vit, $observation){
            if (!$vit->weight) {
                return;
            }

            // Process body height in cm
            $observation->addCode('8302-2');
            $observation->addComponent([
                'value'  => (float) filter_var($vit->weight, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'unit'   => 'kg',
                'system' => 'http://unitsofmeasure.org',
                'code'   => 'kg'
            ]);
            $observation->post();
        }

        /**
         * Process temperature data
         */
        private function processTemperature(VitalityExamination $vit, $observation)
        {
            if (!$vit->temperature) {
                return;
            }

            $observation->addCode('8310-5');
            $observation->addComponent([
                'value'  => (float) filter_var($vit->temperature, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'unit'   => 'Cel',
                'system' => 'http://unitsofmeasure.org',
                'code'   => 'Cel'
            ]);
            $observation->post();
        }

        /**
         * Process respiratory rate data
         */
        private function processRespiratoryRate(VitalityExamination $vit, $observation)
        {
            if (!$vit->respiratory_rate) {
                return;
            }

            $observation->addCode('9279-1');
            $observation->addComponent([
                'value'  => (float) filter_var($vit->respiratory_rate, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'unit'   => '{breaths}/min',
                'system' => 'http://unitsofmeasure.org',
                'code'   => '{breaths}/min'
            ]);
            $observation->post();
        }

        /**
         * Handle error responses
         *
         * @param string $message
         *
         * @return \Illuminate\Http\Response
         */
        private function handleError(string $message)
        {
            session()->flash('error', $message);
            return back();
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
            $this->authorizeAction('klinik.update', self::UNAUTHORIZED_UPDATE);

            $vitalityexamination = VitalityExamination::find($id);
            $id                  = $vitalityexamination->examination_id;

            return view('pages.klinik.examinations.vitality', compact('vitalityexamination', 'id'));
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
            $this->authorizeAction('klinik.delete', self::UNAUTHORIZED_DELETE);

            $vitalityexamination->delete();
            session()->flash('success', 'VitalityExamination has been deleted !!');

            return redirect()->route('vitalityexaminations.index');
        }

        /**
         * Process skrining data
         *
         * @param Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function skrining(Request $request)
        {
            $examinationId       = $request->examination_id;
            $vitalityexamination = VitalityExamination::where('examination_id', $examinationId);

            $data = $this->filterSkriningData($request->all());

            if ($vitalityexamination) {
                $vitalityexamination->update(['skrining' => json_encode($data)]);
            }

            return redirect()
                ->route('examinations.vitality', ['id' => $examinationId])
                ->with('success', 'Vitality Examination has been updated !!');
        }

        /**
         * Filter skrining data by removing unnecessary fields
         *
         * @param array $data
         *
         * @return array
         */
        private function filterSkriningData(array $data)
        : array
        {
            $fieldsToRemove = ['_token', 'examination_id', '_method', 'user_id'];

            foreach ($fieldsToRemove as $field) {
                unset($data[$field]);
            }

            return $data;
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
            $this->authorizeAction('klinik.update', self::UNAUTHORIZED_UPDATE);

            $validated = $request->validated();

            try {
                $vitalityexamination->update($validated);

                if ($vitalityexamination) {
                    $this->setObservation($vitalityexamination);
                }

                session()->flash('success', 'VitalityExamination has been updated !!');
                return redirect()->route('examinations.index');
            } catch (Exception $e) {
                report($e);
                return $this->handleError('Failed to update Vitality Examination');
            }
        }
    }
