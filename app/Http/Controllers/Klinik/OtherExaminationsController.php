<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreOtherExaminationRequest;
use App\Http\Requests\Klinik\UpdateOtherExaminationRequest;
use App\Models\Klinik\Examination;
use App\Models\Klinik\OtherExamination;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;

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

        // Process Data
        if($validated){
            try{
                $validated['other_value'] = json_encode($request->other);
                OtherExamination::create($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            if($request->selesai){
                $examination = Examination::find($request->examination_id);
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

        // Process Data
        if($validated){
            try{
                $validated['other_value'] = json_encode($request->other);
                $otherexamination->update($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            if($request->selesai){
                $examination = Examination::find($request->examination_id);
                $examination->status = "waiting payment";
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
