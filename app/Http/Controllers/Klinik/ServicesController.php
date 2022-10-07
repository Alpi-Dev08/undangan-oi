<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\ServicesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\Country;
    use App\Models\Klinik\Service;
    use App\Http\Requests\Klinik\StoreServiceRequest;
    use App\Http\Requests\Klinik\UpdateServiceRequest;
    use App\Models\Klinik\ServiceCategory;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;


    class ServicesController extends Controller
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
        public function index(ServicesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.services.index');
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

            $service_category = ServiceCategory::all();
            return view('pages.klinik.services.create', compact('service_category'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\StoreServiceRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreServiceRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                try {
                    Service::create($validated);
                } catch (Exception $e) {
                    print_r($e);
                    return false;
                }

                session()->flash('success', 'Service has been created !!');
                return redirect()->route('services.index');
            }

            print_r($validated);
            exit;

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\Service $service
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Service $service)
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

            $service_category = ServiceCategory::all();
            $service = Service::find($id);
            return view('pages.klinik.services.edit', compact(['service_category','service']));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\UpdateServiceRequest $request
         * @param \App\Models\Service                     $service
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateServiceRequest $request, Service $service)
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
                    $service->update($validated);
                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'Service has been updated !!');
                return redirect()->route('services.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Service $service
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Service $service)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $service->delete();

            session()->flash('success', 'Service has been deleted !!');
            return redirect()->route('services.index');
        }

        public function getServiceByCountryId(Request $request){

            $services =  Service::select('id','name')->where('country_id',$request->country_id)->get();

            $data = [];
            foreach ($services as $service){
                $result = [
                    $service->id => $service->name
                ];

                $data[] = $result;
            }

            return response()->json($data);
        }
    }
