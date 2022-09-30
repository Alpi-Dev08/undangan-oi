<?php

    namespace App\Http\Controllers\Master;

    use App\DataTables\Masters\EducationsDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Master\Education;
    use App\Http\Requests\Master\StoreEducationRequest;
    use App\Http\Requests\Master\UpdateEducationRequest;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class EducationsController extends Controller
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
        public function index(EducationsDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('masters.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.masters.educations.index');
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
            return view('pages.masters.educations.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\StoreEducationRequest  $request
         * @return \Illuminate\Http\Response
         */
        public function store(StoreEducationRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('masters.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if($validated){
                try{
                    Education::create(['name' => $request->name]);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Education has been created !!');
                return redirect()->route('educations.index');
            }

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Education  $education
         * @return \Illuminate\Http\Response
         */
        public function show(Education $education)
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

            $education = Education::find($id);
            return view('pages.masters.educations.edit',compact('education'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\UpdateEducationRequest  $request
         * @param  \App\Models\Education  $education
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateEducationRequest $request, Education $education)
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
                    $education->update($validated);
                }catch(Exception $e){
                    report($e);
                    return false;
                }

                session()->flash('success', 'Education has been updated !!');
                return redirect()->route('educations.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Models\Education  $education
         * @return \Illuminate\Http\Response
         */
        public function destroy(Education $education)
        {
            if (is_null($this->user) || !$this->user->can('masters.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $education->delete();

            session()->flash('success', 'Education has been deleted !!');
            return redirect()->route('educations.index');
        }
    }
