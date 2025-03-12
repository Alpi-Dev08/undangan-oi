<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\PersonalDiseaseHistoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StorePersonalDiseaseHistoryRequest;
use App\Http\Requests\Klinik\UpdatePersonalDiseaseHistoryRequest;
use App\Models\Klinik\PersonalDiseaseHistory;

class PersonalDiseaseHistoryController extends Controller
{
    public function index(PersonalDiseaseHistoryDataTable $dataTable)
    {
        return $dataTable->render('pages.klinik.personal_disease_histories.index');
    }

    public function create()
    {
        return view('pages.klinik.personal_disease_histories.create');
    }

    public function store(StorePersonalDiseaseHistoryRequest $request)
    {
        $validated = $request->validated();

        PersonalDiseaseHistory::create($validated);

        return redirect()->route('personal-disease-histories.index')
            ->with('success', 'Personal disease history created successfully.');
    }

    public function edit(PersonalDiseaseHistory $personalDiseaseHistory)
    {
        $personal_disease_history = $personalDiseaseHistory;
        return view('pages.klinik.personal_disease_histories.edit', compact(['personal_disease_history','personalDiseaseHistory']));
    }

    public function update(UpdatePersonalDiseaseHistoryRequest $request, PersonalDiseaseHistory $personalDiseaseHistory)
    {
        $validated = $request->validated();

        $personalDiseaseHistory->update($validated);

        return redirect()->route('personal-disease-histories.index')
            ->with('success', 'Personal disease history updated successfully.');
    }

    public function destroy(PersonalDiseaseHistory $personalDiseaseHistory)
    {
        $personalDiseaseHistory->delete();

        return redirect()->route('personal-disease-histories.index')
            ->with('success', 'Personal disease history deleted successfully.');
    }
}
