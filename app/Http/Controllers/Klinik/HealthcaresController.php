<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\HealthcaresDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\Healthcare;
    use App\Http\Requests\Klinik\StoreHealthcareRequest;
    use App\Http\Requests\Klinik\UpdateHealthcareRequest;
    use App\Models\Klinik\HealthcareCategory;
    use App\Models\Klinik\HealthcareType;
    use App\Models\Master\City;
    use App\Models\Master\Country;
    use App\Models\Master\District;
    use App\Models\Master\Province;
    use App\Models\Master\SubDistrict;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class HealthcaresController extends Controller
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
        public function index(HealthcaresDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.healthcares.index');
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

            $categories = HealthcareCategory::all();
            $types      = HealthcareType::all();
            $countries  = Country::all();
            $provinces  = Province::all();
            return view('pages.klinik.healthcares.create', compact('categories', 'types', 'countries', 'provinces'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\Klinik\StoreHealthcareRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreHealthcareRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                try {
                    Healthcare::create($validated);
                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'Healthcare has been created !!');
                return redirect()->route('healthcares.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\Klinik\Healthcare $healthcare
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Healthcare $healthcare)
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

            $healthcare   = Healthcare::find($id);
            $categories   = HealthcareCategory::all();
            $types        = HealthcareType::all();
            $countries    = Country::all();
            $provinces    = Province::where('country_id', $healthcare->country_id)->get();
            $cities       = City::where('province_id', $healthcare->province_id)->get();
            $districts    = District::where('city_id', $healthcare->city_id)->get();
            $subdistricts = SubDistrict::where('district_id', $healthcare->district_id)->get();
            return view('pages.klinik.healthcares.edit', compact('healthcare', 'categories', 'types', 'countries', 'provinces', 'cities', 'districts', 'subdistricts'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\Klinik\UpdateHealthcareRequest $request
         * @param \App\Models\Klinik\Healthcare                     $healthcare
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateHealthcareRequest $request, Healthcare $healthcare)
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
                    $healthcare->update($validated);
                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'Healthcare has been updated !!');
                return redirect()->route('healthcares.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\Healthcare $healthcare
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Healthcare $healthcare)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $healthcare->delete();

            session()->flash('success', 'Healthcare has been deleted !!');
            return redirect()->route('healthcares.index');
        }
    }
