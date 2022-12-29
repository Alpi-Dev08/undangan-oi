<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\ExaminationsDataTable;
use App\DataTables\Klinik\LocationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreLocationRequest;
use App\Http\Requests\Klinik\UpdateLocationRequest;
use App\Models\Klinik\Location;
use App\Models\Master\City;
use App\Models\Master\Country;
use App\Models\Master\District;
use App\Models\Master\Province;
use App\Models\Master\SubDistrict;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LocationsDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.klinik.locations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        $countries = Country::all();
        $provinces = Province::all();

        return view('pages.klinik.locations.create', compact('countries', 'provinces', 'cities', 'districts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLocationRequest $request
     *
     * @return Response
     */
    public function store(StoreLocationRequest $request)
    {
        //\
    }

    /**
     * Display the specified resource.
     *
     * @param Location $location
     * @return Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Location $location
     * @return Response
     */
    public function edit(Location $location)
    {
        $countries    = $location->country;
        $provinces    = $location->country_id != null ? Province::where('country_id', $location->country_id)->get() : Province::all();
        $cities       = $location->province_id != null ? City::where('province_id', $location->province_id)->get() : null;
        $districts    = $location->city_id != null ? District::where('city_id', $location->city_id)->get() : null;
        $subdistricts = $location->district_id != null ? SubDistrict::where('district_id', $location->district_id)->get() : null;

        return view('klinik.location.settings.settings', compact('location', 'countries', 'provinces', 'cities', 'districts', 'subdistricts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLocationRequest $request
     * @param Location $location
     *
     * @return Response
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        try {
            $location->update($request->validated());
            if ($request->hasFile('logo')) {
                $path               = $request->file('logo')->store('images/logos', 'public');
                $location->logo = $path;
                $location->save();
            }
            $jsonSatuSehat = [
                'active'       => true,
                'address'      => [[
                    'city'       => $location->city->name,
                    'country'    => $location->country->code,
                    'extension'  => [[
                        'extension' => [
                            [
                                'url'       => 'province',
                                'valueCode' => $location->province->area_code,
                            ],
                            [
                                'url'       => 'city',
                                'valueCode' => str_replace('.', '', $location->city->area_code)
                            ],
                            [
                                'url'       => 'district',
                                'valueCode' => str_replace('.', '', $location->district->area_code),
                            ],
                            [
                                'url'       => 'village',
                                'valueCode' => str_replace('.', '', $location->sub_district->area_code),
                            ],
                        ],
                        'url'       => 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode'
                    ]],
                    'line'       => [$location->address],
                    'postalCode' => $location->postal_code,
                    'type'       => 'both',
                    'use'        => 'work'
                ]],
                'id'           => $location->location_id,
                'identifier'   => [
                    [
                        'system' => 'http://sys-ids.kemkes.go.id/location/1000001',
                        'value'  => $location->code,
                    ]
                ],
                'name'         => $location->name,
                'id' => $location->uuid,
                'description'  => $location->description,
                'managingOrganization'       => [
                    'reference' => 'Organization/' . $location->organization->organization_id,
                ],
                'mode' => 'instance',
                'resourceType' => 'Location',
                'telecom'      => [
                    [
                        'system' => 'phone',
                        'use'    => 'work',
                        'value'  => $location->phone,
                    ],
                    [
                        'system' => 'url',
                        'use'    => 'work',
                        'value'  => $location->url,
                    ],
                    [
                        'system' => 'email',
                        'use'    => 'work',
                        'value'  => $location->email,
                    ],
                ],
                'type'         => [
                    [
                        'coding' => [
                            [
                                'code'    => '102',
                                'display' => 'Klinik',
                                'system'  => 'https://terminology.kemkes.go.id/CodeSystem/location-type',
                            ],
                        ]
                    ],
                ],
            ];

            $location->json_satu_sehat = json_encode($jsonSatuSehat);
            $location->save();

            satu_sehat('update', 'Location', $location->location_id, $jsonSatuSehat);

            return redirect()->route('location.index')->with('success', 'Location updated successfully');
        } catch (Exception $e) {
            return redirect()->route('location.index')->with('error', 'Location updated failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Location $location
     * @return Response
     */
    public function destroy(Location $location)
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
