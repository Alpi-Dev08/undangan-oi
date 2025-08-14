<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\LocationExaminationsDataTable;
use App\Models\Klinik\SkriningExaminationLocation;
use Illuminate\Http\Request;
// use Carbon\Carbon;
// use Illuminate\Support\Facades\Validator;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LocationExaminationsController extends Controller
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
    public function index(LocationExaminationsDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data!');
        }

        return $dataTable->render('pages.klinik.locationexaminations.index');

        // // ambil semua data tanpa relasi gender
        // $data = \App\Models\Master\LocationExamination::all();
        
        // // return JSON ke browser
        // return response()->json($data);
    }
    
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        return view('pages.klinik.locationexaminations.create');
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Simpan data
        SkriningExaminationLocation::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('locationexaminations.index')
            ->with('success', 'Location Examination berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $location = SkriningExaminationLocation::findOrFail($id);

        return view('pages.klinik.locationexaminations.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Ambil data lokasi
        $location = SkriningExaminationLocation::findOrFail($id);

        // Update data
        $location->update([
            'name' => $request->name,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('locationexaminations.index')
            ->with('success', 'Location Examination updated successfully.');
    }

        /**
     * Remove the specified resource from storage (Soft Delete).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            abort(403, 'Unauthorized');
        }

        $location = SkriningExaminationLocation::findOrFail($id);

        // Cek apakah location masih dipakai di skrining
        if ($location->skriningexamination()->exists()) {
            return redirect()
                ->route('locationexaminations.index')
                ->with('error', 'Location Examination tidak dapat dihapus karena masih digunakan pada data Skrining Examination');
        }

        // Soft delete
        $location->delete();

        return redirect()
            ->route('locationexaminations.index')
            ->with('success', 'Location Examination has been deleted !!');
    }

}
 