<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\PhysicalCategoriesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\PhysicalCategory;
    use App\Http\Requests\Klinik\StorePhysicalCategoryRequest;
    use App\Http\Requests\Klinik\UpdatePhysicalCategoryRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class PhysicalCategoriesController extends Controller
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
        public function index(PhysicalCategoriesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.phyisicalcategories.index');
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
            return view('pages.klinik.phyisicalcategories.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\StorePhysicalCategoryRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StorePhysicalCategoryRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    PhysicalCategory::create($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'PhysicalCategory has been created !!');
                return redirect()->route('phyisicalcategories.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Klinik\PhysicalCategory $phyisicalcategory
         *
         * @return \Illuminate\Http\Response
         */
        public function show(PhysicalCategory $phyisicalcategory)
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

            $phyisicalcategory = PhysicalCategory::find($id);
            return view('pages.klinik.phyisicalcategories.edit',compact('phyisicalcategory'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\UpdatePhysicalCategoryRequest $request
         * @param  \App\Models\Klinik\PhysicalCategory                     $phyisicalcategory
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdatePhysicalCategoryRequest $request, PhysicalCategory $phyisicalcategory)
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
                    $phyisicalcategory->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Physical Category has been updated !!');
                return redirect()->route('phyisicalcategories.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\PhysicalCategory $phyisicalcategory
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(PhysicalCategory $phyisicalcategory)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $phyisicalcategory->delete();

            session()->flash('success', 'Physical Category has been deleted !!');
            return redirect()->route('phyisicalcategories.index');
        }
    }
