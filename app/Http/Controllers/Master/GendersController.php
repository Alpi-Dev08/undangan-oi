<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Masters\GendersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Master\Gender;
use App\Http\Requests\Master\StoreGenderRequest;
use App\Http\Requests\Master\UpdateGenderRequest;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;

class GendersController extends Controller
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
    public function index(GendersDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('masters.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.masters.genders.index');
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
        return view('pages.masters.genders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGenderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGenderRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                Gender::create(['name' => $request->name]);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Gender has been created !!');
            return redirect()->route('genders.index');
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function show(Gender $gender)
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

        $gender = Gender::find($id);
        return view('pages.masters.genders.edit',compact('gender'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGenderRequest  $request
     * @param  \App\Models\Gender $gender
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenderRequest $request, Gender $gender)
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
                $gender->update($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Gender has been updated !!');
            return redirect()->route('genders.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gender $gender)
    {
        if (is_null($this->user) || !$this->user->can('masters.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
        }

        $gender->delete();

        session()->flash('success', 'Gender has been deleted !!');
        return redirect()->route('genders.index');
    }
}
