<?php

    namespace App\Http\Controllers\Master;

    use App\DataTables\Masters\ProvincesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Master\Country;
    use App\Models\Master\Province;
    use App\Http\Requests\Master\StoreProvinceRequest;
    use App\Http\Requests\Master\UpdateProvinceRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;


    class ProvincesController extends Controller
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
        public function index(ProvincesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('masters.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.masters.provinces.index');
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
            return view('pages.masters.provinces.create', compact('country'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\StoreProvinceRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreProvinceRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('masters.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                try {
                    Province::create($validated);
                } catch (Exception $e) {
                    print_r($e);
                    return false;
                }

                session()->flash('success', 'Province has been created !!');
                return redirect()->route('provinces.index');
            }

            print_r($validated);
            exit;

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\Province $province
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Province $province)
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
            $province = Province::find($id);
            return view('pages.masters.provinces.edit', compact(['country','province']));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\UpdateProvinceRequest $request
         * @param \App\Models\Province                     $province
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateProvinceRequest $request, Province $province)
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
                    $province->update($validated);
                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'Province has been updated !!');
                return redirect()->route('provinces.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Province $province
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Province $province)
        {
            if (is_null($this->user) || !$this->user->can('masters.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $province->delete();

            session()->flash('success', 'Province has been deleted !!');
            return redirect()->route('provinces.index');
        }

        public function getProvinceByCountryId(Request $request){

            $provinces =  Province::select('id','name')->where('country_id',$request->country_id)->get();

            $data = [];
            foreach ($provinces as $province){
                $result = [
                    $province->id => $province->name
                ];

                $data[] = $result;
            }

            return response()->json($data);
        }
    }
