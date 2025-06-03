<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\DrugsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreDrugRequest;
use App\Http\Requests\Klinik\UpdateDrugRequest;
use App\Models\Klinik\Drug;
use App\Models\Klinik\Unit;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Exports\DrugsExport;
use Maatwebsite\Excel\Facades\Excel;

class DrugsController extends Controller
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
    public function index(DrugsDataTable $dataTable)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.klinik.drugs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || ! $this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        $unit = Unit::all();

        return view('pages.klinik.drugs.create', compact('unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDrugRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDrugRequest $request)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if ($validated) {
            try {
                Drug::create($validated);
            } catch (Exception $e) {
                print_r($e);

                return false;
            }

            session()->flash('success', 'Drug has been created !!');

            return redirect()->route('drugs.index');
        }

        print_r($validated);
        exit;

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function show(Drug $drug)
    {
            //
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        $unit = Unit::all();
        $drug = Drug::find($id);

        return view('pages.klinik.drugs.edit', compact(['unit', 'drug']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDrugRequest  $request
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDrugRequest $request, Drug $drug)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if ($validated) {
            // Process Data
            try {
                $drug->update($validated);
            } catch (Exception $e) {
                report($e);

                return false;
            }

            session()->flash('success', 'Drug has been updated !!');

            return redirect()->route('drugs.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drug $drug)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
        }

        $drug->delete();

        session()->flash('success', 'Drug has been deleted !!');

        return redirect()->route('drugs.index');
    }

    public function update1(UpdateDrugRequest $request, Drug $drug)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.update1')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
        }

        $validated = $request->validated();

        if ($validated) {
            try {
                $drug->update1($validated);
            } catch (Exception $e) {
                report($e);

                return false;
            }

            session()->flash('success', 'Drug has been updated !!');

            return redirect()->route('drugs.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drug  $drug
     * @return \Illuminate\Http\Response
     */

    public function detail(Request $request, $id)
    {
        $drug = Drug::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'date' => 'required|date',
                'user_name' => 'required|string|max:255',
                'quantity' => 'required|integer|min:1',
                'description' => 'nullable|string|max:500',
            ]);

            $drug->stock += $request->quantity;
            $drug->save();

            DrugUsage::create([
                'drug_id' => $drug->id,
                'date' => $request->date,
                'user_name' => $request->user_name,
                'quantity' => $request->quantity,
                'description' => $request->description,
            ]);

            session()->flash('success', 'Data penggunaan obat berhasil disimpan!');

            return redirect()->route('drugs.index');
        }

        return view('pages.klinik.drugs.addstock', compact('drug'));
    }

    public function reduceDetail(Request $request, $id)
    {
        $drug = Drug::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'date' => 'required|date',
                'user_name' => 'required|string|max:255',
                'quantity' => 'required|integer|min:1',
                'description' => 'nullable|string|max:500',
            ]);

            $drug->stock += $request->quantity;
            $drug->save();

            DrugUsage::create([
                'drug_id' => $drug->id,
                'date' => $request->date,
                'user_name' => $request->user_name,
                'quantity' => $request->quantity,
                'description' => $request->description,
            ]);

            session()->flash('success', 'Data penggunaan obat berhasil disimpan!');

            return redirect()->route('drugs.index');
        }

        return view('pages.klinik.drugs.reducestock', compact('drug'));
    }

    public function updateDetail(Request $request, Drug $drug)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'user_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        $drug->increment('stock', $validated['quantity']);

        $history = [
            'date' => $validated['date'],
            'user_name' => $validated['user_name'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
        ];

        $histories = session('histories', []);

       if (!isset($histories[$drug->id])) {
            $histories[$drug->id] = [];
        }

        $histories[$drug->id][] = $history;

        session(['histories' => $histories]);

        session()->flash('success', 'Detail obat berhasil diperbarui.');

        return redirect()->route('drugs.index');
    }

    public function showDetail($id)
    {
        $drug = Drug::findOrFail($id);

        $histories = session('histories', []);

        $drugHistories = $histories[$drug->id] ?? [];

        return view('pages.klinik.drugs.addstock', compact('drug', 'drugHistories'));
    }

    public function updateDetailReduce(Request $request, Drug $drug)
    {

        $validated = $request->validate([
            'date' => 'required|date',
            'user_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        $drug->decrement('stock', $validated['quantity']);

        $history = [
            'date' => $validated['date'],
            'user_name' => $validated['user_name'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
        ];

        $histories1 = session('histories1', []);

        if (!isset($histories1[$drug->id])) {
            $histories1[$drug->id] = [];
        }

        $histories1[$drug->id][] = $history;

        session(['histories1' => $histories1]);

        session()->flash('success', 'Detail obat berhasil diperbarui.');

        return redirect()->route('drugs.index');
    }

    public function showDetailReduce($id)
    {
        $drug = Drug::findOrFail($id);

        $histories1 = session('histories1', []);

        $drugHistories1 = $histories1[$drug->id] ?? [];

        return view('pages.klinik.drugs.reducestock', compact('drug', 'drugHistories1'));
    }


    /**
     * Export drugs data to Excel
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        if (is_null($this->user) || ! $this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return Excel::download(new DrugsExport, 'drugs-'.date('YmdHis').'.xlsx');
    }
}
