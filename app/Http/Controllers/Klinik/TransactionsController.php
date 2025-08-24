<?php

namespace App\Http\Controllers\Klinik;

use App\DataTables\Klinik\TransactionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klinik\{
    Examination,
    Service,
    ServiceCategory,
    Transaction,
    TransactionDetail
};
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\{Request, RedirectResponse, Response};
use Illuminate\Support\Facades\{Auth, DB, Log};
use Illuminate\View\View;
use Exception;

/**
 * Controller untuk mengelola transaksi klinik
 * Menangani CRUD operations untuk transaksi dan detail transaksi
 */
class TransactionsController extends Controller
{
    public $user;

    /**
     * Inisialisasi middleware untuk autentikasi
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar transaksi
     *
     * @param TransactionsDataTable $dataTable
     * @return Response|View
     */
    public function index(TransactionsDataTable $dataTable)
    {
        Log::info('Mengakses halaman index transaksi', ['user_id' => $this->user?->id]);

        if (is_null($this->user) || !$this->user->can('klinik.read')) {
            Log::warning('Akses ditolak untuk melihat transaksi', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk melihat data transaksi!');
        }

        return $dataTable->render('pages.klinik.transactions.index');
    }

    /**
     * Menampilkan form untuk membuat transaksi baru
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function create(Request $request)
    {
        Log::info('Mengakses form create transaksi', [
            'user_id' => $this->user?->id,
            'examination_id' => $request->id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk membuat transaksi', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat transaksi!');
        }

        try {
            DB::beginTransaction();

            // Cari atau buat transaksi baru
            $transaction = $this->findOrCreateTransaction($request->id);

            // Ambil data yang diperlukan
            $examination = Examination::findOrFail($transaction->examination_id);
            $category = $this->getServiceCategory($examination->service_category_id);
            $services = $this->getGlobalServices();

            DB::commit();

            Log::info('Berhasil memuat form create transaksi', [
                'transaction_id' => $transaction->id,
                'examination_id' => $examination->id
            ]);

            return view('pages.klinik.transactions.edit', compact(
                'transaction', 'category', 'services', 'examination'
            ));

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal memuat form create transaksi', [
                'error' => $e->getMessage(),
                'examination_id' => $request->id
            ]);

            session()->flash('error', 'Terjadi kesalahan saat memuat form transaksi!');
            return redirect()->route('transactions.index');
        }
    }

    /**
     * Menyimpan transaksi baru ke database
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('Memulai proses store transaksi', [
            'user_id' => $this->user?->id,
            'transaction_id' => $request->transaction_id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.create')) {
            Log::warning('Akses ditolak untuk menyimpan transaksi', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk membuat transaksi!');
        }

        try {
            DB::beginTransaction();

            $transaction = Transaction::findOrFail($request->transaction_id);
            $total = $this->processTransactionDetails($request, $transaction);

            // Update transaksi
            $transaction->update([
                'amount' => $total,
                'notes' => $request->notes,
                'status' => 'waiting payment',
                'updated_by' => $this->user->id
            ]);

            DB::commit();

            Log::info('Berhasil menyimpan transaksi', [
                'transaction_id' => $transaction->id,
                'total_amount' => $total
            ]);

            session()->flash('success', 'Transaksi berhasil dibuat!');
            return redirect()->route('transactions.index');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan transaksi', [
                'error' => $e->getMessage(),
                'transaction_id' => $request->transaction_id
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menyimpan transaksi!');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Menampilkan detail transaksi
     *
     * @param Transaction $transaction
     * @return Response
     */
    public function show(Transaction $transaction)
    {
        Log::info('Mengakses detail transaksi', [
            'user_id' => $this->user?->id,
            'transaction_id' => $transaction->id
        ]);

        // TODO: Implementasi show method
        return response()->json(['message' => 'Method belum diimplementasi']);
    }

    /**
     * Menampilkan form edit transaksi
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id)
    {
        Log::info('Mengakses form edit transaksi', [
            'user_id' => $this->user?->id,
            'transaction_id' => $id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk edit transaksi', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit transaksi!');
        }

        try {
            $transaction = Transaction::findOrFail($id);
            $examination = Examination::findOrFail($transaction->examination_id);
            $category = $this->getServiceCategory($examination->service_category_id);
            $services = $this->getGlobalServices();

            Log::info('Berhasil memuat form edit transaksi', ['transaction_id' => $id]);

            return view('pages.klinik.transactions.edit', compact(
                'transaction', 'category', 'services', 'examination'
            ));

        } catch (Exception $e) {
            Log::error('Gagal memuat form edit transaksi', [
                'error' => $e->getMessage(),
                'transaction_id' => $id
            ]);

            session()->flash('error', 'Transaksi tidak ditemukan!');
            return redirect()->route('transactions.index');
        }
    }

    /**
     * Menampilkan halaman service untuk transaksi
     *
     * @param Request $request
     */
    public function service(Request $request)
    {
        Log::info('Mengakses halaman service transaksi', [
            'user_id' => $this->user?->id,
            'transaction_id' => $request->id
        ]);

        try {
            $transaction = Transaction::findOrFail($request->id);
            $transactionDetail = TransactionDetail::where('transaction_id', $request->id)
                ->pluck('service_id')
                ->toArray();

            $examination = Examination::findOrFail($transaction->examination_id);
            $examinations = Examination::where('user_id', $examination->user_id)
                ->where('status', 'done')
                ->orderBy('created_at', 'DESC')
                ->get();

            $user = User::findOrFail($examination->user_id);
            $info = $user->info;

            $services = Service::where('service_category_id', $examination->service_category_id)->get();
            $category = $this->getServiceCategory($examination->service_category_id);
            $servicecategories = ServiceCategory::where('is_global', 1)->get();

            Log::info('Berhasil memuat halaman service', ['transaction_id' => $request->id]);

            return view('pages.klinik.transactions.services', compact(
                'user', 'info', 'examination', 'services', 'category',
                'servicecategories', 'transaction', 'transactionDetail', 'examinations'
            ));

        } catch (Exception $e) {
            Log::error('Gagal memuat halaman service', [
                'error' => $e->getMessage(),
                'transaction_id' => $request->id
            ]);

            session()->flash('error', 'Terjadi kesalahan saat memuat data service!');
            return redirect()->route('transactions.index');
        }
    }

    /**
     * Update transaksi yang sudah ada
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return RedirectResponse
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        Log::info('Memulai proses update transaksi', [
            'user_id' => $this->user?->id,
            'transaction_id' => $request->transaction_id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.update')) {
            Log::warning('Akses ditolak untuk update transaksi', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk mengedit transaksi!');
        }

        try {
            DB::beginTransaction();

            $transaction = Transaction::findOrFail($request->transaction_id);

            // Hapus detail transaksi yang lama
            TransactionDetail::where('transaction_id', $transaction->id)->delete();

            $total = $this->processTransactionDetailsWithService($request, $transaction);

            // Update transaksi
            $transaction->update([
                'amount' => $total,
                'notes' => $request->notes,
                'status' => 'waiting payment',
                'metode_pembayaran' => $request->metode_pembayaran
            ]);

            DB::commit();

            Log::info('Berhasil update transaksi', [
                'transaction_id' => $transaction->id,
                'total_amount' => $total
            ]);

            session()->flash('success', 'Transaksi berhasil diperbarui!');
            return redirect()->route('transactions.index');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal update transaksi', [
                'error' => $e->getMessage(),
                'transaction_id' => $request->transaction_id
            ]);

            session()->flash('error', 'Terjadi kesalahan saat memperbarui transaksi!');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Hapus transaksi
     *
     * @param Transaction $transaction
     * @return RedirectResponse
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        Log::info('Memulai proses hapus transaksi', [
            'user_id' => $this->user?->id,
            'transaction_id' => $transaction->id
        ]);

        if (is_null($this->user) || !$this->user->can('klinik.delete')) {
            Log::warning('Akses ditolak untuk hapus transaksi', ['user_id' => $this->user?->id]);
            abort(403, 'Maaf! Anda tidak memiliki izin untuk menghapus transaksi!');
        }

        try {
            DB::beginTransaction();

            $transaction->delete();

            DB::commit();

            Log::info('Berhasil hapus transaksi', ['transaction_id' => $transaction->id]);

            session()->flash('success', 'Transaksi berhasil dihapus!');
            return redirect()->route('transactions.index');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal hapus transaksi', [
                'error' => $e->getMessage(),
                'transaction_id' => $transaction->id
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menghapus transaksi!');
            return redirect()->route('transactions.index');
        }
    }

    /**
     * Mencari atau membuat transaksi baru
     *
     * @param int $examinationId
     * @return Transaction
     */
    private function findOrCreateTransaction(int $examinationId): Transaction
    {
        $transaction = Transaction::where('examination_id', $examinationId)->first();

        if (!$transaction) {
            $transaction = Transaction::create([
                'examination_id' => $examinationId
            ]);

            Log::info('Transaksi baru dibuat', [
                'transaction_id' => $transaction->id,
                'examination_id' => $examinationId
            ]);
        }

        return $transaction;
    }

    /**
     * Mendapatkan kategori service dengan relasi
     *
     * @param int $categoryId
     * @return ServiceCategory
     */
    private function getServiceCategory(int $categoryId): ServiceCategory
    {
        return ServiceCategory::with('services')
            ->where('id', $categoryId)
            ->firstOrFail();
    }

    /**
     * Mendapatkan service global
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getGlobalServices()
    {
        return Service::whereHas('category', function (Builder $query) {
            return $query->where('is_global', 1);
        })->get();
    }

    /**
     * Memproses detail transaksi untuk store
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return float
     */
    private function processTransactionDetails(Request $request, Transaction $transaction): float
    {
        $total = 0;

        foreach ($request->name as $key => $value) {
            if ($value != null) {
                $price = $this->cleanPrice($request->price[$key]);
                $quantity = (int) $request->quantity[$key];
                $subtotal = $price * $quantity;

                $transaction->transactionDetails()->create([
                    'name' => $value,
                    'description' => $request->description[$key] ?? null,
                    'price' => $price,
                    'qty' => $quantity,
                    'total' => $subtotal,
                ]);

                $total += $subtotal;
            }
        }

        return $total;
    }

    /**
     * Memproses detail transaksi dengan service untuk update
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return float
     */
    private function processTransactionDetailsWithService(Request $request, Transaction $transaction): float
    {
        $total = 0;

        foreach ($request->service_id as $key => $value) {
            if ($value != null) {
                $price = $this->cleanPrice($request->price[$key]);
                $quantity = (int) $request->quantity[$key];
                $subtotal = $price * $quantity;

                $service = Service::findOrFail($request->service_id[$key]);

                $detailId = $request->id[$key] ?? null;

                TransactionDetail::updateOrCreate(
                    ['id' => $detailId, 'transaction_id' => $request->transaction_id],
                    [
                        'service_id' => $request->service_id[$key],
                        'name' => $service->name,
                        'description' => $request->description[$key] ?? null,
                        'price' => $price,
                        'qty' => $quantity,
                        'total' => $subtotal,
                    ]
                );

                $total += $subtotal;
            }
        }

        return $total;
    }

    /**
     * Membersihkan format harga
     *
     * @param string $price
     * @return float
     */
    private function cleanPrice(string $price): float
    {
        $cleanPrice = str_replace(['.00', ','], ['', ''], $price);
        return (float) $cleanPrice;
    }
}
