<?php

namespace App\Http\Controllers\Klinik;

use App\FHIR\Observations;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StorePhysicalExaminationRequest;
use App\Http\Requests\Klinik\UpdatePhysicalExaminationRequest;
use App\Models\Klinik\Examination;
use App\Models\Klinik\PhysicalExamination;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Class PhysicalExaminationsController
 *
 * Handles CRUD operations for Physical Examinations
 *
 * @package App\Http\Controllers\Klinik
 */
class PhysicalExaminationsController extends Controller
{
    /**
     * Current authenticated user
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the physical examinations
     *
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(): View
    {
        Gate::authorize('klinik.view');

        Log::info('Physical examinations index accessed', [
            'user_id' => $this->user->id,
            'user_email' => $this->user->email
        ]);

        return view('pages.klinik.physicalexaminations.index');
    }

    /**
     * Show the form for creating a new physical examination
     *
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(): View
    {
        Gate::authorize('klinik.create');

        Log::info('Physical examination create form accessed', [
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.physicalexaminations.create');
    }

    /**
     * Store a newly created physical examination in storage
     *
     * @param StorePhysicalExaminationRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StorePhysicalExaminationRequest $request): RedirectResponse
    {
        Gate::authorize('klinik.create');

        DB::beginTransaction();

        try {
            // Validate examination exists
            $examination = Examination::findOrFail($request->examination_id);

            // Prepare validated data
            $validated = $request->validated();
            $validated['physical_value'] = json_encode($request->physical ?? []);

            // Create physical examination
            $physicalExamination = PhysicalExamination::create($validated);

            // Set FHIR observation if physical examination created successfully
            if ($physicalExamination) {
                $this->setObservation($physicalExamination);
            }

            // Handle examination completion
            if ($request->selesai) {
                $examination->update(['status' => 'waiting payment']);

                DB::commit();

                Log::info('Physical examination completed and examination status updated', [
                    'user_id' => $this->user->id,
                    'physical_examination_id' => $physicalExamination->id,
                    'examination_id' => $examination->id,
                    'new_status' => 'waiting payment'
                ]);

                return redirect()->route('transactions.create', ['id' => $examination->id])
                    ->with('success', 'Pemeriksaan fisik berhasil dibuat dan siap untuk pembayaran.');
            }

            DB::commit();

            Log::info('Physical examination created successfully', [
                'user_id' => $this->user->id,
                'physical_examination_id' => $physicalExamination->id,
                'examination_id' => $examination->id
            ]);

            return redirect()->route('examinations.edit', ['examination' => $request->examination_id])
                ->with('success', 'Pemeriksaan fisik berhasil dibuat.');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error creating physical examination', [
                'user_id' => $this->user->id,
                'request_data' => $request->validated(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pemeriksaan fisik.');
        }
    }

    /**
     * Display the specified physical examination
     *
     * @param PhysicalExamination $physicalExamination
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(PhysicalExamination $physicalExamination): View
    {
        Gate::authorize('klinik.view');

        Log::info('Physical examination viewed', [
            'user_id' => $this->user->id,
            'physical_examination_id' => $physicalExamination->id
        ]);

        return view('pages.klinik.physicalexaminations.show', compact('physicalExamination'));
    }

    /**
     * Show the form for editing the specified physical examination
     *
     * @param PhysicalExamination $physicalExamination
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(PhysicalExamination $physicalExamination): View
    {
        Gate::authorize('klinik.update');

        Log::info('Physical examination edit form accessed', [
            'user_id' => $this->user->id,
            'physical_examination_id' => $physicalExamination->id
        ]);

        return view('pages.klinik.physicalexaminations.edit', compact('physicalExamination'));
    }

    /**
     * Update the specified physical examination in storage
     *
     * @param UpdatePhysicalExaminationRequest $request
     * @param PhysicalExamination $physicalExamination
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePhysicalExaminationRequest $request, PhysicalExamination $physicalExamination): RedirectResponse
    {
        Gate::authorize('klinik.update');

        DB::beginTransaction();

        try {
            // Validate examination exists
            $examination = Examination::findOrFail($request->examination_id);

            // Prepare validated data
            $validated = $request->validated();
            $validated['physical_value'] = json_encode($request->physical ?? []);

            // Update physical examination
            $physicalExamination->update($validated);

            // Handle examination completion
            if ($request->selesai) {
                $examination->update(['status' => 'done']);

                DB::commit();

                Log::info('Physical examination updated and examination completed', [
                    'user_id' => $this->user->id,
                    'physical_examination_id' => $physicalExamination->id,
                    'examination_id' => $examination->id,
                    'new_status' => 'done'
                ]);

                return redirect()->route('transactions.create', ['id' => $examination->id])
                    ->with('success', 'Pemeriksaan fisik berhasil diperbarui dan pemeriksaan selesai.');
            }

            DB::commit();

            Log::info('Physical examination updated successfully', [
                'user_id' => $this->user->id,
                'physical_examination_id' => $physicalExamination->id,
                'examination_id' => $examination->id
            ]);

            return redirect()->route('examinations.edit', ['examination' => $request->examination_id])
                ->with('success', 'Pemeriksaan fisik berhasil diperbarui.');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error updating physical examination', [
                'user_id' => $this->user->id,
                'physical_examination_id' => $physicalExamination->id,
                'request_data' => $request->validated(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui pemeriksaan fisik.');
        }
    }

    /**
     * Remove the specified physical examination from storage
     *
     * @param PhysicalExamination $physicalExamination
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(PhysicalExamination $physicalExamination): RedirectResponse
    {
        Gate::authorize('klinik.delete');

        DB::beginTransaction();

        try {
            $physicalExaminationId = $physicalExamination->id;
            $examinationId = $physicalExamination->examination_id;

            $physicalExamination->delete();

            DB::commit();

            Log::info('Physical examination deleted successfully', [
                'user_id' => $this->user->id,
                'physical_examination_id' => $physicalExaminationId,
                'examination_id' => $examinationId
            ]);

            return redirect()->back()
                ->with('success', 'Pemeriksaan fisik berhasil dihapus.');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error deleting physical examination', [
                'user_id' => $this->user->id,
                'physical_examination_id' => $physicalExamination->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus pemeriksaan fisik.');
        }
    }

    /**
     * Set FHIR observation for physical examination
     *
     * @param PhysicalExamination $physical
     * @return void
     */
    private function setObservation(PhysicalExamination $physical): void
    {
        try {
            $examination = Examination::findOrFail($physical->examination_id);
            $encounter = json_decode($examination->encounter);

            if (!$encounter || !isset($encounter->participant[0]->individual)) {
                Log::warning('Invalid encounter data for physical examination', [
                    'physical_examination_id' => $physical->id,
                    'examination_id' => $physical->examination_id
                ]);
                return;
            }

            $participant = $encounter->participant[0]->individual;
            $observation = $this->createBaseObservation($encounter, $participant, $examination);

            // Process all physical examination observations
            $this->processAllObservations($physical, $observation);

            Log::info('FHIR observations processed successfully', [
                'physical_examination_id' => $physical->id,
                'examination_id' => $physical->examination_id
            ]);

        } catch (Exception $e) {
            Log::error('Error setting FHIR observation', [
                'physical_examination_id' => $physical->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Create base observation object with common properties
     *
     * @param object $encounter
     * @param object $participant
     * @param Examination $examination
     * @return Observations
     */
    private function createBaseObservation(object $encounter, object $participant, Examination $examination): Observations
    {
        $date = date('Y-m-d\TH:i:sP');
        $observation = new Observations();

        $observation->setStatus('final');
        $observation->addCategory('exam');
        $observation->setSubject(
            str_replace('Patient/', '', $encounter->subject->reference),
            $encounter->subject->display
        );
        $observation->addEffectiveDateTime($date);
        $observation->addIssuedDateTime($date);
        $observation->setPerformer(
            str_replace('Practitioner/', '', $participant->reference),
            $participant->display
        );
        $observation->setEncounter($examination->encounter_id);

        return $observation;
    }

    /**
     * Process all physical examination observations
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processAllObservations(PhysicalExamination $physical, Observations $observation): void
    {
        $observationMethods = [
            'processHeadObservation',
            'processEyeObservation',
            'processEarObservation',
            'processNoseObservation',
            'processHairObservation',
            'processLipObservation',
            'processTeethObservation',
            'processTongueObservation',
            'processPalatalObservation',
            'processNeckObservation',
            'processThroatObservation',
            'processTonsilObservation',
            'processChestObservation',
            'processBreastsObservation',
            'processBackObservation',
            'processAbdomenObservation',
            'processGenitaliaObservation',
            'processButtocksObservation',
            'processUpperArmObservation',
            'processForearmObservation',
            'processHandObservation',
            'processNailObservation',
            'processWristObservation',
            'processThighObservation',
            'processCalfObservation',
            'processFootObservation'
        ];

        foreach ($observationMethods as $method) {
            if (method_exists($this, $method)) {
                $this->$method($physical, $observation);
            }
        }
    }

    /**
     * Process head observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processHeadObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->head) {
            return;
        }

        $observation->addCode('10199-8');
        $observation->addStringComponent($physical->head);
        $observation->post();
    }

    /**
     * Process eye observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processEyeObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->eye) {
            return;
        }

        $observation->addCode('10197-2');
        $observation->addStringComponent($physical->eye);
        $observation->post();
    }

    /**
     * Process ear observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processEarObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->ear) {
            return;
        }

        $observation->addCode('10195-6');
        $observation->addStringComponent($physical->ear);
        $observation->post();
    }

    /**
     * Process nose observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processNoseObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->nose) {
            return;
        }

        $observation->addCode('10203-8');
        $observation->addStringComponent($physical->nose);
        $observation->post();
    }

    /**
     * Process hair observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processHairObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->hair) {
            return;
        }

        $observation->addCode('32436-8');
        $observation->addStringComponent($physical->hair);
        $observation->post();
    }

    /**
     * Process lip observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processLipObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->lip) {
            return;
        }

        $observation->addCode('32446-7');
        $observation->addStringComponent($physical->lip);
        $observation->post();
    }

    /**
     * Process teeth observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processTeethObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->teeth) {
            return;
        }

        $observation->addCode('85910-8');
        $observation->addStringComponent($physical->teeth);
        $observation->post();
    }

    /**
     * Process tongue observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processTongueObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->tongue) {
            return;
        }

        $observation->addCode('32483-0');
        $observation->addStringComponent($physical->tongue);
        $observation->post();
    }

    /**
     * Process palatal observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processPalatalObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->palatal) {
            return;
        }

        $observation->addCode('10201-2');
        $observation->addStringComponent($physical->palatal);
        $observation->addBodySite('72914001');
        $observation->post();
    }

    /**
     * Process neck observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processNeckObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->neck) {
            return;
        }

        $observation->addCode('11411-6');
        $observation->addStringComponent($physical->neck);
        $observation->post();
    }

    /**
     * Process throat observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processThroatObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->throat) {
            return;
        }

        $observation->addCode('56867-5');
        $observation->addStringComponent($physical->throat);
        $observation->post();
    }

    /**
     * Process tonsil observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processTonsilObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->tonsil) {
            return;
        }

        $observation->addCode('10201-2');
        $observation->addStringComponent($physical->tonsil);
        $observation->addBodySite('91636008');
        $observation->post();
    }

    /**
     * Process chest observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processChestObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->chest) {
            return;
        }

        $observation->addCode('11391-0');
        $observation->addStringComponent($physical->chest);
        $observation->post();
    }

    /**
     * Process breasts observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processBreastsObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->breasts) {
            return;
        }

        $observation->addCode('10193-1');
        $observation->addStringComponent($physical->breasts);
        $observation->post();
    }

    /**
     * Process back observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processBackObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->back) {
            return;
        }

        $observation->addCode('10192-3');
        $observation->addStringComponent($physical->back);
        $observation->post();
    }

    /**
     * Process abdomen observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processAbdomenObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->abdomen) {
            return;
        }

        $observation->addCode('10191-5');
        $observation->addStringComponent($physical->abdomen);
        $observation->post();
    }

    /**
     * Process genitalia observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processGenitaliaObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->genitalia) {
            return;
        }

        $observation->addCode('11400-9');
        $observation->addStringComponent($physical->genitalia);
        $observation->post();
    }

    /**
     * Process buttocks observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processButtocksObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->buttocks) {
            return;
        }

        $observation->addCode('11388-6');
        $observation->addStringComponent($physical->buttocks);
        $observation->addBodySite('53505006');
        $observation->post();
    }

    /**
     * Process upper arm observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processUpperArmObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->upper_arm) {
            return;
        }

        $observation->addCode('11386-0');
        $observation->addStringComponent($physical->upper_arm);
        $observation->post();
    }

    /**
     * Process forearm observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processForearmObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->forearm) {
            return;
        }

        $observation->addCode('11398-5');
        $observation->addStringComponent($physical->forearm);
        $observation->post();
    }

    /**
     * Process hand observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processHandObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->hand) {
            return;
        }

        $observation->addCode('11404-1');
        $observation->addStringComponent($physical->hand);
        $observation->addBodySite('7569003');
        $observation->post();
    }

    /**
     * Process nail observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processNailObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->nail) {
            return;
        }

        $observation->addCode('32456-6');
        $observation->addStringComponent($physical->nail);
        $observation->addBodySite('770812000');
        $observation->post();
    }

    /**
     * Process wrist observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processWristObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->wrist) {
            return;
        }

        $observation->addCode('11415-7');
        $observation->addStringComponent($physical->wrist);
        $observation->post();
    }

    /**
     * Process thigh observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processThighObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->thigh) {
            return;
        }

        $observation->addCode('11414-0');
        $observation->addStringComponent($physical->thigh);
        $observation->post();
    }

    /**
     * Process calf observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processCalfObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->calf) {
            return;
        }

        $observation->addCode('11389-4');
        $observation->addStringComponent($physical->calf);
        $observation->post();
    }

    /**
     * Process foot observation
     *
     * @param PhysicalExamination $physical
     * @param Observations $observation
     * @return void
     */
    private function processFootObservation(PhysicalExamination $physical, Observations $observation): void
    {
        if (!$physical->foot) {
            return;
        }

        $observation->addCode('11397-7');
        $observation->addStringComponent($physical->foot);
        $observation->addBodySite('29707007');
        $observation->post();
    }
}
