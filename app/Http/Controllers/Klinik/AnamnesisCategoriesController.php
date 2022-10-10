<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\AnamnesisCategoriesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\AnamnesisCategory;
    use App\Http\Requests\Klinik\StoreAnamnesisCategoryRequest;
    use App\Http\Requests\Klinik\UpdateAnamnesisCategoryRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class AnamnesisCategoriesController extends Controller
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
        public function index(AnamnesisCategoriesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.anamnesiscategories.index');
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
            return view('pages.klinik.anamnesiscategories.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\StoreAnamnesisCategoryRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreAnamnesisCategoryRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    AnamnesisCategory::create($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'AnamnesisCategory has been created !!');
                return redirect()->route('anamnesiscategories.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Klinik\AnamnesisCategory $anamnesiscategory
         *
         * @return \Illuminate\Http\Response
         */
        public function show(AnamnesisCategory $anamnesiscategory)
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

            $anamnesiscategory = AnamnesisCategory::find($id);
            return view('pages.klinik.anamnesiscategories.edit',compact('anamnesiscategory'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\UpdateAnamnesisCategoryRequest $request
         * @param  \App\Models\Klinik\AnamnesisCategory                     $anamnesiscategory
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateAnamnesisCategoryRequest $request, AnamnesisCategory $anamnesiscategory)
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
                    $anamnesiscategory->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Anamnesis Category has been updated !!');
                return redirect()->route('anamnesiscategories.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\AnamnesisCategory $anamnesiscategory
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(AnamnesisCategory $anamnesiscategory)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $anamnesiscategory->delete();

            session()->flash('success', 'Anamnesis Category has been deleted !!');
            return redirect()->route('anamnesiscategories.index');
        }
    }
