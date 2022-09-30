<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Masters\ReligionsDataTable;
use App\Models\Master\Religion;
use App\Http\Requests\Master\StoreReligionRequest;
use App\Http\Requests\Master\UpdateReligionRequest;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ReligionsController extends Controller
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
    public function index(ReligionsDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('masters.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.masters.religions.index');
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
        return view('pages.masters.religions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreReligionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReligionRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                Religion::create(['name' => $request->name]);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Religion has been created !!');
            return redirect()->route('religions.index');
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Religion  $religion
     * @return \Illuminate\Http\Response
     */
    public function show(Religion $religion)
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

        $religion = Religion::find($id);
        return view('pages.masters.religions.edit',compact('religion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateReligionRequest $request
     * @param \App\Models\Religion                     $religion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReligionRequest $request, Religion $religion)
    {
        if (is_null($this->user) || !$this->user->can('masters.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            // Process Data
            try{
                $religion->update($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Religion has been updated !!');
            return redirect()->route('religions.index');
        }

        return false;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Religion $religion)
    {
        if (is_null($this->user) || !$this->user->can('masters.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master data !');
        }

        $religion->delete();

        session()->flash('success', 'Religion has been deleted !!');
        return redirect()->route('religions.index');
    }
}
