<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\LocationsDataTable;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Klinik\StoreLocationRequest;
    use App\Models\Klinik\Location;
    use App\Models\Klinik\Organization;
    use App\Models\Master\City;
    use App\Models\Master\Country;
    use App\Models\Master\District;
    use App\Models\Master\Province;
    use App\Models\Master\SubDistrict;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Satusehat\Integration\FHIR\Location as FHIRLocation;
    use Str;

    // Replace the manual JSON construction with the FHIR Location class


    class LocationsController extends Controller
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
        public function index(LocationsDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.locations.index');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\Klinik\StoreLocationRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreLocationRequest $request)
        {
            //dd($request->all());
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                try {
                    $validated['uuid'] = Str::uuid()->toString();
                    $location          = Location::create($validated);


                    // Replace the $jsonSatuSehat array construction with:
                    $fhirLocation = new FHIRLocation();

                    // Set basic information
                    $fhirLocation->addIdentifier($location->code);
                    $fhirLocation->setName($location->name, $location->description);
                    $fhirLocation->setStatus($location->status == '1' ? 'active' : 'inactive');

                    // Set contact information
                    $fhirLocation->addPhone($location->phone);
                    $fhirLocation->addEmail($location->email);
                    // Note: The FHIR class doesn't have addFax method, you may need to add it manually or extend the class

                    // Set address
                    $fhirLocation->setAddress(
                        $location->address,
                        $location->postal_code,
                        $location->city->name,
                        $location->sub_district->area_code
                    );

                    // Set managing organization
                    $fhirLocation->setManagingOrganization($location->organization->organization_id);

                    // Set physical type (defaults to 'ro' - Room)
                    $fhirLocation->addPhysicalType('ro');

                    // Get the JSON
                    $jsonSatuSehat = json_decode($fhirLocation->json(), true);

                    // If you need to add fax (since the FHIR class doesn't support it), add it manually:
                    if ($location->fax) {
                        $jsonSatuSehat['telecom'][] = [
                            'system' => 'fax',
                            'use'    => 'work',
                            'value'  => $location->fax,
                        ];
                    }

                    //$location->json_satu_sehat = json_encode($jsonSatuSehat);
                    $location->save();

                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'Location has been created !!');
                return redirect()->route('locations.index');
            }

            return false;
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            $organizations = Organization::all();
            $countries     = Country::all();
            $provinces     = Province::all();
            return view('pages.klinik.locations.create', compact('organizations', 'countries', 'provinces'));
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\Klinik\Location $location
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Location $location)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  $id
         *
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            if (is_null($this->user) || !$this->user->can('klinik.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
            }

            $location      = Location::find($id);
            $organizations = Organization::all();
            $countries     = Country::all();
            $provinces     = Province::where('country_id', $location->country_id)->get();
            $cities        = City::where('province_id', $location->province_id)->get();
            $districts     = District::where('city_id', $location->city_id)->get();
            $subdistricts  = SubDistrict::where('district_id', $location->district_id)->get();

            return view('pages.klinik.locations.edit', compact('location', 'organizations', 'countries', 'provinces', 'cities', 'districts', 'subdistricts'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\Klinik\UpdateLocationRequest $request
         * @param \App\Models\Klinik\Location                     $location
         *
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Location $location)
        {
            if (is_null($this->user) || !$this->user->can('klinik.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
            }

            // Validation Data
            $validated = $request->all();

            // Process Data
            if ($validated) {
                // Process Data
                try {
                    $location->update($validated);

                    // Replace the manual JSON construction with FHIR Location class
                    $fhirLocation = new FHIRLocation();

                    // Set basic information
                    $fhirLocation->addIdentifier($location->code);
                    $fhirLocation->setName($location->name, $location->description);
                    $fhirLocation->setStatus($location->status == '1' ? 'active' : 'inactive');

                    // Set contact information
                    $fhirLocation->addPhone($location->phone);
                    $fhirLocation->addEmail($location->email);

                    // Set address
                    $fhirLocation->setAddress(
                        $location->address,
                        $location->postal_code,
                        $location->city->name,
                        $location->sub_district->area_code
                    );

                    // Set managing organization
                    $fhirLocation->setManagingOrganization($location->organization->organization_id);

                    // Set physical type (defaults to 'ro' - Room)
                    $fhirLocation->addPhysicalType('ro');

                    // Get the JSON and decode to array
                    $jsonSatuSehat = json_decode($fhirLocation->json(), true);

                    // Add the location ID for update operation
                    $jsonSatuSehat['id'] = $location->location_id;

                    // Add fax manually since FHIR class doesn't support it
                    if ($location->fax) {
                        $jsonSatuSehat['telecom'][] = [
                            'system' => 'fax',
                            'use'    => 'work',
                            'value'  => $location->fax,
                        ];
                    }

                    //$location->json_satu_sehat = json_encode($jsonSatuSehat);
                    $location->update();


                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'Location has been updated !!');
                return redirect()->route('locations.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\Location $location
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Location $location)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $location->delete();

            session()->flash('success', 'Location has been deleted !!');
            return redirect()->route('locations.index');
        }
    }
