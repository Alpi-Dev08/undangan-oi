<?php

    namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\ExaminationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Klinik\{StoreExaminationRequest, UpdateExaminationRequest};
use App\Models\Klinik\{
    AdditionalCategory,
    AdditionalExamination,
    AnamnesisCategory,
    AnamnesisExamination,
    Drug,
    Examination,
    FamilyDiseaseHistory,
    HealthProfesional,
    Icdten,
    LaboratoryExamination,
    OtherExamination,
    Package,
    PemeriksaanAwal,
    PersonalDiseaseHistory,
    PhysicalCategory,
    PhysicalExamination,
    Plan,
    Service,
    ServiceCategory,
    Transaction,
    TransactionDetail,
    VitalityExamination
};
use App\Models\{Master\OdontogramSymbol, User};
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Log, Storage};
use QrCode;
use Satusehat\Integration\FHIR\{Condition, Encounter};
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;


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
         * Store a newly created resource in storage.
         *
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
         * Display the specified resource.
         *
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
         *
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            if (is_null($this->user) || !$this->user->can('klinik.update')) {
                abort(403, 'Sorry !! You are Unauthorized to edit any master data !');
            }

            $examination = Examination::find($id);
            if ($examination->status !== 'done') {
                $examination->status = 'processing';
                $examination->save();
            }

            $user                   = User::find($examination->user_id);
            $healthprofesionals     = HealthProfesional::all();
            $plans                  = Plan::all();
            $drugs                  = Drug::all();
            $icdtens                = Icdten::all();
            $personaldiseasehistories = PersonalDiseaseHistory::all();
            $familydiseasehistories   = FamilyDiseaseHistory::all();
            $anamnesiscategories    = [];
            $physicalscategories    = [];
            $otherscategories       = [];
            $additionalsscategories = [];
            $laboratoryexamination  = null;
            if (isset($examination->service_category->is_mcu)) {
                if ($examination->service_category->is_mcu == 1) {
                    $anamnesiscategories    = AnamnesisCategory::all();
                    $physicalscategories    = PhysicalCategory::where('id', '<>', 15)->get();
                    $otherscategories       = PhysicalCategory::where('id', 15)->get();
                    $additionalsscategories = AdditionalCategory::all();
                }
            }

            if ($examination->is_lab) {
                $laboratoryexamination = LaboratoryExamination::where('examination_id', $examination->id)->first();
            }

            $examinations          = Examination::where('user_id', $examination->user_id)
                                                ->where('status', 'done')
                                                ->orderBy('created_at', 'DESC')
                                                ->get();
            $anamnesisexamination  = AnamnesisExamination::where('examination_id', $examination->id)->first();
            $physicalexamination   = PhysicalExamination::where('examination_id', $examination->id)->first();
            $otherexamination      = OtherExamination::where('examination_id', $examination->id)->first();
            $additionalexamination = AdditionalExamination::where('examination_id', $examination->id)->first();
            //$vitalityexaminations = VitalityExamination::where('user_id', $examination->user_id)->orderBy('created_at', 'desc')->get();

            $odontogramsymbols = OdontogramSymbol::all();

            $info             = $user->info;
            $pemeriksaan_awal = PemeriksaanAwal::where('examination_id', $examination->id)
                                               ->orWhere('user_id', $examination->user_id)
                                               ->first();

            // Ambil data examination berdasarkan ID
            $examination = Examination::findOrFail($id);

            // Ambil semua data SBAR terkait dengan examination
            //$sbars = Sbar::where('examination_id', $examination->id)->get();

            // Kirimkan data ke view
            //return view('pages.klinik.examinations._editform', compact('examination', 'sbars'));

            $qr = QrCode::size(150)
                        ->style('square')
                        ->generate('https://klinik.dharma.or.id/bukti-penyampaian-informasi/' . $examination->id);

            $qr_persetujuan_tindakan_medis = QrCode::size(150)
                                                   ->style('square')
                                                   ->generate('https://klinik.dharma.or.id/persetujuan-tindakan-medis/' . $examination->id);

            return view('pages.klinik.examinations.edit', compact('examination', 'user', 'healthprofesionals', 'info', 'plans', 'icdtens', 'anamnesiscategories', 'anamnesisexamination', 'examinations', 'physicalscategories', 'physicalexamination', 'otherscategories', 'otherexamination', 'additionalsscategories', 'additionalexamination', 'laboratoryexamination', 'pemeriksaan_awal', 'drugs', 'qr', 'qr_persetujuan_tindakan_medis', 'odontogramsymbols', 'personaldiseasehistories', 'familydiseasehistories'));
        }

        /**
         * Remove the specified resource from storage.
         *
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

            // Pastikan direktori invoice ada sebelum menyimpan QR code
            $invoiceDir = storage_path('app/public/invoice');
            if (!file_exists($invoiceDir)) {
                mkdir($invoiceDir, 0755, true);
                Log::info('Created invoice directory: ' . $invoiceDir);
            }

            $qr = QrCode::format('png')->size(100)
                        ->style('square')
                        ->generate('https://klinik.dharma.or.id/invoice/' . $transaction->invoice_number, storage_path('app/public/invoice/'.$transaction->invoice_number.'.png'));

            // get the default inner page
            return view('pages.klinik.examinations.invoice', compact([
                'user',
                'info',
                'examination',
                'transaction',
                'transaction_detail',
                'qr',
            ]));
        }

        /**
         * Download invoice sebagai PDF
         *
         * @param Request $request
         * @return \Illuminate\Http\Response
         */
        public function invoicePdf(Request $request)
        {
            $id                 = $request->id;
            $examination        = Examination::find($id);
            $user               = User::find($examination->user_id);
            $info               = $user->info;
            $transaction        = Transaction::where('examination_id', $examination->id)->first();
            $transaction_detail = TransactionDetail::where('transaction_id', $transaction->id)->get();

            // Hitung total resep jika ada
            $total_resep = 0;
              $qr = QrCode::format('png')
                        ->size(100)
                        ->style('square')
                        ->generate('https://klinik.dharma.or.id/invoice/' . $transaction->invoice_number);

            $data = compact([
                'user',
                'info',
                'examination',
                'transaction',
                'transaction_detail',
                'total_resep',
                'qr',
            ]);

            // Generate PDF dengan DomPDF
            $pdf = Pdf::loadView('pages.klinik.examinations.invoice-pdf', $data);

            // Set paper size dan orientasi
            $pdf->setPaper('A4', 'portrait');

            // Set options untuk kualitas yang lebih baik
            $pdf->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true
            ]);

            // Download PDF dengan nama file yang sesuai
            $filename = 'Invoice_' . $transaction->invoice_number . '_' . date('Y-m-d') . '.pdf';

            return $pdf->download($filename);
        }

        public function payments(Request $request)
        {
            $id          = $request->id;
            $user        = $id != '' ? User::find($id) : auth()->user();
            $examination = LaboratoryExamination::find($request->examination);
            $info        = $user->info;

            // get the default inner page
            return view('pages.klinik.examinations.payments', compact([
                'user',
                'info',
                'examination',
            ]));
        }

        /**
         * Membuat pembayaran untuk transaksi
         *
         * @param Request $request
         * @return RedirectResponse
         */
        public function createPayment(Request $request)
        {
            try {
                DB::beginTransaction();

                $id = $request->id;
                $transaction = Transaction::find($id);

                if (!$transaction) {
                    Log::error('Transaction not found: ' . $id);
                    return redirect()->route('transactions.index')
                                   ->with('error', 'Transaksi tidak ditemukan');
                }

                // Konfirmasi pembayaran dengan user yang sedang login
                $paymentConfirmed = $transaction->confirmPayment();

                if (!$paymentConfirmed) {
                    DB::rollBack();
                    Log::error('Failed to confirm payment for transaction: ' . $id);
                    return redirect()->route('transactions.index')
                                   ->with('error', 'Gagal mengkonfirmasi pembayaran');
                }

                // Update status examination
                $examination = Examination::find($transaction->examination_id);
                if ($examination) {
                    $examination->status = 'done';
                    $examination->save();
                    Log::info('Examination status updated to done: ' . $examination->id);
                }

                DB::commit();
                Log::info('Payment created successfully for transaction: ' . $id . ' by user: ' . Auth::id());

                return redirect()->route('transactions.index')
                            ->with('success', 'Pembayaran berhasil dikonfirmasi');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error creating payment: ' . $e->getMessage());
                return redirect()->route('transactions.index')
                            ->with('error', 'Terjadi kesalahan saat mengkonfirmasi pembayaran');
            }
        }

        public function services(Request $request)
        {
            $id           = $request->id;
            $examination  = Examination::find($id);
            $examinations = Examination::where('user_id', $examination->user_id)
                                       ->where('status', 'done')
                                       ->orderBy('created_at', 'DESC')
                                       ->get();
            $user         = User::find($examination->user_id);
            $info         = $user->info;

            $pemeriksaan_awal = PemeriksaanAwal::where('user_id', $examination->user_id)->first();

            $services          = Service::where('service_category_id', $examination->service_category_id)->get();
            $servicecategories = ServiceCategory::where('is_global', 1)->get();

            return view('pages.klinik.examinations.services', compact([
                'user',
                'info',
                'examination',
                'services',
                'servicecategories',
                'examinations',
                'pemeriksaan_awal'
            ]));
        }

        /**
         * Menyimpan layanan pemeriksaan dan membuat detail transaksi
         *
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Exception
         */
        public function storeservices(Request $request)
        {
            // Log aktivitas awal
            \Log::info('Memulai proses penyimpanan layanan pemeriksaan', [
                'examination_id' => $request->examination_id,
                'user_id' => Auth::id()
            ]);



            // Validasi input request
            $validatedData = $request->validate([
                'examination_id' => 'required|exists:examinations,id',
                'service_id' => 'nullable|array',
                'service_id.*' => 'exists:services,id',
                'payment' => 'nullable|boolean'
            ]);


            try {
                // Mulai database transaction
                \DB::beginTransaction();

                // Ambil data examination dengan relasi yang diperlukan
                $examination = Examination::find($validatedData['examination_id']);
                // Ambil atau buat transaksi
                $transaction = Transaction::firstOrCreate(
                    ['examination_id' => $examination->id],
                    [
                        'amount' => 0,
                        'status' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );



                // Update status appointment jika diperlukan
                $this->updateAppointmentStatus($examination);

                // Proses layanan dan hitung total
                $total = $this->processServices($examination, $transaction, $validatedData);

                // Update total transaksi
                $transaction->update(['amount' => $total]);

                // Commit transaction
                \DB::commit();

                // Log sukses
                \Log::info('Berhasil menyimpan layanan pemeriksaan', [
                    'examination_id' => $examination->id,
                    'transaction_id' => $transaction->id,
                    'total_amount' => $total
                ]);


                // Redirect berdasarkan pilihan payment
                return $this->handleRedirect($request, $transaction, $examination);

            } catch (\Exception $e) {
                // Rollback transaction jika terjadi error
                \DB::rollback();

                // Log error
                \Log::error('Gagal menyimpan layanan pemeriksaan', [
                    'examination_id' => $request->examination_id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                // Return dengan error message
                return redirect()->back()
                    ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan layanan pemeriksaan.'])
                    ->withInput();
            }
        }

        /**
         * Update status appointment jika examination adalah appointment
         *
         * @param Examination $examination
         * @return void
         */
        private function updateAppointmentStatus(Examination $examination): void
        {
            if ($examination->is_appointment == 1) {
                $examination->update([
                    'examination_date' => now(),
                    'appointment_status' => 1
                ]);

                \Log::info('Status appointment berhasil diupdate', [
                    'examination_id' => $examination->id
                ]);
            }
        }

        /**
         * Proses layanan dan hitung total biaya
         *
         * @param Examination $examination
         * @param Transaction $transaction
         * @param array $validatedData
         * @return float
         */
        private function processServices(Examination $examination, Transaction $transaction, array $validatedData): float
        {
            $total = 0;

            if ($examination->package_id !== null) {
                // Proses package
                $total = $this->processPackageService($examination, $transaction);
            } else {
                // Proses individual services
                $total = $this->processIndividualServices($transaction, $validatedData);
            }

            return $total;
        }

        /**
         * Proses layanan package
         *
         * @param Examination $examination
         * @param Transaction $transaction
         * @return float
         */
        private function processPackageService(Examination $examination, Transaction $transaction): float
        {
            $package = Package::findOrFail($examination->package_id);

            // Hapus detail transaksi yang ada
            TransactionDetail::where('transaction_id', $transaction->id)->delete();

            // Buat detail transaksi untuk package
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'status' => 'waiting payment',
                'service_id' => $package->id,
                'name' => $package->name,
                'price' => $package->price,
                'total' => $package->price,
            ]);

            \Log::info('Package service berhasil diproses', [
                'package_id' => $package->id,
                'package_name' => $package->name,
                'price' => $package->price
            ]);

            return $package->price;
        }

        /**
         * Proses layanan individual
         *
         * @param Transaction $transaction
         * @param array $validatedData
         * @return float
         */
        private function processIndividualServices(Transaction $transaction, array $validatedData): float
        {
            $total = 0;

            // Hapus detail transaksi yang ada
            TransactionDetail::where('transaction_id', $transaction->id)->delete();

            if (isset($validatedData['service_id']) && is_array($validatedData['service_id'])) {
                $services = Service::whereIn('id', $validatedData['service_id'])->get();

                foreach ($services as $service) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'status' => 'waiting payment',
                        'service_id' => $service->id,
                        'name' => $service->name,
                        'price' => $service->price,
                        'total' => $service->price,
                    ]);

                    $total += $service->price;
                }

                \Log::info('Individual services berhasil diproses', [
                    'service_count' => count($services),
                    'total_amount' => $total
                ]);
            }

            return $total;
        }

        /**
         * Handle redirect berdasarkan pilihan payment
         *
         * @param Request $request
         * @param Transaction $transaction
         * @param Examination $examination
         * @return \Illuminate\Http\RedirectResponse
         */
        private function handleRedirect(Request $request, Transaction $transaction, Examination $examination)
        {
            if ($request->payment == 1) {
                \Log::info('Redirect ke halaman payment', [
                    'transaction_id' => $transaction->id
                ]);

                return redirect()->route('transactions.edit', ['transaction' => $transaction->id])
                    ->with('success', 'Layanan berhasil disimpan. Silakan lanjutkan ke pembayaran.');
            }

            // Redirect berdasarkan role user
            if (Auth::user()->hasRole('admin')) {
                \Log::info('Admin redirect ke patients index');

                return redirect()->route('patients.index')
                    ->with('success', 'Layanan berhasil disimpan.');
            }

            \Log::info('Redirect ke vitality examination', [
                'examination_id' => $examination->id
            ]);

            return redirect()->route('examinations.vitality', ['id' => $examination->id])
                ->with('success', 'Layanan berhasil disimpan. Silakan lanjutkan ke pemeriksaan vitalitas.');
        }

        public function vitality(Request $request)
        {
            $id                  = $request->id;
            $examination         = Examination::find($id);
            $vitalityexamination = VitalityExamination::where('examination_id', $examination->id)->first();

            if ($examination->encounter_id && $examination->encounter_status == "arrived") {
                $_encounter  = json_decode($examination->encounter);
                $location    = $_encounter->location[0]->location;
                $participant = $_encounter->participant[0]->individual;


                $encounter = new Encounter;
                foreach ($_encounter->identifier as $identifier) {
                    $encounter->addRegistrationId($identifier->value); // e.g., http://sys-ids.kemkes.go.id/patient/P02478375538
                }

                foreach ($_encounter->statusHistory as $history) {
                    if ($_encounter->status == "arrived") {
                        if ($history->status == "arrived") {
                            $encounter->setArrived($history->period->start);
                            $encounter->setInProgress(Carbon::now()->toDateTimeString(), Carbon::now()
                                                                                               ->toDateTimeString());
                        }
                    }
                }

                $encounter->setConsultationMethod('RAJAL'); // RAJAL, IGD, RANAP, HOMECARE, TELEKONSULTASI
                $encounter->setSubject(str_replace('Patient/', '', $_encounter->subject->reference), $_encounter->subject->display);
                $encounter->addParticipant(str_replace('Practitioner/', '', $participant->reference), $participant->display); // ID SATUSEHAT Dokter, Nama Dokter
                $encounter->addLocation(str_replace('Location/', '', $location->reference), $location->display);              // ID SATUSEHAT Location, Nama Poli

                [$status, $res] = $encounter->put($examination->encounter_id);
                if ($status == 200) {
                    $encounter = json_encode($res);

                    $examination->encounter        = $encounter;
                    $examination->encounter_status = $res->status;

                    $examination->save();
                }
            }

            $user             = User::find($examination->user_id);
            $info             = $user->info;
            $pemeriksaan_awal = PemeriksaanAwal::where('user_id', $examination->user_id)->first();

            // get the default inner page
            return view('pages.klinik.examinations.vitality', compact([
                'user',
                'info',
                'examination',
                'vitalityexamination',
                'pemeriksaan_awal'
            ]));
        }

        public function pdf(Request $request)
        {
            $examination = Examination::find($request->id);
            $user        = User::find($examination->user_id);
            $info        = $user->info;

            $data = $request->all();

            // get the default inner page
            /*return view('pages.klinik.examinations.pdf', compact([
                'user', 'info', 'examination'
            ]));*/

            $pdf = Pdf::loadView('pages.klinik.examinations.pdf', compact([
                'user',
                'info',
                'examination',
            ]));
            Storage::put('public/examinations/' . $examination->examination_code . '/1.medical-record.pdf', $pdf->output());
            //return $pdf->download('rekam-medis_'.$user->name.'.pdf');

            $pdfMerge = PDFMerger::init();
            $files    = Storage::disk('public')->files('examinations/' . $examination->examination_code);

            foreach ($files as $key => $value) {
                if (file_exists(storage_path('app/public/' . $value))) {
                    $pdfMerge->addPDF(storage_path('app/public/' . $value), 'all');
                }
            }

            $fileName = $examination->examination_code . '.pdf';
            $pdfMerge->merge();
            $pdfMerge->save(public_path($fileName));

            return response()->download(public_path($fileName));
        }

        public function sehat(Request $request)
        {
            $examination = Examination::find($request->id);
            $user        = User::find($examination->user_id);
            $info        = $user->info;

            // get the default inner page
            $data = json_decode(json_encode($request->all()));
            /*echo json_encode($data);exit;
            return view('pages.klinik.examinations.sehat', compact([
                'user', 'info', 'examination', 'data'
            ]));*/


            $pdf = Pdf::loadView('pages.klinik.examinations.sehat', compact([
                'user',
                'info',
                'examination',
                'data',
            ]));

            return $pdf->download('surat_keterangan_sehat_' . $user->name . '.pdf');
        }

        public function sakit(Request $request)
        {
            $examination = Examination::find($request->id);
            $user        = User::find($examination->user_id);
            $info        = $user->info;

            $data = json_decode(json_encode($request->all()));

            // get the default inner page
            /*return view('pages.klinik.examinations.sakit', compact([
                'user', 'info', 'examination', 'data'
            ]));*/

            $pdf = Pdf::loadView('pages.klinik.examinations.sakit', compact([
                'user',
                'info',
                'examination',
                'data',
            ]));

            return $pdf->download('surat_keterangan_sakit_' . $user->name . '.pdf');
        }

        public function hakkewajiban(Request $request)
        {
            $examination = Examination::find($request->id);
            $user        = User::find($examination->user_id);
            $info        = $user->info;

            // get the default inner page
            $data = json_decode(json_encode($request->all()));
            //echo json_encode($data);exit;
            /*return view('pages.klinik.examinations.hakkewajiban', compact([
                'user', 'info', 'examination', 'data'
            ]));*/


            $pdf = Pdf::loadView('pages.klinik.examinations.hakkewajiban', compact([
                'user',
                'info',
                'examination',
                'data',
            ]));

            return $pdf->download('bukti_penyampaian_informasi_' . $user->name . '.pdf');
        }

        public function persetujuan(Request $request)
        {
            $examination = Examination::find($request->id);
            $user        = User::find($examination->user_id);
            $info        = $user->info;

            // get the default inner page
            $data = json_decode(json_encode($request->all()));
            //echo json_encode($data);exit;
            /* return view('pages.klinik.examinations.persetujuan', compact([
                 'user', 'info', 'examination', 'data'
             ]));*/


            $pdf = Pdf::loadView('pages.klinik.examinations.persetujuan', compact([
                'user',
                'info',
                'examination',
                'data',
            ]));

            return $pdf->download('surat_keterangan_persetujuan_' . $user->name . '.pdf');
        }

        public function surgicalsafetychecklist(Request $request)
        {
            $examination = Examination::find($request->id);
            $user        = User::find($examination->user_id);
            $info        = $user->info;

            // get the default inner page
            $data = json_decode(json_encode($request->all()));
            //echo json_encode($data);exit;
            /* return view('pages.klinik.examinations.surgicalsafetychecklist', compact([
                 'user', 'info', 'examination', 'data'
             ]));*/


            $pdf = Pdf::loadView('pages.klinik.examinations.surgicalsafetychecklist', compact([
                'user',
                'info',
                'examination',
                'data',
            ]));

            return $pdf->download('surat_surgicalsafetychecklist_' . $user->name . '.pdf');
        }

        public function psikososial(Request $request)
        {
            $data        = $request->all();
            $examination = Examination::where('id', $request->examination_id);

            unset($data['_token']);
            unset($data['examination_id']);
            unset($data['_method']);
            unset($data['user_id']);

            if ($examination) {
                $examination->update(['psikososial' => json_encode($data)]);
            }

            return redirect()
                ->route('examinations.edit', ['examination' => $request->examination_id])
                ->with('success', 'Vitality Examination has been updated !!');
        }

        /**
         * Update the specified resource in storage.
         *
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

            $riwayat_kesehatan = "";
            if(isset($examination->psikososial)){
                $riwayat_kesehatan = json_decode($examination->psikososial);
                $riwayat_kesehatan = $riwayat_kesehatan->riwayat_kesehatan ?? "";
            }

            $encounter  = json_decode($examination->encounter, true);
            $encounter_ = '';
            if ($examination->encounter_id && $examination->encounter_status == "in-progress" && !empty($validated['assessment'])) {
                $assessment = explode(' | ', $validated['assessment']);

                $_encounter  = json_decode($examination->encounter);
                $location    = $_encounter->location[0]->location;
                $participant = $_encounter->participant[0]->individual;

                if(isset($riwayat_kesehatan->penyakit_dahulu) && is_array($riwayat_kesehatan->penyakit_dahulu)) {
                    foreach ($riwayat_kesehatan->penyakit_dahulu as $key => $value) {
                        $condition = new PersonalDisease;
                        $condition->addClinicalStatus('active');                  // active, inactive, resolved. Default bila tidak dideklarasi = active
                        $condition->addCategory('previous-condition');            // Diagnosis, Keluhan. Default : Diagnosis
                        $condition->addCode($value);                              // Kode ICD10
                        $condition->setOnsetDateTime(Carbon::now()
                                                           ->toDateTimeString()); // timestamp onset. Timestamp sekarang
                        $condition->setSubject(str_replace('Patient/', '', $_encounter->subject->reference), $_encounter->subject->display);
                        $condition->setRecordedDate(Carbon::now()
                                                          ->toDateTimeString());  // timestamp recorded. Timestamp sekarang
                        $condition->setEncounter($examination->encounter_id);
                        $condition->post();
                    }
                }

                if(isset($riwayat_kesehatan->penyakit_keluarga) && is_array($riwayat_kesehatan->penyakit_keluarga)) {
                    foreach ($riwayat_kesehatan->penyakit_keluarga as $key => $value) {
                        $condition = new FamilyDisease;
                        $condition->addClinicalStatus('active');                  // active, inactive, resolved. Default bila tidak dideklarasi = active
                        $condition->addCategory('FAMMEMB');            // Diagnosis, Keluhan. Default : Diagnosis
                        $condition->addCode($value);                              // Kode ICD10
                        $condition->setOnsetDateTime(Carbon::now()
                                                           ->toDateTimeString()); // timestamp onset. Timestamp sekarang
                        $condition->setSubject(str_replace('Patient/', '', $_encounter->subject->reference), $_encounter->subject->display);
                        $condition->setRecordedDate(Carbon::now()
                                                          ->toDateTimeString());  // timestamp recorded. Timestamp sekarang
                        $condition->setEncounter($examination->encounter_id);
                        $condition->post();
                    }
                }

                $encounter = new Encounter;
                foreach ($assessment as $row) {
                    $row_ = explode(' - ', $row);
                    if (isset($row_[1])) {
                        $condition = new Condition;
                        $condition->addClinicalStatus('active'); // active, inactive, resolved. Default bila tidak dideklarasi = active
                        $condition->addCategory('diagnosis');    // Diagnosis, Keluhan. Default : Diagnosis
                        $condition->addCode($row_[0]);           // Kode ICD10
                        $condition->setSubject(str_replace('Patient/', '', $_encounter->subject->reference), $_encounter->subject->display);
                        $condition->setEncounter($examination->encounter_id);     // ID SATUSEHAT Encounter
                        $condition->setOnsetDateTime(Carbon::now()
                                                           ->toDateTimeString()); // timestamp onset. Timestamp sekarang
                        $condition->setRecordedDate(Carbon::now()
                                                          ->toDateTimeString());  // timestamp recorded. Timestamp sekarang
                        [$statusC, $resC] = $condition->post();

                        $encounter->addDiagnosis($resC->id, $row_[0]);
                    }
                }


                foreach ($_encounter->identifier as $identifier) {
                    $encounter->addRegistrationId($identifier->value); // e.g., http://sys-ids.kemkes.go.id/patient/P02478375538
                }

                foreach ($_encounter->statusHistory as $history) {
                    if ($_encounter->status == "in-progress") {
                        if ($history->status == "arrived") {
                            $encounter->setArrived($history->period->start);
                        }

                        if ($history->status == "in-progress") {
                            $encounter->setInProgress($history->period->start, Carbon::now()->toDateTimeString());
                            $encounter->setFinished(Carbon::now()->toDateTimeString());
                        }
                    }
                }

                $encounter->setConsultationMethod('RAJAL'); // RAJAL, IGD, RANAP, HOMECARE, TELEKONSULTASI
                $encounter->setSubject(str_replace('Patient/', '', $_encounter->subject->reference), $_encounter->subject->display);
                $encounter->addParticipant(str_replace('Practitioner/', '', $participant->reference), $participant->display); // ID SATUSEHAT Dokter, Nama Dokter
                $encounter->addLocation(str_replace('Location/', '', $location->reference), $location->display);              // ID SATUSEHAT Location, Nama Poli

                [$status, $res] = $encounter->put($examination->encounter_id);
                if ($status == 200) {
                    $encounter                     = json_encode($res);
                    $validated['encounter']        = $encounter;
                    $validated['encounter_status'] = $res->status;
                }
            }

            // Process Data
            if ($validated) {
                // Process Data
                try {
                    $validated['status'] = 'done';
                    $validated['resep']  = json_encode($request->resep);
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

        public function penandaan_operasi(Request $request)
        {
            $examination = Examination::find($request->id);
            $user        = User::find($examination->user_id);
            $info        = $user->info;

            // get the default inner page
            $data = json_decode(json_encode($request->all()));
            //echo json_encode($data);exit;
            /*return view('pages.klinik.examinations.operasi', compact([
                'user', 'info', 'examination', 'data'
            ]));*/


            $pdf = Pdf::loadView('pages.klinik.examinations.operasi', compact([
                'user',
                'info',
                'examination',
                'data',
            ]));

            return $pdf->download('penandaan_lokasi_operasi' . $user->name . '.pdf');
        }

        public function komunikasi_efektif(Request $request)
        {
            // Validasi input
            $validatedData = $request->validate([
                'id'                     => 'required|exists:examinations,id',
                'health_professional_id' => 'required|exists:health_professionals,id',
                'situation'              => 'required',
                'background'             => 'required',
                'assessment'             => 'required',
                'recommendation'         => 'required',
            ]);

            // Simpan data ke dalam database
            $examination = Examination::find($request->id);
            $examination->situations()->create([
                'health_professional_id' => $request->health_professional_id,
                'situation'              => $request->input('situation'),
                'background'             => $request->input('background'),
                'assessment'             => $request->input('assessment'),
                'recommendation'         => $request->input('recommendation'),
            ]);

            // Redirect ke halaman list untuk melihat status
            return redirect()->route('komunikasi.efektif.status', $examination->id)
                             ->with('success', 'Data berhasil disimpan dan bisa dilihat di daftar status.');
        }

    }
