<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Models\Klinik\VitalityExamination;
use App\Http\Requests\StoreVitalityExaminationRequest;
use App\Http\Requests\UpdateVitalityExaminationRequest;

class VitalityExaminationsController extends Controller
{
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
     * @param  \App\Http\Requests\StoreVitalityExaminationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVitalityExaminationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Klinik\VitalityExamination  $vitalityExamination
     * @return \Illuminate\Http\Response
     */
    public function show(VitalityExamination $vitalityExamination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Klinik\VitalityExamination  $vitalityExamination
     * @return \Illuminate\Http\Response
     */
    public function edit(VitalityExamination $vitalityExamination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVitalityExaminationRequest  $request
     * @param  \App\Models\Klinik\VitalityExamination  $vitalityExamination
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVitalityExaminationRequest $request, VitalityExamination $vitalityExamination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Klinik\VitalityExamination  $vitalityExamination
     * @return \Illuminate\Http\Response
     */
    public function destroy(VitalityExamination $vitalityExamination)
    {
        //
    }
}
