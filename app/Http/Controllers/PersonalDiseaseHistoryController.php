<?php

namespace App\Http\Controllers;

use App\Http\Requests\Klinik\StorePersonalDiseaseHistoryRequest;
use App\Http\Requests\Klinik\UpdatePersonalDiseaseHistoryRequest;
use App\Models\Klinik\PersonalDiseaseHistory;
use Illuminate\Http\Request;

class PersonalDiseaseHistoryController extends Controller
{
    public function index()
    {
        $histories = PersonalDiseaseHistory::all();
        return view('personal_disease_histories.index', compact('histories'));
    }

    public function create()
    {
        return view('personal_disease_histories.create');
    }

    public function store(StorePersonalDiseaseHistoryRequest $request)
    {
        $validated = $request->validated();

        PersonalDiseaseHistory::create($validated);

        return redirect()->route('personal_disease_histories.index')
            ->with('success', 'Personal disease history created successfully.');
    }

    public function edit(PersonalDiseaseHistory $personalDiseaseHistory)
    {
        return view('personal_disease_histories.edit', compact('personalDiseaseHistory'));
    }

    public function update(UpdatePersonalDiseaseHistoryRequest $request, PersonalDiseaseHistory $personalDiseaseHistory)
    {
        $validated = $request->validated();

        $personalDiseaseHistory->update($validated);

        return redirect()->route('personal_disease_histories.index')
            ->with('success', 'Personal disease history updated successfully.');
    }

    public function destroy(PersonalDiseaseHistory $personalDiseaseHistory)
    {
        $personalDiseaseHistory->delete();

        return redirect()->route('personal_disease_histories.index')
            ->with('success', 'Personal disease history deleted successfully.');
    }
}
