<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\ExaminationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\StoreExaminationRequest;
use App\Http\Requests\Klinik\UpdateExaminationRequest;
use App\Models\Klinik\AnamnesisCategory;
use App\Models\Klinik\AnamnesisExamination;
use App\Models\Klinik\Examination;
use App\Models\Klinik\HealthProfesional;
use App\Models\Klinik\Icdten;
use App\Models\Klinik\Laboratory;
use App\Models\Klinik\LaboratoryExamination;
use App\Models\Klinik\LaboratoryExaminationCategory;
use App\Models\Klinik\LaboratoryUnit;
use App\Models\Klinik\Package;
use App\Models\Klinik\Plan;
use App\Models\Klinik\Service;
use App\Models\Klinik\ServiceCategory;
use App\Models\Klinik\ServiceType;
use App\Models\Klinik\Transaction;
use App\Models\Klinik\TransactionDetail;
use App\Models\Klinik\VitalityExamination;
use App\Models\User;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExaminationsController extends Controller
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
    public function index(ExaminationsDataTable $dataTable)
    {
        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data !');
        }

        return $dataTable->render('pages.klinik.examinations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }
        return view('pages.klinik.examinations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Klinik\StoreExaminationRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExaminationRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if ($validated) {
            try {
                Examination::create(['name' => $request->name]);
            } catch (Exception $e) {
                report($e);
                return false;
            }

            session()->flash('success', 'Examination has been created !!');
            return redirect()->route('examinations.index');
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Klinik\Examination $examination
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Examination $examination)
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
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
        }

        $examination = Examination::find($id);

        $examination->status = 'processing';
        $examination->save();

        $user                = User::find($examination->user_id);
        $healthprofesionals  = HealthProfesional::all();
        $plans               = Plan::all();
        $icdtens             = Icdten::all();
        $anamnesiscategories = [];
        if ($examination->service_category->is_mcu == 1) {
            $anamnesiscategories = AnamnesisCategory::all();
        }

        $anamnesisexamination = AnamnesisExamination::where('examination_id', $examination->id)->first();
        $vitalityexaminations = VitalityExamination::where('user_id', $examination->user_id)->orderBy('created_at', 'desc')->get();

        $info = $user->info;
        return view('pages.klinik.examinations.edit', compact('examination', 'user', 'healthprofesionals', 'info', 'plans', 'icdtens', 'vitalityexaminations', 'anamnesiscategories','anamnesisexamination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Klinik\UpdateExaminationRequest $request
     * @param \App\Models\Klinik\Examination $examination
     * @param \App\Models\Klinik\Examination $examination
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExaminationRequest $request, Examination $examination)
    {
        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
        }

        // Validation Data
        $validated = $request->validated();

        // Process Data
        if ($validated) {
            // Process Data
            try {
                $validated['status'] = 'waiting payment';
                $examination->update($validated);
            } catch (Exception $e) {
                report($e);
                return false;
            }

            session()->flash('success', 'Examination has been updated !!');

            if ($examination->status == 'waiting payment') {
                return redirect()->route('transactions.create', ['id' => $examination->id]);
            }
            return redirect()->route('examinations.index');
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Klinik\Examination $examination
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Examination $examination)
    {
        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
        }

        $examination->delete();

        session()->flash('success', 'Examination has been deleted !!');
        return redirect()->route('examinations.index');
    }

    public function invoice(Request $request)
    {
        $id                 = $request->id;
        $examination        = Examination::find($id);
        $user               = User::find($examination->user_id);
        $info               = $user->info;
        $transaction        = Transaction::where('examination_id', $examination->id)->first();
        $transaction_detail = TransactionDetail::where('transaction_id', $transaction->id)->get();

        // get the default inner page
        return view('pages.klinik.examinations.invoice', compact([
            'user', 'info', 'examination', 'transaction', 'transaction_detail'
        ]));
    }

    public function payments(Request $request)
    {
        $id          = $request->id;
        $user        = $id != '' ? User::find($id) : auth()->user();
        $examination = LaboratoryExamination::find($request->examination);
        $info        = $user->info;

        // get the default inner page
        return view('pages.klinik.examinations.payments', compact([
            'user', 'info', 'examination'
        ]));
    }

    public function createPayment(Request $request)
    {
        $id                  = $request->id;
        $transaction         = Transaction::find($id);
        $transaction->status = 'paid';
        $transaction->save();

        $examination         = Examination::find($transaction->examination_id);
        $examination->status = 'done';
        $examination->save();

        return redirect()->route('transactions.index');
    }

    public function services(Request $request)
    {
        $id          = $request->id;
        $examination = Examination::find($id);
        $user        = User::find($examination->user_id);
        $info        = $user->info;

        $services          = Service::where('service_category_id', $examination->service_category_id)->get();
        $servicecategories = ServiceCategory::where('is_global', 1)->get();

        // get the default inner page
        return view('pages.klinik.examinations.services', compact([
            'user', 'info', 'examination', 'services', 'servicecategories'
        ]));
    }

    public function storeservices(Request $request)
    {
        $examination = Examination::find($request->examination_id);
        $transaction = Transaction::where('examination_id', $examination->id)->first();

        $total = $transaction->amount;
        foreach ($request->service_id as $service_id) {
            $service = Service::find($service_id);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'status'         => 'waiting payment',
                'service_id'     => $service->id,
                'name'           => $service->name,
                'price'          => $service->price,
                'total'          => $service->price
            ]);

            $total = $total + $service->price;
        }

        $transaction->amount = $total;
        $transaction->save();

        if ($request->payment == 1) {
            return redirect()->route('transactions.edit', ['transaction' => $transaction->id]);
        } else {
            return redirect()->route('examinations.vitality', ['id' => $examination->id]);
        }
    }

    public function vitality(Request $request)
    {
        $id                  = $request->id;
        $examination         = Examination::find($id);
        $vitalityexamination = VitalityExamination::where('examination_id', $examination->id)->first();

        $user = User::find($examination->user_id);
        $info = $user->info;

        // get the default inner page
        return view('pages.klinik.examinations.vitality', compact([
            'user', 'info', 'examination', 'vitalityexamination'
        ]));
    }
}
