<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\VitalityExaminationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreVitalityExaminationRequest;
use App\Http\Requests\Klinik\UpdateVitalityExaminationRequest;
use App\Models\Klinik\Examination;
use App\Models\Klinik\VitalityExamination;
use App\FHIR\Observations;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Exception;

/**
 * Controller untuk mengelola pemeriksaan vitality
 * Menangani CRUD operations dan integrasi dengan FHIR observations
 */
class VitalityExaminationsController extends Controller
{
    // Constants untuk pesan error authorization
    private const UNAUTHORIZED_VIEW   = 'Sorry !! Anda tidak berwenang untuk melihat data master!';
    private const UNAUTHORIZED_CREATE = 'Sorry !! Anda tidak berwenang untuk membuat data master!';
    private const UNAUTHORIZED_UPDATE = 'Sorry !! Anda tidak berwenang untuk mengubah data master!';
    private const UNAUTHORIZED_DELETE = 'Sorry !! Anda tidak berwenang untuk menghapus data master!';

    // FHIR observation codes untuk vital signs
    private const OBSERVATION_CODES = [
        'systolic_bp'      => '8480-6',
        'diastolic_bp'     => '8462-4',
        'heart_rate'       => '8867-4',
        'body_height'      => '8302-2',
        'body_weight'      => '29463-7',
        'temperature'      => '8310-5',
        'respiratory_rate' => '9279-1',
    ];

    protected $user;

    /**
     * Constructor - Setup middleware untuk authentication
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar vitality examinations
     *
     * @param VitalityExaminationsDataTable $dataTable
     * @return Response
     */
    public function index(VitalityExaminationsDataTable $dataTable): Response
    {
        Log::info('Mengakses halaman index vitality examinations', [
            'user_id' => $this->user?->id,
            'timestamp' => now()
        ]);

        $this->authorizeAction('klinik.read', self::UNAUTHORIZED_VIEW);

        return $dataTable->render('pages.klinik.vitalityexaminations.index');
    }

    /**
     * Menampilkan form untuk membuat vitality examination baru
     *
     * @return View
     */
    public function create(): View
    {
        Log::info('Mengakses form create vitality examination', [
            'user_id' => $this->user?->id,
            'timestamp' => now()
        ]);

        $this->authorizeAction('klinik.create', self::UNAUTHORIZED_CREATE);

        return view('pages.klinik.vitalityexaminations.create');
    }

    /**
     * Menyimpan vitality examination baru ke database
     *
     * @param StoreVitalityExaminationRequest $request
     * @return RedirectResponse
     */
    public function store(StoreVitalityExaminationRequest $request): RedirectResponse
    {
        $this->authorizeAction('klinik.create', self::UNAUTHORIZED_CREATE);

        $validated = $request->validated();

        Log::info('Memulai proses create vitality examination', [
            'user_id' => $this->user?->id,
            'examination_id' => $validated['examination_id'] ?? null,
            'timestamp' => now()
        ]);

        DB::beginTransaction();

        try {
            // Buat vitality examination baru
            $vitalityExamination = $this->createVitalityExamination($validated);

            // Proses FHIR observations jika berhasil
            if ($vitalityExamination) {
                $this->processObservations($vitalityExamination);
            }

            DB::commit();

            Log::info('Vitality examination berhasil dibuat', [
                'vitality_examination_id' => $vitalityExamination->id,
                'examination_id' => $vitalityExamination->examination_id,
                'user_id' => $this->user?->id,
                'timestamp' => now()
            ]);

            session()->flash('success', 'Vitality Examination has been created !!');
            return redirect()->route('examinations.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal membuat vitality examination', [
                'error' => $e->getMessage(),
                'user_id' => $this->user?->id,
                'examination_id' => $validated['examination_id'] ?? null,
                'timestamp' => now()
            ]);

            report($e);
            return $this->handleError('Failed to create Vitality Examination');
        }
    }

    /**
     * Menampilkan form untuk edit vitality examination
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $this->authorizeAction('klinik.update', self::UNAUTHORIZED_UPDATE);

        Log::info('Mengakses form edit vitality examination', [
            'vitality_examination_id' => $id,
            'user_id' => $this->user?->id,
            'timestamp' => now()
        ]);

        $vitalityexamination = VitalityExamination::findOrFail($id);
        $examinationId = $vitalityexamination->examination_id;

        return view('pages.klinik.examinations.vitality', compact('vitalityexamination', 'id'));
    }

    /**
     * Update vitality examination di database
     *
     * @param UpdateVitalityExaminationRequest $request
     * @param VitalityExamination $vitalityexamination
     * @return RedirectResponse
     */
    public function update(
        UpdateVitalityExaminationRequest $request,
        VitalityExamination $vitalityexamination
    ): RedirectResponse {
        $this->authorizeAction('klinik.update', self::UNAUTHORIZED_UPDATE);

        $validated = $request->validated();

        Log::info('Memulai proses update vitality examination', [
            'vitality_examination_id' => $vitalityexamination->id,
            'examination_id' => $vitalityexamination->examination_id,
            'user_id' => $this->user?->id,
            'timestamp' => now()
        ]);

        DB::beginTransaction();

        try {
            // Update vitality examination
            $this->updateVitalityExamination($vitalityexamination, $validated);

            // Proses FHIR observations
            $this->processObservations($vitalityexamination);

            DB::commit();

            Log::info('Vitality examination berhasil diupdate', [
                'vitality_examination_id' => $vitalityexamination->id,
                'examination_id' => $vitalityexamination->examination_id,
                'user_id' => $this->user?->id,
                'timestamp' => now()
            ]);

            session()->flash('success', 'VitalityExamination has been updated !!');
            return redirect()->route('examinations.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengupdate vitality examination', [
                'error' => $e->getMessage(),
                'vitality_examination_id' => $vitalityexamination->id,
                'user_id' => $this->user?->id,
                'timestamp' => now()
            ]);

            report($e);
            return $this->handleError('Failed to update Vitality Examination');
        }
    }

    /**
     * Hapus vitality examination dari database
     *
     * @param VitalityExamination $vitalityexamination
     * @return RedirectResponse
     */
    public function destroy(VitalityExamination $vitalityexamination): RedirectResponse
    {
        $this->authorizeAction('klinik.delete', self::UNAUTHORIZED_DELETE);

        Log::info('Memulai proses delete vitality examination', [
            'vitality_examination_id' => $vitalityexamination->id,
            'examination_id' => $vitalityexamination->examination_id,
            'user_id' => $this->user?->id,
            'timestamp' => now()
        ]);

        DB::beginTransaction();

        try {
            $vitalityexamination->delete();

            DB::commit();

            Log::info('Vitality examination berhasil dihapus', [
                'vitality_examination_id' => $vitalityexamination->id,
                'user_id' => $this->user?->id,
                'timestamp' => now()
            ]);

            session()->flash('success', 'VitalityExamination has been deleted !!');
            return redirect()->route('vitalityexaminations.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal menghapus vitality examination', [
                'error' => $e->getMessage(),
                'vitality_examination_id' => $vitalityexamination->id,
                'user_id' => $this->user?->id,
                'timestamp' => now()
            ]);

            report($e);
            return $this->handleError('Failed to delete Vitality Examination');
        }
    }

    /**
     * Proses data skrining
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function skrining(Request $request): RedirectResponse
    {
        $examinationId = $request->examination_id;

        Log::info('Memulai proses skrining vitality examination', [
            'examination_id' => $examinationId,
            'user_id' => $this->user?->id,
            'timestamp' => now()
        ]);

        DB::beginTransaction();

        try {
            $vitalityexamination = VitalityExamination::where('examination_id', $examinationId)->first();

            if (!$vitalityexamination) {
                throw new Exception('Vitality examination tidak ditemukan');
            }

            $data = $this->filterSkriningData($request->all());
            $vitalityexamination->update(['skrining' => json_encode($data)]);

            DB::commit();

            Log::info('Skrining vitality examination berhasil diupdate', [
                'examination_id' => $examinationId,
                'vitality_examination_id' => $vitalityexamination->id,
                'user_id' => $this->user?->id,
                'timestamp' => now()
            ]);

            return redirect()
                ->route('examinations.vitality', ['id' => $examinationId])
                ->with('success', 'Vitality Examination has been updated !!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengupdate skrining vitality examination', [
                'error' => $e->getMessage(),
                'examination_id' => $examinationId,
                'user_id' => $this->user?->id,
                'timestamp' => now()
            ]);

            report($e);
            return $this->handleError('Failed to update skrining data');
        }
    }

    /**
     * Authorize action berdasarkan permission
     *
     * @param string $permission
     * @param string $message
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function authorizeAction(string $permission, string $message): void
    {
        if (is_null($this->user) || !$this->user->can($permission)) {
            Log::warning('Unauthorized access attempt', [
                'permission' => $permission,
                'user_id' => $this->user?->id,
                'timestamp' => now()
            ]);

            abort(403, $message);
        }
    }

    /**
     * Buat vitality examination baru
     *
     * @param array $validated
     * @return VitalityExamination
     */
    private function createVitalityExamination(array $validated): VitalityExamination
    {
        return VitalityExamination::create($validated);
    }

    /**
     * Update vitality examination
     *
     * @param VitalityExamination $vitalityExamination
     * @param array $validated
     * @return bool
     */
    private function updateVitalityExamination(
        VitalityExamination $vitalityExamination,
        array $validated
    ): bool {
        return $vitalityExamination->update($validated);
    }

    /**
     * Proses semua FHIR observations untuk vital signs
     *
     * @param VitalityExamination $vitalityExamination
     * @return void
     */
    private function processObservations(VitalityExamination $vitalityExamination): void
    {
        try {
            $examination = Examination::find($vitalityExamination->examination_id);

            if (!$examination || !$examination->encounter) {
                Log::warning('Examination atau encounter tidak ditemukan', [
                    'examination_id' => $vitalityExamination->examination_id,
                    'vitality_examination_id' => $vitalityExamination->id
                ]);
                return;
            }

            $encounter = json_decode($examination->encounter);

            if (!$encounter || !isset($encounter->participant[0]->individual)) {
                Log::warning('Data encounter tidak valid', [
                    'examination_id' => $examination->id,
                    'encounter_data' => $examination->encounter
                ]);
                return;
            }

            $participant = $encounter->participant[0]->individual;
            $observation = $this->createBaseObservation($encounter, $participant, $examination);

            // Proses semua vital signs
            $this->processAllVitalSigns($vitalityExamination, $observation);

            Log::info('FHIR observations berhasil diproses', [
                'vitality_examination_id' => $vitalityExamination->id,
                'examination_id' => $examination->id
            ]);

        } catch (Exception $e) {
            Log::error('Gagal memproses FHIR observations', [
                'error' => $e->getMessage(),
                'vitality_examination_id' => $vitalityExamination->id,
                'examination_id' => $vitalityExamination->examination_id
            ]);

            // Tidak throw exception karena ini adalah proses tambahan
            // Vitality examination tetap bisa disimpan meskipun FHIR gagal
        }
    }

    /**
     * Buat base observation object dengan properti umum
     *
     * @param object $encounter
     * @param object $participant
     * @param Examination $examination
     * @return Observations
     */
    private function createBaseObservation(
        object $encounter,
        object $participant,
        Examination $examination
    ): Observations {
        $observation = new Observations();
        $observation->setStatus('final');
        $observation->addCategory('vital-signs');
        $observation->setSubject(
            str_replace('Patient/', '', $encounter->subject->reference),
            $encounter->subject->display
        );
        $observation->setPerformer(
            str_replace('Practitioner/', '', $participant->reference),
            $participant->display
        );
        $observation->setEncounter($examination->encounter_id);

        return $observation;
    }

    /**
     * Proses semua vital signs untuk FHIR observations
     *
     * @param VitalityExamination $vitalityExamination
     * @param Observations $observation
     * @return void
     */
    private function processAllVitalSigns(
        VitalityExamination $vitalityExamination,
        Observations $observation
    ): void {
        $this->processBloodPressure($vitalityExamination, $observation);
        $this->processHeartRate($vitalityExamination, $observation);
        $this->processTemperature($vitalityExamination, $observation);
        $this->processRespiratoryRate($vitalityExamination, $observation);
        $this->processBodyHeight($vitalityExamination, $observation);
        $this->processBodyWeight($vitalityExamination, $observation);
    }

    /**
     * Proses data tekanan darah untuk FHIR observation
     *
     * @param VitalityExamination $vitalityExamination
     * @param Observations $observation
     * @return void
     */
    private function processBloodPressure(
        VitalityExamination $vitalityExamination,
        Observations $observation
    ): void {
        if (!$vitalityExamination->blood_pressure) {
            return;
        }

        $bloodPressure = explode('/', $vitalityExamination->blood_pressure);

        if (count($bloodPressure) !== 2) {
            Log::warning('Format tekanan darah tidak valid', [
                'blood_pressure' => $vitalityExamination->blood_pressure,
                'vitality_examination_id' => $vitalityExamination->id
            ]);
            return;
        }

        foreach ($bloodPressure as $key => $value) {
            $cleanValue = (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            if ($cleanValue <= 0) {
                continue;
            }

            $observation->addCode($key ? self::OBSERVATION_CODES['diastolic_bp'] : self::OBSERVATION_CODES['systolic_bp']);
            $observation->addComponent([
                'value'  => $cleanValue,
                'unit'   => 'mm[Hg]',
                'system' => 'http://unitsofmeasure.org',
                'code'   => 'mm[Hg]'
            ]);
            $observation->post();
        }
    }

    /**
     * Proses data detak jantung untuk FHIR observation
     *
     * @param VitalityExamination $vitalityExamination
     * @param Observations $observation
     * @return void
     */
    private function processHeartRate(
        VitalityExamination $vitalityExamination,
        Observations $observation
    ): void {
        if (!$vitalityExamination->heart_rate) {
            return;
        }

        $heartRate = (float) filter_var(
            $vitalityExamination->heart_rate,
            FILTER_SANITIZE_NUMBER_FLOAT,
            FILTER_FLAG_ALLOW_FRACTION
        );

        if ($heartRate <= 0) {
            return;
        }

        $observation->addCode(self::OBSERVATION_CODES['heart_rate']);
        $observation->addComponent([
            'value'  => $heartRate,
            'unit'   => '{beats}/min',
            'system' => 'http://unitsofmeasure.org',
            'code'   => '{beats}/min'
        ]);
        $observation->post();
    }

    /**
     * Proses data tinggi badan untuk FHIR observation
     *
     * @param VitalityExamination $vitalityExamination
     * @param Observations $observation
     * @return void
     */
    private function processBodyHeight(
        VitalityExamination $vitalityExamination,
        Observations $observation
    ): void {
        if (!$vitalityExamination->height) {
            return;
        }

        $height = (float) filter_var(
            $vitalityExamination->height,
            FILTER_SANITIZE_NUMBER_FLOAT,
            FILTER_FLAG_ALLOW_FRACTION
        );

        if ($height <= 0) {
            return;
        }

        $observation->addCode(self::OBSERVATION_CODES['body_height']);
        $observation->addComponent([
            'value'  => $height,
            'unit'   => 'cm',
            'system' => 'http://unitsofmeasure.org',
            'code'   => 'cm'
        ]);
        $observation->post();
    }

    /**
     * Proses data berat badan untuk FHIR observation
     *
     * @param VitalityExamination $vitalityExamination
     * @param Observations $observation
     * @return void
     */
    private function processBodyWeight(
        VitalityExamination $vitalityExamination,
        Observations $observation
    ): void {
        if (!$vitalityExamination->weight) {
            return;
        }

        $weight = (float) filter_var(
            $vitalityExamination->weight,
            FILTER_SANITIZE_NUMBER_FLOAT,
            FILTER_FLAG_ALLOW_FRACTION
        );

        if ($weight <= 0) {
            return;
        }

        $observation->addCode(self::OBSERVATION_CODES['body_weight']);
        $observation->addComponent([
            'value'  => $weight,
            'unit'   => 'kg',
            'system' => 'http://unitsofmeasure.org',
            'code'   => 'kg'
        ]);
        $observation->post();
    }

    /**
     * Proses data suhu tubuh untuk FHIR observation
     *
     * @param VitalityExamination $vitalityExamination
     * @param Observations $observation
     * @return void
     */
    private function processTemperature(
        VitalityExamination $vitalityExamination,
        Observations $observation
    ): void {
        if (!$vitalityExamination->temperature) {
            return;
        }

        $temperature = (float) filter_var(
            $vitalityExamination->temperature,
            FILTER_SANITIZE_NUMBER_FLOAT,
            FILTER_FLAG_ALLOW_FRACTION
        );

        if ($temperature <= 0) {
            return;
        }

        $observation->addCode(self::OBSERVATION_CODES['temperature']);
        $observation->addComponent([
            'value'  => $temperature,
            'unit'   => 'Cel',
            'system' => 'http://unitsofmeasure.org',
            'code'   => 'Cel'
        ]);
        $observation->post();
    }

    /**
     * Proses data laju pernapasan untuk FHIR observation
     *
     * @param VitalityExamination $vitalityExamination
     * @param Observations $observation
     * @return void
     */
    private function processRespiratoryRate(
        VitalityExamination $vitalityExamination,
        Observations $observation
    ): void {
        if (!$vitalityExamination->respiratory_rate) {
            return;
        }

        $respiratoryRate = (float) filter_var(
            $vitalityExamination->respiratory_rate,
            FILTER_SANITIZE_NUMBER_FLOAT,
            FILTER_FLAG_ALLOW_FRACTION
        );

        if ($respiratoryRate <= 0) {
            return;
        }

        $observation->addCode(self::OBSERVATION_CODES['respiratory_rate']);
        $observation->addComponent([
            'value'  => $respiratoryRate,
            'unit'   => '{breaths}/min',
            'system' => 'http://unitsofmeasure.org',
            'code'   => '{breaths}/min'
        ]);
        $observation->post();
    }

    /**
     * Filter data skrining dengan menghapus field yang tidak diperlukan
     *
     * @param array $data
     * @return array
     */
    private function filterSkriningData(array $data): array
    {
        $fieldsToRemove = ['_token', 'examination_id', '_method', 'user_id'];

        foreach ($fieldsToRemove as $field) {
            unset($data[$field]);
        }

        return $data;
    }

    /**
     * Handle error responses dengan logging
     *
     * @param string $message
     * @return RedirectResponse
     */
    private function handleError(string $message): RedirectResponse
    {
        session()->flash('error', $message);
        return back();
    }
}
