<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\PhysicalsDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\Physical;
    use App\Http\Requests\Klinik\StorePhysicalRequest;
    use App\Http\Requests\Klinik\UpdatePhysicalRequest;
    use App\Models\Klinik\PhysicalCategory;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class PhysicalsController extends Controller
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
        public function index(PhysicalsDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.physicals.index');
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

            $categories = PhysicalCategory::all();
            return view('pages.klinik.physicals.create', compact('categories'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\StorePhysicalRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StorePhysicalRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    Physical::create($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Physical has been created !!');
                return redirect()->route('physicals.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Klinik\Physical $physical
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Physical $physical)
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

            $physical = Physical::find($id);
            $categories = PhysicalCategory::all();
            return view('pages.klinik.physicals.edit',compact('physical','categories'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\UpdatePhysicalRequest $request
         * @param  \App\Models\Klinik\Physical                     $physical
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdatePhysicalRequest $request, Physical $physical)
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
                    $physical->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Physical has been updated !!');
                return redirect()->route('physicals.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\Physical $physical
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Physical $physical)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $physical->delete();

            session()->flash('success', 'Physical has been deleted !!');
            return redirect()->route('physicals.index');
        }
    }
