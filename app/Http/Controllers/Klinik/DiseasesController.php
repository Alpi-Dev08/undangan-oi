<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\DiseasesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\Disease;
    use App\Http\Requests\Klinik\StoreDiseaseRequest;
    use App\Http\Requests\Klinik\UpdateDiseaseRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class DiseasesController extends Controller
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
        public function index(DiseasesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.diseases.index');
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
            return view('pages.klinik.diseases.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\StoreDiseaseRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreDiseaseRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    Disease::create(['name' => $request->name]);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Disease has been created !!');
                return redirect()->route('diseases.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Klinik\Disease $disease
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Disease $disease)
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

            $disease = Disease::find($id);
            return view('pages.klinik.diseases.edit',compact('disease'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\UpdateDiseaseRequest $request
         * @param  \App\Models\Klinik\Disease                     $disease
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateDiseaseRequest $request, Disease $disease)
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
                    $disease->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Disease has been updated !!');
                return redirect()->route('diseases.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\Disease $disease
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Disease $disease)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $disease->delete();

            session()->flash('success', 'Disease has been deleted !!');
            return redirect()->route('diseases.index');
        }
    }
