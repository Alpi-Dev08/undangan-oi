<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\SpecialitiesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\Speciality;
    use App\Http\Requests\Klinik\StoreSpecialityRequest;
    use App\Http\Requests\Klinik\UpdateSpecialityRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class SpecialitiesController extends Controller
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
        public function index(SpecialitiesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.specialities.index');
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
            return view('pages.klinik.specialities.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\StoreSpecialityRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreSpecialityRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    Speciality::create(['name' => $request->name]);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Speciality has been created !!');
                return redirect()->route('specialities.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Klinik\Speciality $speciality
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Speciality $speciality)
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

            $speciality = Speciality::find($id);
            return view('pages.klinik.specialities.edit',compact('speciality'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\UpdateSpecialityRequest $request
         * @param  \App\Models\Klinik\Speciality                     $speciality
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateSpecialityRequest $request, Speciality $speciality)
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
                    $speciality->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Speciality has been updated !!');
                return redirect()->route('specialities.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\Speciality $speciality
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Speciality $speciality)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $speciality->delete();

            session()->flash('success', 'Speciality has been deleted !!');
            return redirect()->route('specialities.index');
        }
    }
