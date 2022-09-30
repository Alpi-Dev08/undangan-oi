<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Masters\MaritalStatusesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Master\MaritalStatus;
use App\Http\Requests\Master\StoreMaritalStatusRequest;
use App\Http\Requests\Master\UpdateMaritalStatusRequest;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;

class MaritalStatusesController extends Controller
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
    public function index(MaritalStatusesDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('masters.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.masters.maritalstatuses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        return view('pages.masters.maritalstatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMaritalStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMaritalStatusRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                MaritalStatus::create(['name' => $request->name]);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Marital Status has been created !!');
            return redirect()->route('maritalstatuses.index');
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaritalStatus  $maritalstatus
     * @return \Illuminate\Http\Response
     */
    public function show(MaritalStatus $maritalstatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('masters.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        $maritalstatus = MaritalStatus::find($id);
        return view('pages.masters.maritalstatuses.edit',compact('maritalstatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMaritalStatusRequest  $request
     * @param  \App\Models\MaritalStatus  $maritalstatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMaritalStatusRequest $request, MaritalStatus $maritalstatus)
    {
        if (is_null($this->user) || !$this->user->can('masters.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            // Process Data
            try{
                $maritalstatus->update($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Marital Status has been updated !!');
            return redirect()->route('maritalstatuses.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaritalStatus  $maritalstatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaritalStatus $maritalstatus)
    {
        if (is_null($this->user) || !$this->user->can('masters.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
        }

        $maritalstatus->delete();

        session()->flash('success', 'Marital Status has been deleted !!');
        return redirect()->route('maritalstatuses.index');
    }
}
