<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\UnitDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreUnitRequest;
use App\Http\Requests\Klinik\UpdateUnitRequest;
use App\Models\Klinik\Unit;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
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
    public function index(UnitDataTable $dataTable)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.klinik.units.index');
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

        return view('pages.klinik.units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnitRequest $request)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if ($validated) {
            try {
                Unit::create(['name' => $request->name]);
            } catch(Exception $e) {
                report($e);

                return false;
            }

            session()->flash('success', 'Unit has been created !!');

            return redirect()->route('units.index');
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
            //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        $unit = Unit::find($id);

        return view('pages.klinik.units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
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
                $unit->update($validated);
            } catch(Exception $e) {
                report($e);

                return false;
            }

            session()->flash('success', 'Unit has been updated !!');

            return redirect()->route('units.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
        }

        $unit->delete();

        session()->flash('success', 'Unit has been deleted !!');

        return redirect()->route('units.index');
    }
}
