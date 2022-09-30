<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\HealthProfesionalTypesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\HealthProfesionalType;
    use App\Http\Requests\Klinik\StoreHealthProfesionalTypeRequest;
    use App\Http\Requests\Klinik\UpdateHealthProfesionalTypeRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class HealthProfesionalTypesController extends Controller
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
        public function index(HealthProfesionalTypesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.healthprofesionaltypes.index');
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
            return view('pages.klinik.healthprofesionaltypes.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\StoreHealthProfesionalTypeRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreHealthProfesionalTypeRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    HealthProfesionalType::create(['name' => $request->name]);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Health Profesional Type has been created !!');
                return redirect()->route('healthprofesionaltypes.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Klinik\HealthProfesionalType $healthprofesionaltype
         *
         * @return \Illuminate\Http\Response
         */
        public function show(HealthProfesionalType $healthprofesionaltype)
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

            $healthprofesionaltype = HealthProfesionalType::find($id);
            return view('pages.klinik.healthprofesionaltypes.edit',compact('healthprofesionaltype'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\UpdateHealthProfesionalTypeRequest $request
         * @param  \App\Models\Klinik\HealthProfesionalType                     $healthprofesionaltype
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateHealthProfesionalTypeRequest $request, HealthProfesionalType $healthprofesionaltype)
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
                    $healthprofesionaltype->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'HealthProfesionalType has been updated !!');
                return redirect()->route('healthprofesionaltypes.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\HealthProfesionalType $healthprofesionaltype
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(HealthProfesionalType $healthprofesionaltype)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $healthprofesionaltype->delete();

            session()->flash('success', 'HealthProfesionalType has been deleted !!');
            return redirect()->route('healthprofesionaltypes.index');
        }
    }
