<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\PackagesDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\Package;
    use App\Http\Requests\Klinik\StorePackageRequest;
    use App\Http\Requests\Klinik\UpdatePackageRequest;
    use App\Models\Klinik\PackageDetail;
    use App\Models\Klinik\Service;
    use App\Models\Klinik\ServiceCategory;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;


    class PackagesController extends Controller
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
        public function index(PackagesDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.packages.index');
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

            $service_categories = ServiceCategory::all();
            return view('pages.klinik.packages.create', compact('service_categories'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\StorePackageRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StorePackageRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            // Validation Data
            $validated = $request->validated();

            // Process Data
            if ($validated) {
                try {
                    $package = Package::create($validated);

                    PackageDetail::where('package_id', $package->id)->delete();
                    foreach ($request->service_id as $service_id) {
                        $service = Service::find($service_id);

                        PackageDetail::create([
                            'package_id' => $package->id,
                            'service_id' => $service->id
                        ]);
                    }

                } catch (Exception $e) {
                    print_r($e);
                    return false;
                }

                session()->flash('success', 'Package has been created !!');
                return redirect()->route('packages.index');
            }

            print_r($validated);
            exit;

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\Package $package
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Package $package)
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

            $package = Package::find($id);
            $packageDetail = PackageDetail::where('package_id', $id)->pluck('service_id')->toArray();
            $service_categories = ServiceCategory::all();

            return view('pages.klinik.packages.edit', compact(['package', 'packageDetail', 'service_categories']));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\UpdatePackageRequest $request
         * @param \App\Models\Package                     $package
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdatePackageRequest $request, Package $package)
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
                    $package->update($validated);

                    PackageDetail::where('package_id',$package->id)->delete();
                    foreach ($request->service_id as $service_id) {
                        $service = Service::find($service_id);

                        PackageDetail::create([
                            'package_id' => $package->id,
                            'service_id' => $service->id
                        ]);
                    }
                } catch (Exception $e) {
                    report($e);
                    return false;
                }

                session()->flash('success', 'Package has been updated !!');
                return redirect()->route('packages.index');
            }

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Package $package
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Package $package)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $package->delete();

            session()->flash('success', 'Package has been deleted !!');
            return redirect()->route('packages.index');
        }
    }
