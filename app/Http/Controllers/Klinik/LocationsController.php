<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\LocationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreLocationRequest;
use App\Http\Requests\Klinik\UpdateLocationRequest;
use App\Models\Klinik\Location;
use App\Models\Klinik\Organization;
use App\Models\Master\City;
use App\Models\Master\Country;
use App\Models\Master\District;
use App\Models\Master\Province;
use App\Models\Master\SubDistrict;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Satusehat\Integration\FHIR\Location as FHIRLocation;
use Throwable;

/**
 * Class LocationsController
 *
 * Handles CRUD operations for Location management
 * Integrates with FHIR Location for SatuSehat compliance
 *
 * @package App\Http\Controllers\Klinik
 */
class LocationsController extends Controller
{
    /**
     * The authenticated user instance
     */
    protected ?object $user = null;

    /**
     * LocationsController constructor.
     *
     * Sets up authentication middleware and user instance
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function (Request $request, callable $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the location resources.
     *
     * @param LocationsDataTable $dataTable The DataTable instance for locations
     * @return View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function index(LocationsDataTable $dataTable): View
    {
        $this->checkAuthorization('klinik.read', 'Unauthorized to view location data');

        Log::info('Location index accessed', [
            'user_id' => $this->user?->id,
            'user_email' => $this->user?->email
        ]);

        return $dataTable->render('pages.klinik.locations.index');
    }

    /**
     * Show the form for creating a new location resource.
     *
     * @return View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function create()
    {
        $this->checkAuthorization('klinik.create', 'Unauthorized to create location data');

        Log::info('Location create form accessed', [
            'user_id' => $this->user?->id
        ]);

        try {
            $organizations = Organization::select('id', 'name')
                ->orderBy('name')
                ->get();
            $countries = Country::select('id', 'name')
                ->orderBy('name')
                ->get();
            $provinces = Province::select('id', 'name', 'country_id')
                ->orderBy('name')
                ->get();

            return view('pages.klinik.locations.create', compact(
                'organizations',
                'countries',
                'provinces'
            ));
        } catch (Exception $e) {
            Log::error('Failed to load location create form data', [
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return back()->with('error', 'Failed to load form data. Please try again.');
        }
    }

    /**
     * Store a newly created location resource in storage.
     *
     * @param StoreLocationRequest $request The validated request
     * @return RedirectResponse
     */
    public function store(StoreLocationRequest $request): RedirectResponse
    {
        $this->checkAuthorization('klinik.create', 'Unauthorized to create location data');

        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Check for duplicate code
            if (Location::where('code', $validated['code'])->exists()) {
                return back()
                    ->withInput()
                    ->withErrors(['code' => 'Location code already exists.']);
            }

            // Check for duplicate name within same organization
            if (Location::where('name', $validated['name'])
                ->where('organization_id', $validated['organization_id'])
                ->exists()) {
                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Location name already exists in this organization.']);
            }

            $validated['uuid'] = Str::uuid()->toString();
            $validated['status'] = $validated['status'] ?? '1'; // Default to active

            $location = Location::create($validated);

            // Generate FHIR Location JSON
            $jsonSatuSehat = $this->generateFhirLocationJson($location);

            // Save FHIR JSON to the location
            $location->update([
                'json_satu_sehat' => json_encode($jsonSatuSehat)
            ]);

            DB::commit();

            Log::info('Location created successfully', [
                'location_id' => $location->id,
                'location_code' => $location->code,
                'user_id' => $this->user?->id
            ]);

            return redirect()
                ->route('locations.index')
                ->with('success', 'Location has been created successfully!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to create location', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->user?->id,
                'request_data' => $request->except(['_token'])
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create location: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified location resource.
     *
     * @param Location $location The location instance
     * @return View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function show(Location $location): View
    {
        $this->checkAuthorization('klinik.read', 'Unauthorized to view location data');

        Log::info('Location details viewed', [
            'location_id' => $location->id,
            'user_id' => $this->user?->id
        ]);

        // Load relationships for better performance
        $location->load([
            'organization:id,name',
            'country:id,name',
            'province:id,name',
            'city:id,name',
            'district:id,name',
            'sub_district:id,name'
        ]);

        return view('pages.klinik.locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified location resource.
     *
     * @param string $id The location ID
     * @return View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function edit(string $id)
    {
        $this->checkAuthorization('klinik.update', 'Unauthorized to edit location data');

        try {
            $location = Location::findOrFail($id);

            Log::info('Location edit form accessed', [
                'location_id' => $location->id,
                'user_id' => $this->user?->id
            ]);

            $organizations = Organization::select('id', 'name')
                ->orderBy('name')
                ->get();
            $countries = Country::select('id', 'name')
                ->orderBy('name')
                ->get();
            $provinces = Province::select('id', 'name', 'country_id')
                ->where('country_id', $location->country_id)
                ->orderBy('name')
                ->get();
            $cities = City::select('id', 'name', 'province_id')
                ->where('province_id', $location->province_id)
                ->orderBy('name')
                ->get();
            $districts = District::select('id', 'name', 'city_id')
                ->where('city_id', $location->city_id)
                ->orderBy('name')
                ->get();
            $subdistricts = SubDistrict::select('id', 'name', 'district_id')
                ->where('district_id', $location->district_id)
                ->orderBy('name')
                ->get();

            return view('pages.klinik.locations.edit', compact(
                'location',
                'organizations',
                'countries',
                'provinces',
                'cities',
                'districts',
                'subdistricts'
            ));

        } catch (ModelNotFoundException $e) {
            Log::warning('Location not found for edit', [
                'location_id' => $id,
                'user_id' => $this->user?->id
            ]);

            return redirect()
                ->route('locations.index')
                ->with('error', 'Location not found.');
        } catch (Exception $e) {
            Log::error('Failed to load location edit form', [
                'location_id' => $id,
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return back()->with('error', 'Failed to load edit form. Please try again.');
        }
    }

    /**
     * Update the specified location resource in storage.
     *
     * @param UpdateLocationRequest $request The validated request
     * @param Location $location The location instance
     * @return RedirectResponse
     */
    public function update(UpdateLocationRequest $request, Location $location): RedirectResponse
    {
        $this->checkAuthorization('klinik.update', 'Unauthorized to update location data');

        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Check for duplicate code (excluding current location)
            if (Location::where('code', $validated['code'])
                ->where('id', '!=', $location->id)
                ->exists()) {
                return back()
                    ->withInput()
                    ->withErrors(['code' => 'Location code already exists.']);
            }

            // Check for duplicate name within same organization (excluding current location)
            if (Location::where('name', $validated['name'])
                ->where('organization_id', $validated['organization_id'])
                ->where('id', '!=', $location->id)
                ->exists()) {
                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Location name already exists in this organization.']);
            }

            $location->update($validated);

            // Generate FHIR Location JSON with ID for update
            $jsonSatuSehat = $this->generateFhirLocationJson($location, true);

            // Save FHIR JSON to the location
            $location->update([
                'json_satu_sehat' => json_encode($jsonSatuSehat)
            ]);

            DB::commit();

            Log::info('Location updated successfully', [
                'location_id' => $location->id,
                'location_code' => $location->code,
                'user_id' => $this->user?->id,
                'changes' => $location->getChanges()
            ]);

            return redirect()
                ->route('locations.index')
                ->with('success', 'Location has been updated successfully!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to update location', [
                'location_id' => $location->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->user?->id,
                'request_data' => $request->except(['_token'])
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update location: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified location resource from storage.
     *
     * @param Location $location The location instance
     * @return RedirectResponse
     */
    public function destroy(Location $location): RedirectResponse
    {
        $this->checkAuthorization('klinik.delete', 'Unauthorized to delete location data');

        DB::beginTransaction();

        try {
            // Check if location has any related records that would prevent deletion
            // Add your business logic here based on your application requirements

            $locationCode = $location->code;
            $locationName = $location->name;

            $location->delete();

            DB::commit();

            Log::info('Location deleted successfully', [
                'location_code' => $locationCode,
                'location_name' => $locationName,
                'user_id' => $this->user?->id
            ]);

            return redirect()
                ->route('locations.index')
                ->with('success', 'Location has been deleted successfully!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to delete location', [
                'location_id' => $location->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return redirect()
                ->route('locations.index')
                ->with('error', 'Failed to delete location: ' . $e->getMessage());
        }
    }

    /**
     * Check if user is authorized to perform an action.
     *
     * @param string $permission Permission to check
     * @param string $message Error message to display
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function checkAuthorization(string $permission, string $message): void
    {
        if (is_null($this->user) || !$this->user->can($permission)) {
            Log::warning('Unauthorized access attempt', [
                'permission' => $permission,
                'user_id' => $this->user?->id ?? 'guest',
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);

            abort(403, $message);
        }
    }

    /**
     * Generate FHIR Location JSON for SatuSehat integration.
     *
     * @param Location $location Location model
     * @param bool $isUpdate Whether this is for an update operation
     * @return array FHIR Location JSON as array
     * @throws Exception
     */
    private function generateFhirLocationJson(Location $location, bool $isUpdate = false): array
    {
        try {
            $fhirLocation = new FHIRLocation();

            // Set basic information
            $fhirLocation->addIdentifier($location->code);
            $fhirLocation->setName($location->name, $location->description);
            $fhirLocation->setStatus($location->status == '1' ? 'active' : 'inactive');

            // Set contact information
            if ($location->phone) {
                $fhirLocation->addPhone($location->phone);
            }
            if ($location->email) {
                $fhirLocation->addEmail($location->email);
            }

            // Set address
            $fhirLocation->setAddress(
                $location->address,
                $location->postal_code,
                $location->city?->name ?? '',
                $location->sub_district?->area_code ?? ''
            );

            // Set managing organization
            if ($location->organization?->organization_id) {
                $fhirLocation->setManagingOrganization($location->organization->organization_id);
            }

            // Set physical type (defaults to 'ro' - Room)
            $fhirLocation->addPhysicalType('ro');

            // Get the JSON and decode to array
            $jsonSatuSehat = json_decode($fhirLocation->json(), true);

            // Add the location ID for update operation
            if ($isUpdate && $location->location_id) {
                $jsonSatuSehat['id'] = $location->location_id;
                $fhirLocation->put($location->location_id);
            } else {
                $fhirLocation->post();
            }

            // Add fax manually since FHIR class doesn't support it
            if ($location->fax) {
                $jsonSatuSehat['telecom'][] = [
                    'system' => 'fax',
                    'use' => 'work',
                    'value' => $location->fax,
                ];
            }

            Log::info('FHIR Location JSON generated', [
                'location_id' => $location->id,
                'is_update' => $isUpdate
            ]);

            return $jsonSatuSehat;

        } catch (Throwable $e) {
            Log::error('Failed to generate FHIR Location JSON', [
                'location_id' => $location->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception('Failed to generate FHIR Location JSON: ' . $e->getMessage());
        }
    }
}
