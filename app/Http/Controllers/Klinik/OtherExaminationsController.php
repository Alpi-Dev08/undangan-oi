<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreOtherExaminationRequest;
use App\Http\Requests\Klinik\UpdateOtherExaminationRequest;
use App\Models\Hms\LaboratoryExamination;
use App\Models\Klinik\Examination;
use App\Models\Klinik\OtherExamination;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OtherExaminationsController extends Controller
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
     * @param  \App\Http\Requests\Klinik\StoreOtherExaminationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOtherExaminationRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        $request->other_value = json_encode($request->other);
        // Validation Data
        $validated = $request->validated();
        $examination = Examination::find($request->examination_id);
        // Process Data

        if($validated){
            try{
                $validated['other_value'] = json_encode($request->other);
                if($request->hasFile('file')){
                    $_file      = $request->file('file');
                    foreach ($_file as $key => $file){
                        $file_name  = $file->getClientOriginalName();
                        $file->storeAs('public/examinations/'.$examination->examination_code, $key.'.'.$file_name);
                        if($file->isValid()){
                            $validated['file'][$key] = $key.'.'.$file_name;
                        }
                    }
                    $validated['file'] = json_encode($validated['file']);
                }

                OtherExamination::create($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            if($request->selesai){

                $examination->status = "waiting payment";
                $examination->save();

                return redirect()->route('transactions.create', ['id' => $examination->id])->with('success', 'Other Examination successfully created');
            }

            session()->flash('success', 'Disease has been created !!');
            return redirect()->route('examinations.edit',['examination' => $request->examination_id]);
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Klinik\OtherExamination  $otherexamination
     * @return \Illuminate\Http\Response
     */
    public function show(OtherExamination $otherexamination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Klinik\OtherExamination  $otherexamination
     * @return \Illuminate\Http\Response
     */
    public function edit(OtherExamination $otherexamination)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Klinik\UpdateOtherExaminationRequest  $request
     * @param  \App\Models\Klinik\OtherExamination  $otherexamination
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOtherExaminationRequest $request, OtherExamination $otherexamination)
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        $request->other_value = json_encode($request->other);
        // Validation Data
        $validated = $request->validated();
        $examination = Examination::find($request->examination_id);
        // Process Data
        if($validated){
            try{
                $validated['other_value'] = json_encode($request->other);
                if($request->hasFile('file')){
                    $_file      = $request->file('file');
                    foreach ($_file as $key => $file){
                        $file_name  = $file->getClientOriginalName();
                        $file->storeAs('public/examinations/'.$examination->examination_code, $key.'.'.$file_name);
                        if($file->isValid()){
                            $validated['file'][$key] = $key.'.'.$file_name;
                        }
                    }
                    $validated['file'] = json_encode($validated['file']);
                }

                $otherexamination->update($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            if($request->selesai){

                $examination->status = "done";
                $examination->save();

                return redirect()->route('transactions.create', ['id' => $examination->id])->with('success', 'Other Examination successfully created');
            }

            session()->flash('success', 'Other Examination has been created !!');
            return redirect()->route('examinations.edit',['examination' => $request->examination_id]);
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Klinik\OtherExamination  $otherexamination
     * @return \Illuminate\Http\Response
     */
    public function destroy(OtherExamination $otherexamination)
    {
        //
    }
}
