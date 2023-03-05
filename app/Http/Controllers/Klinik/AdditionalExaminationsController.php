<?php

namespace App\Http\Controllers\Klinik;

use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreAdditionalExaminationRequest;
use App\Http\Requests\Klinik\UpdateAditionalExaminationRequest;
use App\Models\Klinik\Examination;
use App\Models\Klinik\AdditionalExamination;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdditionalExaminationsController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdditionalExaminationRequest $request)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        $request->additional_value = json_encode($request->additional);

        echo $request->additional_value;exit;
        // Validation Data
        $validated = $request->validated();
        $examination = Examination::find($request->examination_id);
        // Process Data

        if ($validated) {
            try {
                $validated['additional_value'] = json_encode($request->additional);
                AdditionalExamination::create($validated);
            } catch(Exception $e) {
                report($e);

                return false;
            }

            if ($request->selesai) {
                $examination->status = 'waiting payment';
                $examination->save();

                return redirect()->route('transactions.create', ['id' => $examination->id])->with('success', 'Other Examination successfully created');
            }

            session()->flash('success', 'Disease has been created !!');

            return redirect()->route('examinations.edit', ['examination' => $request->examination_id]);
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(AdditionalExamination $additionalexamination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(AdditionalExamination $additionalexamination)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAditionalExaminationRequest $request, AdditionalExamination $additionalexamination)
    {
        if (is_null($this->user) || ! $this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        $request->additional_value = json_encode($request->additional);
        // Validation Data
        $validated = $request->validated();
        $examination = Examination::find($request->examination_id);
        // Process Data
        if ($validated) {
            try {
                $validated['additional_value'] = json_encode($request->additional);
                if ($request->hasFile('file')) {
                    $_file = $request->file('file');
                    foreach ($_file as $key => $file) {
                        $file_name = $file->getClientOriginalName();
                        $file->storeAs('public/examinations/'.$examination->examination_code, $key.'.'.$file_name);
                        if ($file->isValid()) {
                            $validated['file'][$key] = $key.'.'.$file_name;
                        }
                    }
                    $validated['file'] = json_encode($validated['file']);
                }

                $additionalexamination->update($validated);
            } catch(Exception $e) {
                report($e);

                return false;
            }

            if ($request->selesai) {
                $examination->status = 'done';
                $examination->save();

                return redirect()->route('transactions.create', ['id' => $examination->id])->with('success', 'Other Examination successfully created');
            }

            session()->flash('success', 'Additional Examination has been created !!');

            return redirect()->route('examinations.edit', ['examination' => $request->examination_id]);
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdditionalExamination $additionalexamination)
    {
        //
    }
}
