<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\IcdtenDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klinik\Icdten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class IcdtenController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IcdtenDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any ICD-10 data !');
        }

        return $dataTable->render('pages.klinik.icdten.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any ICD-10 data !');
        }

        return view('pages.klinik.icdten.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any ICD-10 data !');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:icdtens',
        ]);

        try {
            Icdten::create($request->all());
            session()->flash('success', 'ICD-10 has been created successfully !!');
            return redirect()->route('icdten.index');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Klinik\Icdten  $icdten
     * @return \Illuminate\Http\Response
     */
    public function show(Icdten $icdten)
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any ICD-10 data !');
        }

        return view('pages.klinik.icdten.show', compact('icdten'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Klinik\Icdten  $icdten
     * @return \Illuminate\Http\Response
     */
    public function edit(Icdten $icdten)
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any ICD-10 data !');
        }

        return view('pages.klinik.icdten.edit', compact('icdten'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Klinik\Icdten  $icdten
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Icdten $icdten)
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to update any ICD-10 data !');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:icdtens,code,' . $icdten->id,
        ]);

        try {
            $icdten->update($request->all());
            session()->flash('success', 'ICD-10 has been updated successfully !!');
            return redirect()->route('icdten.index');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Klinik\Icdten  $icdten
     * @return \Illuminate\Http\Response
     */
    public function destroy(Icdten $icdten)
    {
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any ICD-10 data !');
        }

        try {
            $icdten->delete();
            session()->flash('success', 'ICD-10 has been deleted successfully !!');
            return redirect()->route('icdten.index');
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 30;

        $results = Icdten::where('code', 'LIKE', "%$term%")
                        ->orWhere('name', 'LIKE', "%$term%")
                        ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'total_count' => $results->total(),
            'items' => $results->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->name,
                    'code' => $item->code
                ];
            })
        ]);
    }
}
