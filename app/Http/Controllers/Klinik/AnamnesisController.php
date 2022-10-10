<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\AnamnesisDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\Anamnesis;
    use App\Http\Requests\Klinik\StoreAnamnesisRequest;
    use App\Http\Requests\Klinik\UpdateAnamnesisRequest;
    use App\Models\Klinik\AnamnesisCategory;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Support\Facades\Auth;


    class AnamnesisController extends Controller
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
        public function index(AnamnesisDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.anamnesis.index');
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

            $categories = AnamnesisCategory::all();
            return view('pages.klinik.anamnesis.create', compact('categories'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\Klinik\StoreAnamnesisRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreAnamnesisRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                try {
                    Anamnesis::create($validated);
                } catch (Exception $e) {
                    report($e);
                    return redirect()->back()->with('error', $e->getMessage());
                    //return false;
                }

                session()->flash('success', 'Anamnesis has been created !!');
                return redirect()->route('anamnesis.index');
            }
            return redirect()->back()->withInput();
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\Klinik\Anamnesis $anamnesis
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Anamnesis $anamnesis)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  $id
         *
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            if (is_null($this->user) || !$this->user->can('klinik.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
            }

            $anamnesis = Anamnesis::find($id);
            $categories = AnamnesisCategory::all();
            return view('pages.klinik.anamnesis.edit', compact('anamnesis', 'categories'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\Klinik\UpdateAnamnesisRequest $request
         * @param \App\Models\Klinik\Anamnesis                     $anamnesis
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateAnamnesisRequest $request, Anamnesis $anamnesi)
        {
            if (is_null($this->user) || !$this->user->can('klinik.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                // Process Data
                try {
                    $anamnesi->update($validated);
                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'Anamnesis has been updated !!');
                return redirect()->route('anamnesis.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\Anamnesis $anamnesis
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Anamnesis $anamnesis)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $anamnesis->delete();

            session()->flash('success', 'Anamnesis has been deleted !!');
            return redirect()->route('anamnesis.index');
        }
    }
