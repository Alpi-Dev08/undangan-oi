<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Masters\CardTypesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreCardTypeRequest;
use App\Http\Requests\Master\UpdateCardTypeRequest;
use App\Models\Master\CardType;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;


class CardTypesController extends Controller
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
    public function index(CardTypesDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('masters.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.masters.cardtypes.index');
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
        return view('pages.masters.cardtypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Master\StoreCardTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCardTypeRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                CardType::create(['name' => $request->name]);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'CardType has been created !!');
            return redirect()->route('cardtypes.index');
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CardType  $cardtype
     * @return \Illuminate\Http\Response
     */
    public function show(CardType $cardtype)
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

        $cardtype = CardType::find($id);
        return view('pages.masters.cardtypes.edit',compact('cardtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Master\UpdateCardTypeRequest  $request
     * @param  \App\Models\CardType  $cardtype
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCardTypeRequest $request, CardType $cardtype)
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
                $cardtype->update($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'CardType has been updated !!');
            return redirect()->route('cardtypes.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CardType  $cardtype
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardType $cardtype)
    {
        if (is_null($this->user) || !$this->user->can('masters.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
        }

        $cardtype->delete();

        session()->flash('success', 'CardType has been deleted !!');
        return redirect()->route('cardtypes.index');
    }
}
