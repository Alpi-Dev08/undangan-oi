<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\HealthcareTypesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\HealthcareType;
    use App\Http\Requests\Klinik\StoreHealthcareTypeRequest;
    use App\Http\Requests\Klinik\UpdateHealthcareTypeRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class HealthcareTypesController extends Controller
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
        public function index(HealthcareTypesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.healthcaretypes.index');
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
            return view('pages.klinik.healthcaretypes.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\StoreHealthcareTypeRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreHealthcareTypeRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    HealthcareType::create(['name' => $request->name]);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'HealthcareType has been created !!');
                return redirect()->route('healthcaretypes.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Klinik\HealthcareType $healthcaretype
         *
         * @return \Illuminate\Http\Response
         */
        public function show(HealthcareType $healthcaretype)
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

            $healthcaretype = HealthcareType::find($id);
            return view('pages.klinik.healthcaretypes.edit',compact('healthcaretype'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\UpdateHealthcareTypeRequest $request
         * @param  \App\Models\Klinik\HealthcareType                     $healthcaretype
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateHealthcareTypeRequest $request, HealthcareType $healthcaretype)
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
                    $healthcaretype->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'HealthcareType has been updated !!');
                return redirect()->route('healthcaretypes.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\HealthcareType $healthcaretype
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(HealthcareType $healthcaretype)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $healthcaretype->delete();

            session()->flash('success', 'HealthcareType has been deleted !!');
            return redirect()->route('healthcaretypes.index');
        }
    }
