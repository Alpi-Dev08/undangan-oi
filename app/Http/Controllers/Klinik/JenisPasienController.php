<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\JenisPasienDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreJenisPasienRequest;
use App\Http\Requests\Klinik\UpdateJenisPasienRequest;
use App\Models\JenisPasien;
use Illuminate\Support\Facades\Auth;

class JenisPasienController extends Controller
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
     */
    public function index(JenisPasienDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any ICD-10 data !');
        }

        return $dataTable->render('pages.klinik.jenis_pasien.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        return view('pages.klinik.jenis_pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJenisPasienRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                JenisPasien::create($validated);
            }catch(\Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Jenis Pasien has been created !!');
            return redirect()->route('jenis-pasien.index');
        }

        return false;
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisPasien $jenisPasien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPasien $jenis_pasien)
    {
        if (is_null($this->user) || !$this->user->can('masters.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        return view('pages.klinik.jenis_pasien.edit', compact('jenis_pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJenisPasienRequest $request, JenisPasien $jenisPasien)
    {
        if (is_null($this->user) || !$this->user->can('masters.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if($validated){
            try{
                $jenisPasien->update($validated);
            }catch(\Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Jenis Pasien has been updated !!');
            return redirect()->route('jenis-pasien.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisPasien $jenisPasien)
    {
        if (is_null($this->user) || !$this->user->can('masters.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master data !');
        }

        $jenisPasien->delete();

        session()->flash('success', 'Jenis Pasien has been deleted !!');
        return redirect()->route('jenis-pasien.index');
    }
}
