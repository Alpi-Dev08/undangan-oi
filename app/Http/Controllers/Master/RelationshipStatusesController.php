<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Masters\RelationshipStatusesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Master\RelationshipStatus;
use App\Http\Requests\Master\StoreRelationshipStatusRequest;
use App\Http\Requests\Master\UpdateRelationshipStatusRequest;
use Illuminate\Support\Facades\Auth;

class RelationshipStatusesController extends Controller
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
    public function index(RelationshipStatusesDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('masters.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.masters.relationshipstatuses.index');
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
        return view('pages.masters.relationshipstatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRelationshipStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelationshipStatusRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                RelationshipStatus::create(['name' => $request->name]);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Relationship Status has been created !!');
            return redirect()->route('relationshipstatuses.index');
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RelationshipStatus  $relationshipstatus
     * @return \Illuminate\Http\Response
     */
    public function show(RelationshipStatus $relationshipstatus)
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

        $relationshipstatus = RelationshipStatus::find($id);
        return view('pages.masters.relationshipstatuses.edit',compact('relationshipstatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRelationshipStatusRequest  $request
     * @param  \App\Models\RelationshipStatus  $relationshipstatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRelationshipStatusRequest $request, RelationshipStatus $relationshipstatus)
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
                $relationshipstatus->update($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Relationship Status has been updated !!');
            return redirect()->route('relationshipstatuses.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RelationshipStatus  $relationshipstatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(RelationshipStatus $relationshipstatus)
    {
        if (is_null($this->user) || !$this->user->can('masters.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
        }

        $relationshipstatus->delete();

        session()->flash('success', 'Relationship Status has been deleted !!');
        return redirect()->route('relationshipstatuses.index');
    }
}
