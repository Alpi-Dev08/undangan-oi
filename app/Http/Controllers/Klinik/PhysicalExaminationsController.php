<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StorePhysicalExaminationRequest;
use App\Http\Requests\Klinik\UpdatePhysicalExaminationRequest;
use App\Models\Klinik\PhysicalExamination;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;

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
        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                $validated['physical_value'] = json_encode($request->physical);
                PhysicalExamination::create($validated);
            }catch(Exception $e){
                report($e);
                return false;
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

            session()->flash('success', 'Disease has been created !!');
            return redirect()->route('examinations.edit',['examination' => $request->examination_id]);
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Klinik\PhysicalExamination  $physicalexamination
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhysicalExamination $physicalexamination)
    {
        //
    }
}
