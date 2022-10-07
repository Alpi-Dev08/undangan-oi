<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\ServiceCategoriesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\ServiceCategory;
    use App\Http\Requests\Klinik\StoreServiceCategoryRequest;
    use App\Http\Requests\Klinik\UpdateServiceCategoryRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class ServiceCategoriesController extends Controller
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
        public function index(ServiceCategoriesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.servicecategories.index');
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
            return view('pages.klinik.servicecategories.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\StoreServiceCategoryRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreServiceCategoryRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    ServiceCategory::create(['name' => $request->name]);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Service Category has been created !!');
                return redirect()->route('servicecategories.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Klinik\ServiceCategory $servicecategory
         *
         * @return \Illuminate\Http\Response
         */
        public function show(ServiceCategory $servicecategory)
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

            $servicecategory = ServiceCategory::find($id);
            return view('pages.klinik.servicecategories.edit',compact('servicecategory'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\UpdateServiceCategoryRequest $request
         * @param  \App\Models\Klinik\ServiceCategory                     $servicecategory
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateServiceCategoryRequest $request, ServiceCategory $servicecategory)
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
                    $servicecategory->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Service Category has been updated !!');
                return redirect()->route('servicecategories.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\ServiceCategory $servicecategory
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(ServiceCategory $servicecategory)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $servicecategory->delete();

            session()->flash('success', 'Service Category has been deleted !!');
            return redirect()->route('servicecategories.index');
        }
    }
