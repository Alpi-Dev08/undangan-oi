<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\HealthcareCategoriesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\HealthcareCategory;
    use App\Http\Requests\Klinik\StoreHealthcareCategoryRequest;
    use App\Http\Requests\Klinik\UpdateHealthcareCategoryRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class HealthcareCategoriesController extends Controller
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
        public function index(HealthcareCategoriesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.healthcarecategories.index');
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
            return view('pages.klinik.healthcarecategories.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\StoreHealthcareCategoryRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreHealthcareCategoryRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    HealthcareCategory::create(['name' => $request->name]);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'HealthcareCategory has been created !!');
                return redirect()->route('healthcarecategories.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Klinik\HealthcareCategory $healthcarecategory
         *
         * @return \Illuminate\Http\Response
         */
        public function show(HealthcareCategory $healthcarecategory)
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
            if (is_null($this->user) || !$this->user->can('klinik.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
            }

            $healthcarecategory = HealthcareCategory::find($id);
            return view('pages.klinik.healthcarecategories.edit',compact('healthcarecategory'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\UpdateHealthcareCategoryRequest $request
         * @param  \App\Models\Klinik\HealthcareCategory                     $healthcarecategory
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateHealthcareCategoryRequest $request, HealthcareCategory $healthcarecategory)
        {
            if (is_null($this->user) || !$this->user->can('klinik.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                // Process Data
                try{
                    $healthcarecategory->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'HealthcareCategory has been updated !!');
                return redirect()->route('healthcarecategories.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\HealthcareCategory $healthcarecategory
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(HealthcareCategory $healthcarecategory)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $healthcarecategory->delete();

            session()->flash('success', 'HealthcareCategory has been deleted !!');
            return redirect()->route('healthcarecategories.index');
        }
    }
