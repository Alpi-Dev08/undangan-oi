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
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Satusehat\Integration\FHIR\Organization as SatuSehatOrganization;
use Satusehat\Integration\Models\SatusehatLog;
use Throwable;

/**
 * Class OrganizationController
 *
 * Handles CRUD operations for Organization management
 * Integrates with SatuSehat FHIR Organization for compliance
 *
 * @package App\Http\Controllers\Klinik
 */
class OrganizationController extends Controller
{
    /**
     * The authenticated user instance
     */
    protected ?object $user = null;

    /**
     * OrganizationController constructor.
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
     * Display the organization overview page.
     *
     * @return View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function index()
    {
        $this->checkAuthorization('klinik.read', 'Unauthorized to view organization data');

        Log::info('Organization overview accessed', [
            'user_id' => $this->user?->id,
            'user_email' => $this->user?->email
        ]);

        try {
            // Get the main organization (assuming ID 1 is the main organization)
            $organization = Organization::with([
                'country:id,name',
                'province:id,name',
                'city:id,name',
                'district:id,name',
                'sub_district:id,name,area_code'
            ])->findOrFail(1);

            $user = $this->user;
            $info = $user->info;

            // Load location data based on organization's current settings
            $countries = Country::select('id', 'name')
                ->orderBy('name')
                ->get();

            $provinces = $organization->country_id
                ? Province::select('id', 'name', 'country_id')
                    ->where('country_id', $organization->country_id)
                    ->orderBy('name')
                    ->get()
                : Province::select('id', 'name', 'country_id')
                    ->orderBy('name')
                    ->get();

            $cities = $organization->province_id
                ? City::select('id', 'name', 'province_id')
                    ->where('province_id', $organization->province_id)
                    ->orderBy('name')
                    ->get()
                : collect();

            $districts = $organization->city_id
                ? District::select('id', 'name', 'city_id')
                    ->where('city_id', $organization->city_id)
                    ->orderBy('name')
                    ->get()
                : collect();

            $subdistricts = $organization->district_id
                ? SubDistrict::select('id', 'name', 'district_id', 'area_code')
                    ->where('district_id', $organization->district_id)
                    ->orderBy('name')
                    ->get()
                : collect();

            return view('pages.klinik.organization.overview', compact(
                'organization',
                'user',
                'info',
                'countries',
                'provinces',
                'cities',
                'districts',
                'subdistricts'
            ));

        } catch (ModelNotFoundException $e) {
            Log::error('Main organization not found', [
                'user_id' => $this->user?->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Organization data not found. Please contact administrator.');
        } catch (Exception $e) {
            Log::error('Failed to load organization overview', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->user?->id
            ]);

            return back()->with('error', 'Failed to load organization data. Please try again.');
        }
    }

    /**
     * Show the form for creating a new organization resource.
     *
     * @return View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function create()
    {
        $this->checkAuthorization('klinik.create', 'Unauthorized to create organization data');

        Log::info('Organization create form accessed', [
            'user_id' => $this->user?->id
        ]);

        try {
            $countries = Country::select('id', 'name')
                ->orderBy('name')
                ->get();
            $provinces = Province::select('id', 'name', 'country_id')
                ->orderBy('name')
                ->get();

            return view('pages.klinik.organization.create', compact(
                'countries',
                'provinces'
            ));
        } catch (Exception $e) {
            Log::error('Failed to load organization create form data', [
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return back()->with('error', 'Failed to load form data. Please try again.');
        }
    }

    /**
     * Store a newly created organization resource in storage.
     *
     * @param StoreOrganizationRequest $request The validated request
     * @return RedirectResponse
     */
    public function store(StoreOrganizationRequest $request): RedirectResponse
    {
        $this->checkAuthorization('klinik.create', 'Unauthorized to create organization data');

        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Check for duplicate organization_id
            if (Organization::where('organization_id', $validated['organization_id'])->exists()) {
                return back()
                    ->withInput()
                    ->withErrors(['organization_id' => 'Organization ID already exists.']);
            }

            // Check for duplicate name
            if (Organization::where('name', $validated['name'])->exists()) {
                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Organization name already exists.']);
            }

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $logoPath = $this->uploadFile(
                    $request->file('logo'),
                    'images/logos',
                    'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                );
                $validated['logo'] = $logoPath;
            }

            $organization = Organization::create($validated);

            // Generate SatuSehat FHIR Organization
            $this->generateSatuSehatOrganization($organization);

            DB::commit();

            Log::info('Organization created successfully', [
                'organization_id' => $organization->id,
                'organization_name' => $organization->name,
                'user_id' => $this->user?->id
            ]);

            return redirect()
                ->route('organization.index')
                ->with('success', 'Organization has been created successfully!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to create organization', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->user?->id,
                'request_data' => $request->except(['_token', 'logo'])
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create organization: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified organization resource.
     *
     * @param Organization $organization The organization instance
     * @return View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function show(Organization $organization)
    {
        $this->checkAuthorization('klinik.read', 'Unauthorized to view organization data');

        Log::info('Organization details viewed', [
            'organization_id' => $organization->id,
            'user_id' => $this->user?->id
        ]);

        // Load relationships for better performance
        $organization->load([
            'country:id,name',
            'province:id,name',
            'city:id,name',
            'district:id,name',
            'sub_district:id,name,area_code'
        ]);

        return view('pages.klinik.organization.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified organization resource.
     *
     * @param Organization $organization The organization instance
     * @return View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function edit(Organization $organization)
    {
        $this->checkAuthorization('klinik.update', 'Unauthorized to edit organization data');

        Log::info('Organization edit form accessed', [
            'organization_id' => $organization->id,
            'user_id' => $this->user?->id
        ]);

        try {
            $countries = Country::select('id', 'name')
                ->orderBy('name')
                ->get();
            $provinces = Province::select('id', 'name', 'country_id')
                ->where('country_id', $organization->country_id)
                ->orderBy('name')
                ->get();
            $cities = City::select('id', 'name', 'province_id')
                ->where('province_id', $organization->province_id)
                ->orderBy('name')
                ->get();
            $districts = District::select('id', 'name', 'city_id')
                ->where('city_id', $organization->city_id)
                ->orderBy('name')
                ->get();
            $subdistricts = SubDistrict::select('id', 'name', 'district_id')
                ->where('district_id', $organization->district_id)
                ->orderBy('name')
                ->get();

            return view('pages.klinik.organization.edit', compact(
                'organization',
                'countries',
                'provinces',
                'cities',
                'districts',
                'subdistricts'
            ));

        } catch (Exception $e) {
            Log::error('Failed to load organization edit form', [
                'organization_id' => $organization->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return back()->with('error', 'Failed to load edit form. Please try again.');
        }
    }

    /**
     * Update the specified organization resource in storage.
     *
     * @param UpdateOrganizationRequest $request The validated request
     * @param Organization $organization The organization instance
     * @return RedirectResponse
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization): RedirectResponse
    {
        $this->checkAuthorization('klinik.update', 'Unauthorized to update organization data');

        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Check for duplicate name (excluding current organization)
            if (Organization::where('name', $validated['name'])
                ->where('id', '!=', $organization->id)
                ->exists()) {
                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Organization name already exists.']);
            }

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($organization->logo && Storage::disk('public')->exists($organization->logo)) {
                    Storage::disk('public')->delete($organization->logo);
                }

                $logoPath = $this->uploadFile(
                    $request->file('logo'),
                    'images/logos',
                    'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                );
                $validated['logo'] = $logoPath;
            }

            $organization->update($validated);

            // Generate SatuSehat FHIR Organization
            $this->generateSatuSehatOrganization($organization, true);

            DB::commit();

            Log::info('Organization updated successfully', [
                'organization_id' => $organization->id,
                'organization_name' => $organization->name,
                'user_id' => $this->user?->id,
                'changes' => $organization->getChanges()
            ]);

            return redirect()
                ->route('organization.index')
                ->with('success', 'Organization has been updated successfully!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to update organization', [
                'organization_id' => $organization->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->user?->id,
                'request_data' => $request->except(['_token', 'logo'])
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update organization: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified organization resource from storage.
     *
     * @param Organization $organization The organization instance
     * @return RedirectResponse
     */
    public function destroy(Organization $organization): RedirectResponse
    {
        $this->checkAuthorization('klinik.delete', 'Unauthorized to delete organization data');

        DB::beginTransaction();

        try {
            // Check if organization has any related records that would prevent deletion
            // Add your business logic here based on your application requirements

            $organizationName = $organization->name;

            // Delete logo file if exists
            if ($organization->logo && Storage::disk('public')->exists($organization->logo)) {
                Storage::disk('public')->delete($organization->logo);
            }

            $organization->delete();

            DB::commit();

            Log::info('Organization deleted successfully', [
                'organization_name' => $organizationName,
                'user_id' => $this->user?->id
            ]);

            return redirect()
                ->route('organization.index')
                ->with('success', 'Organization has been deleted successfully!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to delete organization', [
                'organization_id' => $organization->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id
            ]);

            return redirect()
                ->route('organization.index')
                ->with('error', 'Failed to delete organization: ' . $e->getMessage());
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
     * Generate SatuSehat FHIR Organization for compliance.
     *
     * @param Organization $organization Organization model
     * @param bool $isUpdate Whether this is for an update operation
     * @return void
     * @throws Exception
     */
    private function generateSatuSehatOrganization(Organization $organization, bool $isUpdate = false): void
    {
        try {
            // Load relationships if not already loaded
            if (!$organization->relationLoaded('sub_district')) {
                $organization->load('sub_district:id,area_code', 'city:id,name');
            }

            // Create SatuSehat Organization instance
            $satuSehatOrg = new SatuSehatOrganization();

            // Set identifier
            $satuSehatOrg->addIdentifier($organization->organization_id);

            // Set nama organisasi
            $satuSehatOrg->setName($organization->name);

            // Set operational status
            $satuSehatOrg->setOperationalStatus('active');

            // Set partOf
            $satuSehatOrg->setPartOf($organization->organization_id);

            // Set type - gunakan 'prov' untuk provider
            $satuSehatOrg->setType('prov');

            // Add contact information
            if ($organization->phone) {
                $satuSehatOrg->addPhone($organization->phone);
            }

            if ($organization->email) {
                $satuSehatOrg->addEmail($organization->email);
            }

            if ($organization->url ?? null) {
                $satuSehatOrg->addUrl($organization->url);
            }

            // Add address
            $villageCode = $organization->sub_district?->area_code;
            $cityName = $organization->city?->name;

            if ($organization->address && $organization->postal_code) {
                $satuSehatOrg->addAddress(
                    $organization->address,
                    $organization->postal_code,
                    $cityName,
                    $villageCode
                );
            }

            // Send to SatuSehat
            if ($isUpdate && $organization->organization_id) {
                $satuSehatOrg->put($organization->organization_id);
            } else {
                $satuSehatOrg->post();
            }

            // Save JSON to organization
            $jsonSatuSehat = json_decode($satuSehatOrg->json(), true);
            $organization->update([
                'json_satu_sehat' => json_encode($jsonSatuSehat)
            ]);

            Log::info('SatuSehat Organization FHIR generated', [
                'organization_id' => $organization->id,
                'is_update' => $isUpdate
            ]);

        } catch (Throwable $e) {
            Log::error('Failed to generate SatuSehat Organization FHIR', [
                'organization_id' => $organization->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception('Failed to generate SatuSehat Organization FHIR: ' . $e->getMessage());
        }
    }

    /**
     * Upload file to storage.
     *
     * @param \Illuminate\Http\UploadedFile $file The uploaded file
     * @param string $folder Storage folder path
     * @param string $validation Validation rules
     * @return string|null File path or null if upload failed
     * @throws Exception
     */
    private function uploadFile($file, string $folder = 'assets/media/logos', string $validation = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'): ?string
    {
        try {
            // Validate file
            request()->validate(['file' => $validation]);

            // Store file
            $filePath = Storage::disk('public')->putFile($folder, $file, 'public');

            if (!$filePath) {
                throw new Exception('Failed to store file');
            }

            Log::info('File uploaded successfully', [
                'file_path' => $filePath,
                'original_name' => $file->getClientOriginalName(),
                'user_id' => $this->user?->id
            ]);

            return $filePath;

        } catch (Exception $e) {
            Log::error('File upload failed', [
                'error' => $e->getMessage(),
                'folder' => $folder,
                'user_id' => $this->user?->id
            ]);

            throw new Exception('File upload failed: ' . $e->getMessage());
        }
    }
}
