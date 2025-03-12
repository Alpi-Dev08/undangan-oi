<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreFamilyDiseaseHistoryRequest;
use App\Http\Requests\Klinik\UpdateFamilyDiseaseHistoryRequest;
use App\Models\Klinik\FamilyDiseaseHistory;
use App\DataTables\Klinik\FamilyDiseaseHistoryDataTable;

class FamilyDiseaseHistoryController extends Controller
{
    public function index(FamilyDiseaseHistoryDataTable $dataTable)
    {
        return $dataTable->render('pages.klinik.family_disease_histories.index');
    }

    public function create()
    {
        return view('pages.klinik.family_disease_histories.create');
    }

    public function store(StoreFamilyDiseaseHistoryRequest $request)
    {
        FamilyDiseaseHistory::create($request->validated());

        return redirect()->route('family-disease-histories.index')
            ->with('success', 'Family Disease History created successfully.');
    }

    public function show(FamilyDiseaseHistory $familyDiseaseHistory)
    {
        return view('pages.klinik.family_disease_histories.show', compact('familyDiseaseHistory'));
    }

    public function edit(FamilyDiseaseHistory $familyDiseaseHistory)
    {
        $family_disease_history =$familyDiseaseHistory;
        return view('pages.klinik.family_disease_histories.edit', compact(['familyDiseaseHistory','family_disease_history']));
    }

    public function update(UpdateFamilyDiseaseHistoryRequest $request, FamilyDiseaseHistory $familyDiseaseHistory)
    {
        $familyDiseaseHistory->update($request->validated());

        return redirect()->route('family-disease-histories.index')
            ->with('success', 'Family Disease History updated successfully.');
    }

    public function destroy(FamilyDiseaseHistory $familyDiseaseHistory)
    {
        $familyDiseaseHistory->delete();

        return redirect()->route('family-disease-histories.index')
            ->with('success', 'Family Disease History deleted successfully.');
    }
}
