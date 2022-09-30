<?php

    namespace App\Http\Controllers\Master;

    use App\DataTables\Masters\CitiesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Master\Country;
    use App\Models\Master\Province;
    use App\Models\Master\City;
    use App\Http\Requests\Master\StoreCityRequest;
    use App\Http\Requests\Master\UpdateCityRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;


    class CitiesController extends Controller
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
        public function index(CitiesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('masters.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.masters.cities.index');
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
            return view('pages.masters.cities.create', compact('country'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\StoreCityRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreCityRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('masters.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                try {
                    City::create($validated);
                } catch (Exception $e) {
                    print_r($e);
                    return false;
                }

                session()->flash('success', 'City has been created !!');
                return redirect()->route('cities.index');
            }

            print_r($validated);
            exit;

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\City $city
         *
         * @return \Illuminate\Http\Response
         */
        public function show(City $city)
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

            $country = Country::all();
            $city = City::find($id);
            $province = Province::where('country_id',$city->country_id)->get();
            return view('pages.masters.cities.edit', compact(['city','country','province']));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\UpdateCityRequest $request
         * @param \App\Models\City                     $city
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateCityRequest $request, City $city)
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
                    $city->update($validated);
                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'City has been updated !!');
                return redirect()->route('cities.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\City $city
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(City $city)
        {
            if (is_null($this->user) || !$this->user->can('masters.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $city->delete();

            session()->flash('success', 'City has been deleted !!');
            return redirect()->route('cities.index');
        }

        public function getCityByProvinceId(Request $request){

            $cities =  City::select('id','name')->where('province_id',$request->province_id)->get();

            $data = [];
            foreach ($cities as $city){
                $result = [
                    $city->id => $city->name
                ];

                $data[] = $result;
            }

            return response()->json($data);
        }
    }
