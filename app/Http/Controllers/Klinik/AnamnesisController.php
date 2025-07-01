<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\AnamnesisDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klinik\Anamnesis;
use App\Http\Requests\Klinik\StoreAnamnesisRequest;
use App\Http\Requests\Klinik\UpdateAnamnesisRequest;
use App\Models\Klinik\AnamnesisCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Exception;

class AnamnesisController extends Controller
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
     * Display a listing of anamnesis records
     *
     * @param AnamnesisDataTable $dataTable
     * @return Response
     */
    public function index(AnamnesisDataTable $dataTable): Response
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        Log::info('Anamnesis index accessed', ['user_id' => $this->user->id]);

        return $dataTable->render('pages.klinik.anamnesis.index');
    }

    /**
     * Show the form for creating a new anamnesis record
     *
     * @return View
     */
    public function create(): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        Log::info('Anamnesis create form accessed', ['user_id' => $this->user->id]);

        $categories = AnamnesisCategory::all();
        return view('pages.klinik.anamnesis.create', compact('categories'));
    }

    /**
     * Store a newly created anamnesis record in storage
     *
     * @param StoreAnamnesisRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAnamnesisRequest $request): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $anamnesis = Anamnesis::create($validated);

            DB::commit();

            Log::info('Anamnesis created successfully', [
                'anamnesis_id' => $anamnesis->id,
                'user_id' => $this->user->id,
                'data' => $validated
            ]);

            session()->flash('success', 'Anamnesis has been created !!');
            return redirect()->route('anamnesis.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to create anamnesis', [
                'error' => $e->getMessage(),
                'user_id' => $this->user->id,
                'data' => $validated
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create anamnesis: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified anamnesis record
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        $anamnesis = Anamnesis::findOrFail($id);
        $categories = AnamnesisCategory::all();

        Log::info('Anamnesis edit form accessed', [
            'anamnesis_id' => $id,
            'user_id' => $this->user->id
        ]);

        return view('pages.klinik.anamnesis.edit', compact('anamnesis', 'categories'));
    }

    /**
     * Update the specified anamnesis record in storage
     *
     * @param UpdateAnamnesisRequest $request
     * @param Anamnesis $anamnesi
     * @return RedirectResponse
     */
    public function update(UpdateAnamnesisRequest $request, Anamnesis $anamnesi): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $anamnesi->update($validated);

            DB::commit();

            Log::info('Anamnesis updated successfully', [
                'anamnesis_id' => $anamnesi->id,
                'user_id' => $this->user->id,
                'data' => $validated
            ]);

            session()->flash('success', 'Anamnesis has been updated !!');
            return redirect()->route('anamnesis.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to update anamnesis', [
                'anamnesis_id' => $anamnesi->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user->id,
                'data' => $validated
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update anamnesis: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified anamnesis record from storage
     *
     * @param Anamnesis $anamnesis
     * @return RedirectResponse
     */
    public function destroy(Anamnesis $anamnesis): RedirectResponse
    {
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master data !');
        }

        try {
            DB::beginTransaction();

            $anamnesis->delete();

            DB::commit();

            Log::info('Anamnesis deleted successfully', [
                'anamnesis_id' => $anamnesis->id,
                'user_id' => $this->user->id
            ]);

            session()->flash('success', 'Anamnesis has been deleted !!');
            return redirect()->route('anamnesis.index');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to delete anamnesis', [
                'anamnesis_id' => $anamnesis->id,
                'error' => $e->getMessage(),
                'user_id' => $this->user->id
            ]);

            return redirect()->back()
                ->with('error', 'Failed to delete anamnesis: ' . $e->getMessage());
        }
    }
}
