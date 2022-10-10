<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Models\Klinik\PhysicalExamination;
use App\Http\Requests\StorePhysicalExaminationRequest;
use App\Http\Requests\UpdatePhysicalExaminationRequest;

class PhysicalExaminationsController extends Controller
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
     * @param  \App\Http\Requests\StorePhysicalExaminationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhysicalExaminationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Klinik\PhysicalExamination  $physicalExamination
     * @return \Illuminate\Http\Response
     */
    public function show(PhysicalExamination $physicalExamination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Klinik\PhysicalExamination  $physicalExamination
     * @return \Illuminate\Http\Response
     */
    public function edit(PhysicalExamination $physicalExamination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhysicalExaminationRequest  $request
     * @param  \App\Models\Klinik\PhysicalExamination  $physicalExamination
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhysicalExaminationRequest $request, PhysicalExamination $physicalExamination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Klinik\PhysicalExamination  $physicalExamination
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhysicalExamination $physicalExamination)
    {
        //
    }
}
