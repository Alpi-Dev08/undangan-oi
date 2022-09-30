<?php

    namespace App\Http\Controllers\Master;

    use App\DataTables\Masters\DistrictsDataTable;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Master\StoreDistrictRequest;
    use App\Http\Requests\Master\UpdateDistrictRequest;
    use App\Models\Master\Country;
    use App\Models\Master\Province;
    use App\Models\Master\City;
    use App\Models\Master\District;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;


    class DistrictsController extends Controller
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
        public function index(DistrictsDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('masters.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.masters.districts.index');
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            if (is_null($this->user) || !$this->user->can('masters.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            $country = Country::all();
            return view('pages.masters.districts.create', compact('country'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\StoreDistrictRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreDistrictRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('masters.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                try {
                    District::create($validated);
                } catch (Exception $e) {
                    print_r($e);
                    return false;
                }

                session()->flash('success', 'District has been created !!');
                return redirect()->route('districts.index');
            }

            print_r($validated);
            exit;

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\District $district
         *
         * @return \Illuminate\Http\Response
         */
        public function show(District $district)
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
            if (is_null($this->user) || !$this->user->can('masters.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
            }

            $country  = Country::all();
            $district = District::find($id);
            $province = Province::where('country_id', $district->country_id)->get();
            $city     = City::where('province_id', $district->province_id)->get();
            return view('pages.masters.districts.edit', compact(['city', 'country', 'province', 'district']));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\UpdateSubDistrictRequest $request
         * @param \App\Models\District                     $district
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateDistrictRequest $request, District $district)
        {
            if (is_null($this->user) || !$this->user->can('masters.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                // Process Data
                try {
                    $district->update($validated);
                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'District has been updated !!');
                return redirect()->route('districts.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\District $district
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(District $district)
        {
            if (is_null($this->user) || !$this->user->can('masters.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $district->delete();

            session()->flash('success', 'District has been deleted !!');
            return redirect()->route('districts.index');
        }

        public function getDistrictByCityId(Request $request)
        {

            $districts = District::select('id', 'name')->where('city_id', $request->city_id)->get();

            $data = [];
            foreach ($districts as $district) {
                $result = [
                    $district->id => $district->name
                ];

                $data[] = $result;
            }

            return response()->json($data);
        }
    }
