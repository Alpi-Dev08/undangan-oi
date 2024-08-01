<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Masters\OdontogramSymbolsDataTable;
use App\Models\Master\OdontogramSymbol;
use App\Http\Requests\Master\StoreOdontogramSymbolRequest;
use App\Http\Requests\Master\UpdateOdontogramSymbolRequest;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class OdontogramSymbolsController extends Controller
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
    public function index(OdontogramSymbolsDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('masters.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.masters.odontogramsymbols.index');
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
        return view('pages.masters.odontogramsymbols.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreOdontogramSymbolRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOdontogramSymbolRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                OdontogramSymbol::create(['code' => $request->code]);
                OdontogramSymbol::create(['name' => $request->name]);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Odontogram Symbol has been created !!');
            return redirect()->route('odontogramsymbols.index');
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OdontogramSymbol  $odontogramsymbol
     * @return \Illuminate\Http\Response
     */
    public function show(OdontogramSymbol $odontogramsymbol)
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

        $odontogramsymbol = OdontogramSymbol::find($id);
        $odontogramsymbols = OdontogramSymbol::all();

        dd($odontogramsymbol, $odontogramsymbols);

        return view('pages.masters.odontogramsymbols.edit',compact('odontogramsymbol', 'odontogramsymbols'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateOdontogramSymbolRequest $request
     * @param \App\Models\OdontogramSymbol                     $odontogramsymbol
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOdontogramSymbolRequest $request, OdontogramSymbol $odontogramsymbol)
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
                $odontogramsymbol->update($validated);
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Odontogram Symbol has been updated !!');
            return redirect()->route('odontogramsymbols.index');
        }

        return false;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OdontogramSymbol  $odontogramsymbol
     * @return \Illuminate\Http\Response
     */
    public function destroy(OdontogramSymbol $odontogramsymbol)
    {
        if (is_null($this->user) || !$this->user->can('masters.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master data !');
        }

        $odontogramsymbol->delete();

        session()->flash('success', 'Odontogram Symbol has been deleted !!');
        return redirect()->route('odontogramsymbols.index');
    }
}
