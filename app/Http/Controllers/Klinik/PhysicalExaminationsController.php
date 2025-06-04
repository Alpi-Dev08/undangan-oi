<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StorePhysicalExaminationRequest;
use App\Http\Requests\Klinik\UpdatePhysicalExaminationRequest;
use App\Models\Klinik\Examination;
use App\Models\Klinik\PhysicalExamination;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;
use App\FHIR\Observations;

class PhysicalExaminationsController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Klinik\StorePhysicalExaminationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhysicalExaminationRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        $request->physical_value = json_encode($request->physical);

        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                $validated['physical_value'] = json_encode($request->physical);
                $physical = PhysicalExamination::create($validated);

                if ($physical) {
                    $this->setObservation($physical);
                }
            }catch(Exception $e){
                report($e);
                return false;
            }

            if($request->selesai){
                $examination = Examination::find($request->examination_id);
                $examination->status = "waiting payment";
                $examination->save();

                return redirect()->route('transactions.create', ['id' => $examination->id])->with('success', 'Physical Examination successfully created');
            }

            session()->flash('success', 'Disease has been created !!');
            return redirect()->route('examinations.edit',['examination' => $request->examination_id]);
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Klinik\PhysicalExamination  $physicalexamination
     * @return \Illuminate\Http\Response
     */
    public function show(PhysicalExamination $physicalexamination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Klinik\PhysicalExamination  $physicalexamination
     * @return \Illuminate\Http\Response
     */
    public function edit(PhysicalExamination $physicalexamination)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Klinik\UpdatePhysicalExaminationRequest  $request
     * @param  \App\Models\Klinik\PhysicalExamination  $physicalexamination
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhysicalExaminationRequest $request, PhysicalExamination $physicalexamination)
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        $request->physical_value = json_encode($request->physical);

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                $validated['physical_value'] = json_encode($request->physical);
                $physicalexamination->update($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            if($request->selesai){
                $examination = Examination::find($request->examination_id);
                $examination->status = "done";
                $examination->save();

                return redirect()->route('transactions.create', ['id' => $examination->id])->with('success', 'Physical Examination successfully created');
            }

            session()->flash('success', 'Disease has been created !!');
            return redirect()->route('examinations.edit',['examination' => $request->examination_id]);
        }

        return false;
    }

    private function setObservation(PhysicalExamination $physical)
        {
            $examination = Examination::where('id', $physical->examination_id)->first();
            $_encounter  = json_decode($examination->encounter);
            $participant = $_encounter->participant[0]->individual;

            $observation = $this->createBaseObservation($_encounter, $participant, $examination);

            $this->processHeadObservation($physical, $observation);
            $this->processeyeObservation($physical, $observation);
            $this->processEarObservation($physical, $observation);
            $this->processNoseObservation($physical, $observation);
            $this->processHairObservation($physical, $observation);
        }

        /**
         * Create base observation object with common properties
         */
        private function createBaseObservation($encounter, $participant, $examination)
        {
            $observation = new Observations();
            $observation->setStatus('final');
            $observation->addCategory('exam');
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
         * Process heart rate data
         */
        private function processHeadObservation(PhysicalExamination $physical, $observation)
        {
            if (!$physical->head) {
                return;
            }

            $observation->addCode('10199-8');
            $observation->addStringComponent($physical->head);
            $observation->post();
        }

        private function processEyeObservation(PhysicalExamination $physical, $observation)
        {
            if (!$physical->eye) {
                return;
            }

            $observation->addCode('10197-2');
            $observation->addStringComponent($physical->eye);
            $observation->post();
        }

        private function processEarObservation(PhysicalExamination $physical, $observation)
        {
            if (!$physical->ear) {
                return;
            }

            $observation->addCode('10195-6');
            $observation->addStringComponent($physical->ear);
            $observation->post();
        }

        private function processNoseObservation(PhysicalExamination $physical, $observation)
        {
            if (!$physical->nose) {
                return;
            }

            $observation->addCode('10203-8');
            $observation->addStringComponent($physical->nose);
            $observation->post();
        }

        private function processHairObservation(PhysicalExamination $physical, $observation)
        {
            if (!$physical->hair) {
                return;
            }

            $observation->addCode('32436-8');
            $observation->addStringComponent($physical->hair);
            $observation->post();
        }
}
