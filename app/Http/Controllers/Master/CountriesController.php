<?php

    namespace App\Http\Controllers\Master;

    use App\DataTables\Masters\CountriesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Master\Country;
    use App\Http\Requests\Master\StoreCountryRequest;
    use App\Http\Requests\Master\UpdateCountryRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class CountriesController extends Controller
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
        public function index(CountriesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('masters.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.masters.countries.index');
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
            return view('pages.masters.countries.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\StoreCountryRequest  $request
         * @return \Illuminate\Http\Response
         */
        public function store(StoreCountryRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('masters.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    Country::create(['name' => $request->name]);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Country has been created !!');
                return redirect()->route('countries.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Master\Country  $country
         * @return \Illuminate\Http\Response
         */
        public function show(Country $country)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            if (is_null($this->user) || !$this->user->can('masters.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
            }

            $country = Country::find($id);
            return view('pages.masters.countries.edit',compact('country'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\UpdateCountryRequest  $request
         * @param  \App\Models\Master\Country  $country
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateCountryRequest $request, Country $country)
        {
            if (is_null($this->user) || !$this->user->can('masters.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                // Process Data
                try{
                    $country->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Country has been updated !!');
                return redirect()->route('countries.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Models\Master\Country  $country
         * @return \Illuminate\Http\Response
         */
        public function destroy(Country $country)
        {
            if (is_null($this->user) || !$this->user->can('masters.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $country->delete();

            session()->flash('success', 'Country has been deleted !!');
            return redirect()->route('countries.index');
        }
    }
