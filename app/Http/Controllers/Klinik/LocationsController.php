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
    use Exception;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;
    use Illuminate\View\View;
    use Satusehat\Integration\FHIR\Location as FHIRLocation;

    class LocationsController extends Controller
    {
        protected $user;

        public function __construct()
        {
            $this->middleware(function ($request, $next) {
                $this->user = Auth::guard('web')->user();
                return $next($request);
            });
        }

        /**
         * Display a listing of the resource.
         */
        public function index(LocationsDataTable $dataTable)
        : View
        {
            $this->checkAuthorization('klinik.read', 'Unauthorized to view location data');
            return $dataTable->render('pages.klinik.locations.index');
        }

        /**
         * Check if user is authorized to perform an action
         *
         * @param string $permission Permission to check
         * @param string $message    Error message to display
         *
         * @return void
         */
        private function checkAuthorization(string $permission, string $message)
        : void
        {
            if (is_null($this->user) || !$this->user->can($permission)) {
                abort(403, $message);
            }
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(StoreLocationRequest $request)
        : RedirectResponse
        {
            $this->checkAuthorization('klinik.create', 'Unauthorized to create location data');

            // Validation Data
            $validated = $request->validated();

            try {
                $validated['uuid'] = Str::uuid()->toString();
                $location          = Location::create($validated);

                // Generate FHIR Location JSON
                $jsonSatuSehat = $this->generateFhirLocationJson($location);

                // Optionally save FHIR JSON to the location
                // $location->json_satu_sehat = json_encode($jsonSatuSehat);
                $location->save();

                session()->flash('success', 'Location has been created successfully!');
                return redirect()->route('locations.index');
            } catch (Exception $e) {
                report($e);
                session()->flash('error', 'Failed to create location: ' . $e->getMessage());
                return back()->withInput();
            }
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        : View
        {
            $this->checkAuthorization('klinik.create', 'Unauthorized to create location data');

            $organizations = Organization::all();
            $countries     = Country::all();
            $provinces     = Province::all();

            return view('pages.klinik.locations.create', compact('organizations', 'countries', 'provinces'));
        }

        /**
         * Generate FHIR Location JSON
         *
         * @param Location $location Location model
         * @param bool     $isUpdate Whether this is for an update operation
         *
         * @return array FHIR Location JSON as array
         */
        private function generateFhirLocationJson(Location $location, bool $isUpdate = false)
        : array
        {
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

            // Set managing organization=≠
            $fhirLocation->setManagingOrganization($location->organization->organization_id);

            // Set physical type (defaults to 'ro' - Room)
            $fhirLocation->addPhysicalType('ro');

            // Get the JSON and decode to array
            $jsonSatuSehat = json_decode($fhirLocation->json(), true);

            // Add the location ID for update operation
            if ($isUpdate && $location->location_id) {
                $jsonSatuSehat['id'] = $location->location_id;
                $fhirLocation->put($location->location_id);
            } else {
                $fhirLocation->post();
            }


            // Add fax manually since FHIR class doesn't support it
            if ($location->fax) {
                $jsonSatuSehat['telecom'][] = [
                    'system' => 'fax',
                    'use'    => 'work',
                    'value'  => $location->fax,
                ];
            }

            return $jsonSatuSehat;
        }

        /**
         * Display the specified resource.
         */
        public function show(Location $location)
        : View
        {
            $this->checkAuthorization('klinik.read', 'Unauthorized to view location data');
            return view('pages.klinik.locations.show', compact('location'));
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id)
        : View
        {
            $this->checkAuthorization('klinik.update', 'Unauthorized to edit location data');

            $location      = Location::findOrFail($id);
            $organizations = Organization::all();
            $countries     = Country::all();
            $provinces     = Province::where('country_id', $location->country_id)->get();
            $cities        = City::where('province_id', $location->province_id)->get();
            $districts     = District::where('city_id', $location->city_id)->get();
            $subdistricts  = SubDistrict::where('district_id', $location->district_id)->get();

            return view('pages.klinik.locations.edit', compact(
                'location',
                'organizations',
                'countries',
                'provinces',
                'cities',
                'districts',
                'subdistricts'
            ));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(StoreLocationRequest $request, Location $location)
        : RedirectResponse
        {
            $this->checkAuthorization('klinik.update', 'Unauthorized to update location data');

            // Validation Data
            $validated = $request->validated();

            try {
                $location->update($validated);

                // Generate FHIR Location JSON with ID for update
                $jsonSatuSehat = $this->generateFhirLocationJson($location, true);

                // Optionally save FHIR JSON to the location
                // $location->json_satu_sehat = json_encode($jsonSatuSehat);
                $location->save();

                session()->flash('success', 'Location has been updated successfully!');
                return redirect()->route('locations.index');
            } catch (Exception $e) {
                report($e);
                session()->flash('error', 'Failed to update location: ' . $e->getMessage());
                return back()->withInput();
            }
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Location $location)
        : RedirectResponse
        {
            $this->checkAuthorization('klinik.delete', 'Unauthorized to delete location data');

            try {
                $location->delete();
                session()->flash('success', 'Location has been deleted successfully!');
            } catch (Exception $e) {
                report($e);
                session()->flash('error', 'Failed to delete location: ' . $e->getMessage());
            }

            return redirect()->route('locations.index');
        }
    }
