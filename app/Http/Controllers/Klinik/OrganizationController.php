<?php

    namespace App\Http\Controllers\Klinik;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Klinik\StoreOrganizationRequest;
    use App\Http\Requests\Klinik\UpdateOrganizationRequest;
    use App\Models\Klinik\Organization;
    use App\Models\Master\City;
    use App\Models\Master\Country;
    use App\Models\Master\District;
    use App\Models\Master\Province;
    use App\Models\Master\SubDistrict;
    use Illuminate\Support\Facades\Storage;
    use Satusehat\Integration\FHIR\Organization as SatuSehatOrganization;
use Satusehat\Integration\Models\SatusehatLog;

    class OrganizationController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $organization = Organization::find(1);
            $user         = auth()->user();
            $info         = $user->info;

            $countries    = Country::all();
            $provinces    = $organization->country_id != null ? Province::where('country_id', $organization->country_id)->get() : Province::all();
            $cities       = $organization->province_id != null ? City::where('province_id', $organization->province_id)->get() : null;
            $districts    = $organization->city_id != null ? District::where('city_id', $organization->city_id)->get() : null;
            $subdistricts = $organization->district_id != null ? SubDistrict::where('district_id', $organization->district_id)->get() : null;
            //generateToken();
            return view('pages.klinik.organization.overview', compact('organization', 'user', 'info', 'countries', 'provinces', 'cities', 'districts', 'subdistricts'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \App\Http\Requests\Klinik\StoreOrganizationRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(StoreOrganizationRequest $request)
        {
            //\
        }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\Klinik\Organization $organization
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Organization $organization)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param \App\Models\Klinik\Organization $organization
         *
         * @return \Illuminate\Http\Response
         */
        public function edit(Organization $organization)
        {
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \App\Http\Requests\Klinik\UpdateOrganizationRequest $request
         * @param \App\Models\Klinik\Organization                     $organization
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateOrganizationRequest $request, Organization $organization)
        {
            try {
                $organization->update($request->validated());
                if ($request->hasFile('logo')) {
                    $path               = $request->file('logo')->store('images/logos', 'public');
                    $organization->logo = $path;
                    $organization->save();
                }

                // Create SatuSehat Organization instance
                $satuSehatOrg = new SatuSehatOrganization();

                // Set identifier menggunakan addIdentifier()
                $satuSehatOrg->addIdentifier($organization->organization_id);

                // Set nama organisasi menggunakan setName()
                $satuSehatOrg->setName($organization->name);

                // Set operational status menggunakan setOperationalStatus()
                $satuSehatOrg->setOperationalStatus('active');

                // Set partOf menggunakan setPartOf()
                $satuSehatOrg->setPartOf($organization->organization_id);

                // Set type menggunakan setType() - gunakan 'prov' untuk provider
                $satuSehatOrg->setType('prov');

                // Add phone menggunakan addPhone()
                if ($organization->phone) {
                    $satuSehatOrg->addPhone($organization->phone);
                }

                // Add email menggunakan addEmail()
                if ($organization->email) {
                    $satuSehatOrg->addEmail($organization->email);
                }

                // Add URL menggunakan addUrl()
                if ($organization->url) {
                    $satuSehatOrg->addUrl($organization->url);
                }

                // Add address menggunakan addAddress()
                // Parameter: address_line, postal_code, city_name, village_code
                $villageCode = $organization->sub_district ? $organization->sub_district->area_code : null;
                $satuSehatOrg->addAddress(
                    $organization->address,
                    $organization->postal_code,
                    $organization->city ? $organization->city->name : null,
                    $villageCode
                );

                // Get JSON menggunakan json()
                //$jsonSatuSehat = json_decode($satuSehatOrg->json(), true);
                $satuSehatOrg->put($organization->organization_id);
                //$organization->json_satu_sehat = json_encode($jsonSatuSehat);
                $organization->save();

                return redirect()->route('organization.index')->with('success', 'Organization updated successfully');
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->route('organization.index')->with('error', 'Organization updated failed');
            }
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\Organization $organization
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Organization $organization)
        {
            //
        }

        /**
         * Function for upload avatar image
         *
         * @param string $folder
         * @param string $key
         * @param string $validation
         *
         * @return false|string|null
         */
        public function upload($folder = 'assets/media/logos', $key = 'logo', $validation = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|sometimes')
        {
            request()->validate([$key => $validation]);

            $file = null;
            if (request()->hasFile($key)) {
                $file = Storage::disk('public')->putFile($folder, request()->file($key), 'public');
            }

            return $file;
        }
    }
