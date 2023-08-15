<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\DrugsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreDrugRequest;
use App\Http\Requests\Klinik\UpdateDrugRequest;
use App\Models\Klinik\Drug;
use App\Models\Klinik\Unit;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;

class DrugsController extends Controller
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
    public function index(DrugsDataTable $dataTable)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.klinik.drugs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || ! $this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        $unit = Unit::all();

        return view('pages.klinik.drugs.create', compact('unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDrugRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDrugRequest $request)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if ($validated) {
            try {
                Drug::create($validated);
            } catch (Exception $e) {
                print_r($e);

                return false;
            }

            session()->flash('success', 'Drug has been created !!');

            return redirect()->route('drugs.index');
        }

        print_r($validated);
        exit;

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function show(Drug $drug)
    {
            //
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        $unit = Unit::all();
        $drug = Drug::find($id);

        return view('pages.klinik.drugs.edit', compact(['unit', 'drug']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDrugRequest  $request
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDrugRequest $request, Drug $drug)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if ($validated) {
            // Process Data
            try {
                $drug->update($validated);
            } catch (Exception $e) {
                report($e);

                return false;
            }

            session()->flash('success', 'Drug has been updated !!');

            return redirect()->route('drugs.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drug $drug)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
        }

        $drug->delete();

        session()->flash('success', 'Drug has been deleted !!');

        return redirect()->route('drugs.index');
    }
}
