<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreOrganizationRequest;
use App\Http\Requests\Klinik\UpdateOrganizationRequest;
use App\Models\Klinik\Organization;
use App\Models\Master\City;
use App\Models\Master\Country;
use App\Models\Master\District;
use App\Models\Master\Province;
use App\Models\Master\SubDistrict;
use Illuminate\Support\Facades\Storage;

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
        //generateToken();
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
     * @param  \App\Http\Requests\Klinik\StoreOrganizationRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrganizationRequest $request)
    {
        //\
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
     * @param \App\Http\Requests\Klinik\UpdateOrganizationRequest $request
     * @param  \App\Models\Klinik\Organization                    $organization
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        try{
            $organization->update($request->validated());
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('images/logos', 'public');
                $organization->logo = $path;
                $organization->save();
            }
            $jsonSatuSehat = [
                'active' => true,
                'address' => [[
                                  'city' => $organization->city->name,
                                  'country' => $organization->country->code,
                                  'extension' => [[
                                                      'extension' => [
                                                          [
                                                              'url' => 'province',
                                                              'valueCode' => $organization->province->area_code,
                                                          ],
                                                          [
                                                              'url' => 'city',
                                                              'valueCode' => str_replace('.', '', $organization->city->area_code)
                                                          ],
                                                          [
                                                              'url' => 'district',
                                                              'valueCode' => str_replace('.', '', $organization->district->area_code),
                                                          ],
                                                          [
                                                              'url' => 'village',
                                                              'valueCode' => str_replace('.', '', $organization->sub_district->area_code),
                                                          ],
                                                      ],
                                                      'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode'
                                                  ]],
                                  'line' => [$organization->address],
                                  'postalCode' => $organization->postal_code,
                                  'type' => 'both',
                                  'use' => 'work'
                              ]],
                'id' => $organization->organization_id,
                'identifier' => [
                    [
                        'system' => 'https://fhir.kemkes.go.id/id/org-number',
                        'value' => $organization->organization_id,
                    ],
                    [
                        'system' => 'https://fhir.kemkes.go.id/id/creator',
                        'value' => "10000004",
                    ]
                ],
                'name' => $organization->name,
                'partOf' => [
                    'reference' => 'Organization/'.$organization->organization_id,
                ],
                'resourceType' => 'Organization',
                'telecom' => [
                    [
                        'system' => 'phone',
                        'use' => 'work',
                        'value' => $organization->phone,
                    ],
                    [
                        'system' => 'url',
                        'use' => 'work',
                        'value' => $organization->url,
                    ],
                    [
                        'system' => 'email',
                        'use' => 'work',
                        'value' => $organization->email,
                    ],
                ],
                'type' => [
                    [
                        'coding' => [
                            [
                                'code' => '102',
                                'display' => 'Klinik',
                                'system' => 'https://terminology.kemkes.go.id/CodeSystem/organization-type',
                            ],
                        ]
                    ],
                ],
            ];

            $organization->json_satu_sehat = json_encode($jsonSatuSehat);
            $organization->save();

            satu_sehat('update','Organization',$organization->organization_id,$jsonSatuSehat);

            return redirect()->route('organization.index')->with('success', 'Organization updated successfully');
        }catch (\Exception $e){
            return redirect()->route('organization.index')->with('error', 'Organization updated failed');
        }
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

    /**
     * Function for upload avatar image
     *
     * @param string $folder
     * @param string $key
     * @param string $validation
     *
     * @return false|string|null
     */
    public function upload($folder = 'assets/media/logos', $key = 'logo', $validation = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|sometimes')
    {
        request()->validate([$key => $validation]);

        $file = null;
        if (request()->hasFile($key)) {
            $file = Storage::disk('public')->putFile($folder, request()->file($key), 'public');
        }

        return $file;
    }
}
