<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreAnamnesisExaminationRequest;
use App\Http\Requests\Klinik\UpdateAnamnesisExaminationRequest;
use App\Models\Klinik\AnamnesisExamination;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;

class AnamnesisExaminationsController extends Controller
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
     * @param  \App\Http\Requests\Klinik\StoreAnamnesisExaminationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnamnesisExaminationRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        $request->anamnesis_value = json_encode($request->anamnesis);
        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                $validated['anamnesis_value'] = json_encode($request->anamnesis);
                AnamnesisExamination::create($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Disease has been created !!');
            return redirect()->route('examinations.index');
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Klinik\AnamnesisExamination  $anamnesisExamination
     * @return \Illuminate\Http\Response
     */
    public function show(AnamnesisExamination $anamnesisExamination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Klinik\AnamnesisExamination  $anamnesisExamination
     * @return \Illuminate\Http\Response
     */
    public function edit(AnamnesisExamination $anamnesisExamination)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Klinik\UpdateAnamnesisExaminationRequest  $request
     * @param  \App\Models\Klinik\AnamnesisExamination  $anamnesisExamination
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnamnesisExaminationRequest $request, AnamnesisExamination $anamnesisexamination)
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        $request->anamnesis_value = json_encode($request->anamnesis);
        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                $validated['anamnesis_value'] = json_encode($request->anamnesis);
                $anamnesisexamination->update($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Disease has been created !!');
            return redirect()->route('examinations.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Klinik\AnamnesisExamination  $anamnesisExamination
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnamnesisExamination $anamnesisExamination)
    {
        //
    }
}
