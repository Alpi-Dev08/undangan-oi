<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Masters\KategoriWebsiteDataTable;
use App\Models\Master\Kategori;
use App\Models\Master\Jenis;
use App\Http\Requests\Master\StoreKategoriWebsiteRequest;
use App\Http\Requests\Master\UpdateKategoriWebsiteRequest;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class KategoriWebsiteController extends Controller
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
    public function index(KategoriWebsiteDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('masters.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.masters.kategori_web.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data!');
        }

        return view('pages.masters.kategori_web.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreReligionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKategoriWebsiteRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('masters.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        $validated = $request->validated();

        Kategori::create($validated);

        session()->flash('success', 'Kategori has been created !!');

        return redirect()->route('kategori_web.index');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Religion  $religion
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Religion $religion)
    // {
    //     //
    // }

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

        $kategori = Kategori::findOrFail($id);
        $jenis    = Jenis::orderBy('nama_jenis')->get();

        return view(
            'pages.masters.kategori_web.edit',
            compact('kategori', 'jenis')
        ); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateKategoriWebsiteRequest $request
     * @param \App\Models\kategori                     $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKategoriWebsiteRequest $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('masters.update')) {
            abort(403);
        }

        $validated = $request->validated();

        $kategori = Kategori::findOrFail($id);

        $kategori->update($validated);

        session()->flash('success', 'Kategori has been updated !!');

        return redirect()->route('kategori_web.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('masters.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master data !');
        }

        $kategori = Kategori::findOrFail($id);

        $kategori->delete();

        session()->flash('success', 'Kategori berhasil dihapus');

        return redirect()->route('kategori_web.index');
    }
}
