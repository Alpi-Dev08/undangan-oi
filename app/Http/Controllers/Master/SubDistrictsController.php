<?php

    namespace App\Http\Controllers\Master;

    use App\DataTables\Masters\SubDistrictsDataTable;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Master\StoreSubDistrictRequest;
    use App\Http\Requests\Master\UpdateSubDistrictRequest;
    use App\Models\Master\Country;
    use App\Models\Master\Province;
    use App\Models\Master\City;
    use App\Models\Master\District;
    use App\Models\Master\SubDistrict;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;


    class SubDistrictsController extends Controller
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
        public function index(SubDistrictsDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('masters.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.masters.subdistricts.index');
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
            return view('pages.masters.subdistricts.create', compact('country'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\StoreSubDistrictRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreSubDistrictRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('masters.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                try {
                    SubDistrict::create($validated);
                } catch (Exception $e) {
                    print_r($e);
                    return false;
                }

                session()->flash('success', 'Sub District has been created !!');
                return redirect()->route('subdistricts.index');
            }

            print_r($validated);
            exit;

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\SubDistrict $subdistrict
         *
         * @return \Illuminate\Http\Response
         */
        public function show(SubDistrict $subdistrict)
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
            $subdistrict = SubDistrict::find($id);
            $province = Province::where('country_id', $subdistrict->country_id)->get();
            $city     = City::where('province_id', $subdistrict->province_id)->get();
            $district = District::where('city_id',$subdistrict->city_id)->get();

            return view('pages.masters.subdistricts.edit', compact(['city', 'country', 'province', 'subdistrict','district']));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\UpdateSubDistrictRequest $request
         * @param \App\Models\SubDistrict $subdistrict
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateSubDistrictRequest $request, SubDistrict $subdistrict)
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
                    $subdistrict->update($validated);
                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'Sub District has been updated !!');
                return redirect()->route('subdistricts.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\SubDistrict $subdistrict
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(SubDistrict $subdistrict)
        {
            if (is_null($this->user) || !$this->user->can('masters.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $subdistrict->delete();

            session()->flash('success', 'Sub District has been deleted !!');
            return redirect()->route('subdistricts.index');
        }

        public function getSubDistrictByCityId(Request $request)
        {

            $subdistricts = SubDistrict::select('id', 'name')->where('district_id', $request->district_id)->get();

            $data = [];
            foreach ($subdistricts as $subdistrict) {
                $result = [
                    $subdistrict->id => $subdistrict->name
                ];

                $data[] = $result;
            }

            return response()->json($data);
        }
    }
