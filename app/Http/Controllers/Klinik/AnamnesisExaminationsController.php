<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreAnamnesisExaminationRequest;
use App\Http\Requests\Klinik\UpdateAnamnesisExaminationRequest;
use App\Models\Klinik\AnamnesisExamination;
use App\Models\Klinik\Examination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AnamnesisExaminationsController extends Controller
{
    public $user;

    /**
     * Initialize middleware for user authentication
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Store a newly created anamnesis examination in storage
     *
     * @param StoreAnamnesisExaminationRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAnamnesisExaminationRequest $request): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        $validated = $request->validated();
        $validated['anamnesis_value'] = json_encode($request->anamnesis);

        try {
            DB::beginTransaction();

            $anamnesisExamination = AnamnesisExamination::create($validated);

            // Update examination status if completed
            if ($request->selesai) {
                $examination = Examination::findOrFail($request->examination_id);
                $examination->update(['status' => 'done']);

                DB::commit();

                Log::info('Anamnesis examination created and examination completed', [
                    'anamnesis_examination_id' => $anamnesisExamination->id,
                    'examination_id' => $examination->id,
                    'user_id' => $this->user->id,
                    'data' => $validated
                ]);

                return redirect()->route('transactions.create', ['id' => $examination->id])
                    ->with('success', 'Anamnesis Examination successfully created');
            }

            DB::commit();

            Log::info('Anamnesis examination created successfully', [
                'anamnesis_examination_id' => $anamnesisExamination->id,
                'examination_id' => $request->examination_id,
                'user_id' => $this->user->id,
                'data' => $validated
            ]);

            session()->flash('success', 'Anamnesis Examination has been created !!');
            return redirect()->route('examinations.edit', ['examination' => $request->examination_id]);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to create anamnesis examination', [
                'error' => $e->getMessage(),
                'examination_id' => $request->examination_id,
                'user_id' => $this->user->id,
                'data' => $validated
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create anamnesis examination: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified anamnesis examination in storage
     *
     * @param UpdateAnamnesisExaminationRequest $request
     * @param AnamnesisExamination $anamnesisexamination
     * @return RedirectResponse
     */
    public function update(UpdateAnamnesisExaminationRequest $request, AnamnesisExamination $anamnesisexamination): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to update any master data !');
        }

        $validated = $request->validated();
        $validated['anamnesis_value'] = json_encode($request->anamnesis);

        try {
            DB::beginTransaction();

            $anamnesisexamination->update($validated);

            // Update examination status if completed
            if ($request->selesai) {
                $examination = Examination::findOrFail($request->examination_id);
                $examination->update(['status' => 'waiting payment']);

                DB::commit();

                Log::info('Anamnesis examination updated and examination status changed', [
                    'anamnesis_examination_id' => $anamnesisexamination->id,
                    'examination_id' => $examination->id,
                    'user_id' => $this->user->id,
                    'data' => $validated
                ]);

                return redirect()->route('transactions.create', ['id' => $examination->id])
                    ->with('success', 'Anamnesis Examination successfully updated');
            }

            DB::commit();

            Log::info('Anamnesis examination updated successfully', [
                'anamnesis_examination_id' => $anamnesisexamination->id,
                'examination_id' => $request->examination_id,
                'user_id' => $this->user->id,
                'data' => $validated
            ]);

            session()->flash('success', 'Anamnesis Examination has been updated !!');
            return redirect()->route('examinations.edit', ['examination' => $request->examination_id]);

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to update anamnesis examination', [
                'anamnesis_examination_id' => $anamnesisexamination->id,
                'error' => $e->getMessage(),
                'examination_id' => $request->examination_id,
                'user_id' => $this->user->id,
                'data' => $validated
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update anamnesis examination: ' . $e->getMessage());
        }
    }
}
