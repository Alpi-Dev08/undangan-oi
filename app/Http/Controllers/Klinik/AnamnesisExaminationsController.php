<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Models\Klinik\AnamnesisExamination;
use App\Http\Requests\StoreAnamnesisExaminationRequest;
use App\Http\Requests\UpdateAnamnesisExaminationRequest;

class AnamnesisExaminationsController extends Controller
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
     * @param  \App\Http\Requests\StoreAnamnesisExaminationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnamnesisExaminationRequest $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnamnesisExaminationRequest  $request
     * @param  \App\Models\Klinik\AnamnesisExamination  $anamnesisExamination
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnamnesisExaminationRequest $request, AnamnesisExamination $anamnesisExamination)
    {
        //
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
