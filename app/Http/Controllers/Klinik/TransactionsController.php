<?php

    namespace App\Http\Controllers\Klinik;

    use App\DataTables\Klinik\TransactionsDataTable;
    use App\Http\Controllers\Controller;
    use App\Models\Klinik\Examination;
    use App\Models\Klinik\Service;
    use App\Models\Klinik\ServiceCategory;
    use App\Models\Klinik\Transaction;
    use App\Http\Requests\Klinik\StoreTransactionRequest;
    use App\Http\Requests\Klinik\UpdateTransactionRequest;
    use App\Models\Klinik\TransactionDetail;
    use Doctrine\DBAL\Driver\PDO\Exception;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;


    class TransactionsController extends Controller
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
        public function index(TransactionsDataTable $dataTable)
        {
            if (is_null($this->user) || !$this->user->can('klinik.read')) {
                abort(403, 'Sorry !! You are Unauthorized to view any master data !');
            }

            return $dataTable->render('pages.klinik.transactions.index');
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create(Request $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            $transaction = Transaction::where('examination_id', $request->id)->first();

            return view('pages.klinik.transactions.create',['transaction' => $transaction]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\StoreTransactionRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            if (is_null($this->user) || !$this->user->can('klinik.create')) {
                abort(403, 'Sorry !! You are Unauthorized to create any master data !');
            }

            try{
                $transaction = Transaction::find($request->transaction_id);
                $total = 0;
                foreach($request->name as $key => $value){
                    if($value !=null) {
                        $price = str_replace('.00', '', $request->price[$key]);
                        $price = str_replace(',', '', $price);

                        $subtotal = $price * (int) $request->quantity[$key];
                        $transaction->transactionDetails()->create([
                            'name'        => $value,
                            'description' => $request->description[$key],
                            'price'       => $price,
                            'qty'         => $request->quantity[$key],
                            'total'       => $subtotal,
                        ]);

                        $total = $total + $subtotal;
                    }
                }
                $transaction->amount = $total;
                $transaction->notes = $request->notes;
                $transaction->status = 'waiting payment';
                $transaction->save();
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Transaction has been created !!');
            return redirect()->route('transactions.index');

            return false;
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Klinik\Transaction $transaction
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Transaction $transaction)
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

            $transaction = Transaction::find($id);
            $examination = Examination::find($transaction->examination_id);
            $category = ServiceCategory::with('services')->where('id', $examination->service_category_id)->first();
            $services = Service::whereHas('category',function(Builder $query){
                return $query->where('is_global', 1);
            })->get();
            return view('pages.klinik.transactions.edit',compact('transaction','category','services','examination'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \App\Http\Requests\Klinik\UpdateTransactionRequest $request
         * @param  \App\Models\Klinik\Transaction                     $transaction
         *
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Transaction $transaction)
        {
            if (is_null($this->user) || !$this->user->can('klinik.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master date !');
            }

            try{
                $transaction = Transaction::find($request->transaction_id);

                $total = 0;
                TransactionDetail::where('transaction_id',$transaction->id)->delete();
                foreach($request->service_id as $key => $value){
                    if($value !=null) {
                        $price = str_replace('.00', '', $request->price[$key]);
                        $price = str_replace(',', '', $price);

                        $subtotal = $price * (int) $request->quantity[$key];
                        $id = null;
                        if(isset($request->id[$key])) {
                            $id = $request->id[$key];
                        }

                        $service = Service::find($request->service_id[$key]);
                        TransactionDetail::updateOrCreate(['id' => $id,'transaction_id' => $request->transaction_id],[
                            'service_id'  => $request->service_id[$key],
                            'name'        => $service->name,
                            'description' => $request->description[$key],
                            'price'       => $price,
                            'qty'         => $request->quantity[$key],
                            'total'       => $subtotal,
                        ]);

                        $total = $total + $subtotal;
                    }
                }
                $transaction->amount = $total;
                $transaction->notes = $request->notes;
                $transaction->status = 'waiting payment';
                $transaction->metode_pembayaran = $request->metode_pembayaran;
                $transaction->save();
            }catch(Exception $e){
                report($e);
                return false;
            }

            session()->flash('success', 'Transaction has been updated !!');
            return redirect()->route('transactions.index');

            return false;
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Klinik\Transaction $transaction
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy(Transaction $transaction)
        {
            if (is_null($this->user) || !$this->user->can('klinik.delete')) {
                abort(403, 'Sorry !! You are Unauthorized to delete any master date !');
            }

            $transaction->delete();

            session()->flash('success', 'Transaction has been deleted !!');
            return redirect()->route('transactions.index');
        }
    }
