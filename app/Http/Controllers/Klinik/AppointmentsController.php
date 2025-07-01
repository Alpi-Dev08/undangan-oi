<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\AppointmentsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreExaminationRequest;
use App\Http\Requests\Klinik\UpdateExaminationRequest;
use App\Models\Klinik\Examination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Controller untuk mengelola data appointments (janji temu)
 * Menangani operasi CRUD untuk appointments yang merupakan examination dengan is_appointment = 1
 */
class AppointmentsController extends Controller
{
    public ?object $user;

    /**
     * Konstruktor untuk inisialisasi middleware autentikasi
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar appointments
     *
     * @param AppointmentsDataTable $dataTable
     * @return View
     */
    public function index(AppointmentsDataTable $dataTable): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to appointments index', [
                'user_id' => $this->user?->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        Log::info('Appointments index accessed', [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name
        ]);

        return $dataTable->render('pages.klinik.appointments.index');
    }

    /**
     * Menampilkan form untuk membuat appointment baru
     *
     * @return View
     */
    public function create(): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized access attempt to create appointment', [
                'user_id' => $this->user?->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to create appointment !');
        }

        Log::info('Appointment create form accessed', [
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.appointments.create');
    }

    /**
     * Menyimpan appointment baru ke database
     *
     * @param StoreExaminationRequest $request
     * @return RedirectResponse
     */
    public function store(StoreExaminationRequest $request): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Unauthorized attempt to store appointment', [
                'user_id' => $this->user?->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to create appointment !');
        }

        try {
            DB::beginTransaction();

            $validatedData = $request->validated();
            $validatedData['is_appointment'] = '1';
            $validatedData['appointment_status'] = '0';
            $validatedData['examination_code'] = 'APT-' . time();

            $appointment = Examination::create($validatedData);

            DB::commit();

            Log::info('Appointment created successfully', [
                'appointment_id' => $appointment->id,
                'examination_code' => $appointment->examination_code,
                'user_id' => $this->user->id,
                'created_by' => $this->user->name
            ]);

            return redirect()->route('appointments.index')
                ->with('success', 'Appointment berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to create appointment', [
                'error' => $e->getMessage(),
                'user_id' => $this->user->id,
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat appointment. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail appointment
     *
     * @param Examination $appointment
     * @return View
     */
    public function show(Examination $appointment): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Unauthorized access attempt to view appointment', [
                'user_id' => $this->user?->id,
                'appointment_id' => $appointment->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to view appointment !');
        }

        Log::info('Appointment detail viewed', [
            'appointment_id' => $appointment->id,
            'examination_code' => $appointment->examination_code,
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.appointments.show', compact('appointment'));
    }

    /**
     * Menampilkan form untuk mengedit appointment
     *
     * @param Examination $appointment
     * @return View
     */
    public function edit(Examination $appointment): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized access attempt to edit appointment', [
                'user_id' => $this->user?->id,
                'appointment_id' => $appointment->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to edit appointment !');
        }

        Log::info('Appointment edit form accessed', [
            'appointment_id' => $appointment->id,
            'examination_code' => $appointment->examination_code,
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.appointments.edit', compact('appointment'));
    }

    /**
     * Memperbarui appointment di database
     *
     * @param UpdateExaminationRequest $request
     * @param Examination $appointment
     * @return RedirectResponse
     */
    public function update(UpdateExaminationRequest $request, Examination $appointment): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Unauthorized attempt to update appointment', [
                'user_id' => $this->user?->id,
                'appointment_id' => $appointment->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to update appointment !');
        }

        try {
            DB::beginTransaction();

            $validatedData = $request->validated();
            $appointment->update($validatedData);

            DB::commit();

            Log::info('Appointment updated successfully', [
                'appointment_id' => $appointment->id,
                'examination_code' => $appointment->examination_code,
                'user_id' => $this->user->id,
                'updated_by' => $this->user->name
            ]);

            return redirect()->route('appointments.index')
                ->with('success', 'Appointment berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to update appointment', [
                'error' => $e->getMessage(),
                'appointment_id' => $appointment->id,
                'user_id' => $this->user->id,
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui appointment. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus appointment dari database
     *
     * @param Examination $appointment
     * @return RedirectResponse
     */
    public function destroy(Examination $appointment): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Unauthorized attempt to delete appointment', [
                'user_id' => $this->user?->id,
                'appointment_id' => $appointment->id,
                'ip' => request()->ip()
            ]);
            abort(403, 'Sorry !! You are Unauthorized to delete appointment !');
        }

        try {
            DB::beginTransaction();

            $appointmentData = [
                'id' => $appointment->id,
                'examination_code' => $appointment->examination_code,
                'appointment_date' => $appointment->appointment_date
            ];

            $appointment->delete();

            DB::commit();

            Log::info('Appointment deleted successfully', [
                'appointment_data' => $appointmentData,
                'user_id' => $this->user->id,
                'deleted_by' => $this->user->name
            ]);

            return redirect()->route('appointments.index')
                ->with('success', 'Appointment berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to delete appointment', [
                'error' => $e->getMessage(),
                'appointment_id' => $appointment->id,
                'user_id' => $this->user->id
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menghapus appointment. Silakan coba lagi.');
        }
    }
}
