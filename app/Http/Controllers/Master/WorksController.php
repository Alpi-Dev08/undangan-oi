<?php

    namespace App\Http\Controllers\Master;

    use App\DataTables\Masters\WorksDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Master\Work;
    use App\Http\Requests\Master\StoreWorkRequest;
    use App\Http\Requests\Master\UpdateWorkRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class WorksController extends Controller
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
        public function index(WorksDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('masters.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.masters.works.index');
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
            return view('pages.masters.works.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\StoreWorkRequest  $request
         * @return \Illuminate\Http\Response
         */
        public function store(StoreWorkRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('masters.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    Work::create(['name' => $request->name]);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Work has been created !!');
                return redirect()->route('works.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Work  $work
         * @return \Illuminate\Http\Response
         */
        public function show(Work $work)
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

            $work = Work::find($id);
            return view('pages.masters.works.edit',compact('work'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\UpdateWorkRequest  $request
         * @param  \App\Models\Work  $work
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateWorkRequest $request, Work $work)
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
                    $work->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Work has been updated !!');
                return redirect()->route('works.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Models\Work  $work
         * @return \Illuminate\Http\Response
         */
        public function destroy(Work $work)
        {
            if (is_null($this->user) || !$this->user->can('masters.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $work->delete();

            session()->flash('success', 'Work has been deleted !!');
            return redirect()->route('works.index');
        }
    }
