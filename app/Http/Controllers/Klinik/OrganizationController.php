<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Models\Klinik\Organization;
use App\Http\Requests\StoreOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Models\Master\City;
use App\Models\Master\Country;
use App\Models\Master\District;
use App\Models\Master\Province;
use App\Models\Master\SubDistrict;
use App\Models\User;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization = Organization::find(1);
        $user      =auth()->user();
        $info      = $user->info;

        $countries = Country::all();
        $provinces    = $organization->country_id != null ? Province::where('country_id', $organization->country_id)->get() : Province::all();
        $cities       = $organization->province_id != null ? City::where('province_id', $organization->province_id)->get() : null;
        $districts    = $organization->city_id != null ? District::where('city_id', $organization->city_id)->get() : null;
        $subdistricts = $organization->district_id != null ? SubDistrict::where('district_id', $organization->district_id)->get() : null;

        return view('pages.klinik.organization.overview.overview', compact('organization','user','info','countries', 'provinces', 'cities', 'districts', 'subdistricts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrganizationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrganizationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Klinik\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Klinik\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        $countries = $organization->country;
        $provinces    = $organization->country_id != null ? Province::where('country_id', $organization->country_id)->get() : Province::all();
        $cities       = $organization->province_id != null ? City::where('province_id', $organization->province_id)->get() : null;
        $districts    = $organization->city_id != null ? District::where('city_id', $organization->city_id)->get() : null;
        $subdistricts = $organization->district_id != null ? SubDistrict::where('district_id', $organization->district_id)->get() : null;

        return view('klinik.organization.settings.settings', compact('organization', 'countries', 'provinces', 'cities', 'districts', 'subdistricts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrganizationRequest  $request
     * @param  \App\Models\Klinik\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Klinik\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
