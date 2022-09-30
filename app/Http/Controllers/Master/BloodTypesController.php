<?php

    namespace App\Http\Controllers\Master;

    use App\DataTables\Masters\BloodTypesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Master\BloodType;
    use App\Http\Requests\Master\StoreBloodTypeRequest;
    use App\Http\Requests\Master\UpdateBloodTypeRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class BloodTypesController extends Controller
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
        public function index(BloodTypesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('masters.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.masters.bloodtypes.index');
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            if (is_null($this->user) || !$this->user->can('masters.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }
            return view('pages.masters.bloodtypes.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\StoreBloodTypeRequest  $request
         * @return \Illuminate\Http\Response
         */
        public function store(StoreBloodTypeRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('masters.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    BloodType::create(['name' => $request->name]);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'BloodType has been created !!');
                return redirect()->route('bloodtypes.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\BloodType  $bloodtype
         * @return \Illuminate\Http\Response
         */
        public function show(BloodType $bloodtype)
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
            if (is_null($this->user) || !$this->user->can('masters.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
            }

            $bloodtype = BloodType::find($id);
            return view('pages.masters.bloodtypes.edit',compact('bloodtype'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\UpdateBloodTypeRequest  $request
         * @param  \App\Models\BloodType  $bloodtype
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateBloodTypeRequest $request, BloodType $bloodtype)
        {
            if (is_null($this->user) || !$this->user->can('masters.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                // Process Data
                try{
                    $bloodtype->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'BloodType has been updated !!');
                return redirect()->route('bloodtypes.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Models\BloodType  $bloodtype
         * @return \Illuminate\Http\Response
         */
        public function destroy(BloodType $bloodtype)
        {
            if (is_null($this->user) || !$this->user->can('masters.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $bloodtype->delete();

            session()->flash('success', 'BloodType has been deleted !!');
            return redirect()->route('bloodtypes.index');
        }
    }
