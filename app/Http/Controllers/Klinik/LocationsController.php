<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\LocationsDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\Location;
    use App\Http\Requests\Klinik\StoreLocationRequest;
    use App\Http\Requests\Klinik\UpdateLocationRequest;
    use App\Models\Klinik\Organization;
    use App\Models\Master\City;
    use App\Models\Master\Country;
    use App\Models\Master\District;
    use App\Models\Master\Province;
    use App\Models\Master\SubDistrict;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Str;


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
            $countries  = Country::all();
            $provinces  = Province::all();
            return view('pages.klinik.locations.create', compact('organizations', 'countries', 'provinces'));
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
                    Location::create($validated);
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

            $location   = Location::find($id);
            $organizations   = Organization::all();
            $countries    = Country::all();
            $provinces    = Province::where('country_id', $location->country_id)->get();
            $cities       = City::where('province_id', $location->province_id)->get();
            $districts    = District::where('city_id', $location->city_id)->get();
            $subdistricts = SubDistrict::where('district_id', $location->district_id)->get();

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
        public function update(UpdateLocationRequest $request, Location $location)
        {
            if (is_null($this->user) || !$this->user->can('klinik.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                // Process Data
                try {
                    $location->update($validated);
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
