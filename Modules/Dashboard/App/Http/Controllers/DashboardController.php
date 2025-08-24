<?php

namespace Modules\Dashboard\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Klinik\Patient;
use App\Models\Klinik\Examination;
use App\Models\Klinik\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama
     * Redirect ke login jika user belum terautentikasi
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Log akses ke dashboard
        Log::info('Dashboard accessed', [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()
        ]);

        // Cek apakah user sudah login
        if (!Auth::check()) {
            Log::warning('Unauthorized dashboard access attempt', [
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'timestamp' => now()
            ]);

            return redirect()->route('login')->with('warning', 'Silakan login terlebih dahulu untuk mengakses dashboard.');
        }

        $user = Auth::user();
        $kyc_iframe = true;

        // Log successful dashboard access
        Log::info('Dashboard accessed successfully', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'timestamp' => now()
        ]);

        return view('dashboard::index', compact('user','kyc_iframe'));
    }

    /**
     * Mengambil data statistik dashboard
     * Mengembalikan data dalam format JSON untuk AJAX request
     *
     * @return JsonResponse
     */
    public function getStats(): JsonResponse
    {
        try {
            // Log request untuk statistik
            Log::info('Dashboard stats requested', [
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            DB::beginTransaction();

            // Hitung total pasien
            $totalPatients = Patient::whereNull('deleted_at')->count();

            // Hitung pasien baru hari ini
            $newPatientsToday = Patient::whereDate('register_date', Carbon::today())
                ->whereNull('deleted_at')
                ->count();

            // Hitung total pemeriksaan
            $totalExaminations = Examination::whereDate('examination_date', Carbon::today())
                ->whereNull('deleted_at')
                ->count();

            // Hitung antrian hari ini (pemeriksaan dengan status pending/waiting)
            $todayQueue = Examination::whereDate('examination_date', Carbon::today())
                ->whereIn('status', ['pending', 'waiting', 'scheduled'])
                ->whereNull('deleted_at')
                ->count();

            // Hitung total revenue dari transaksi yang sudah dibayar + total resep
            $totalRevenue = Transaction::where('status', 'paid')
                ->whereNull('deleted_at')
                ->whereDate('created_at', Carbon::today())
                ->whereDate('updated_at', Carbon::today())
                ->sum('amount');

            // Tambahkan kalkulasi total resep untuk revenue
            $totalRevenueResep = 0;
            $paidTransactions = Transaction::where('status', 'paid')
                ->whereNull('deleted_at')
                ->whereDate('created_at', Carbon::today())
                ->whereDate('updated_at', Carbon::today())
                ->with('examination')
                ->get();

            foreach ($paidTransactions as $transaction) {
                if ($transaction->examination && $transaction->examination->resep) {
                    $resep = json_decode($transaction->examination->resep);
                    if (isset($resep->obat)) {
                        $obat = $resep->obat;
                        $qty = $resep->qty;
                        foreach ($obat as $key => $value) {
                            if (isset(getObat($value)->name)) {
                                $totalRevenueResep += $qty[$key] * getObat($value)->price;
                            }
                        }
                    }
                }
            }

            $totalRevenue += $totalRevenueResep;

            // Hitung pending payment hari ini + total resep
            $pendingPayment = Transaction::whereIn('status', ['waiting payment', 'waiting'])
                ->whereNull('deleted_at')
                ->whereDate('created_at', Carbon::today())
                ->sum('amount');

            // Tambahkan kalkulasi total resep untuk pending payment
            $pendingPaymentResep = 0;
            $pendingTransactions = Transaction::whereIn('status', ['waiting payment', 'waiting'])
                ->whereNull('deleted_at')
                ->whereDate('created_at', Carbon::today())
                ->with('examination')
                ->get();

            foreach ($pendingTransactions as $transaction) {
                if ($transaction->examination && $transaction->examination->resep) {
                    $resep = json_decode($transaction->examination->resep);
                    if (isset($resep->obat)) {
                        $obat = $resep->obat;
                        $qty = $resep->qty;
                        foreach ($obat as $key => $value) {
                            if (isset(getObat($value)->name)) {
                                $pendingPaymentResep += $qty[$key] * getObat($value)->price;
                            }
                        }
                    }
                }
            }

            $pendingPayment += $pendingPaymentResep;

            $stats = [
                'patients' => $totalPatients,
                'new_patients' => $newPatientsToday,
                'examinations' => $totalExaminations,
                'queue' => $todayQueue,
                'revenue' => $totalRevenue,
                'pending_payment' => $pendingPayment
            ];

            DB::commit();

            // Log successful stats retrieval
            Log::info('Dashboard stats retrieved successfully', [
                'user_id' => Auth::id(),
                'stats' => $stats,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error
            Log::error('Failed to retrieve dashboard stats', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data statistik dashboard'
            ], 500);
        }
    }

    /**
     * Mengambil statistik kenaikan pasien harian
     * Mengembalikan data 30 hari terakhir
     *
     * @return JsonResponse
     */
    public function getDailyPatientStats(): JsonResponse
    {
        try {
            // Log request untuk statistik harian
            Log::info('Daily patient stats requested', [
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            DB::beginTransaction();

            // Ambil data 30 hari terakhir
            $dailyStats = Patient::selectRaw('DATE(registration_date) as date, COUNT(*) as count')
                ->where('registration_date', '>=', Carbon::now()->subDays(30))
                ->whereNull('deleted_at')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get()
                ->keyBy('date');

            // Buat array untuk 30 hari terakhir dengan nilai 0 jika tidak ada data
            $result = [];
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $result[] = [
                    'date' => $date,
                    'count' => $dailyStats->get($date)->count ?? 0,
                    'formatted_date' => Carbon::parse($date)->format('d M')
                ];
            }

            DB::commit();

            // Log successful stats retrieval
            Log::info('Daily patient stats retrieved successfully', [
                'user_id' => Auth::id(),
                'days_count' => count($result),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'data' => $result
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error
            Log::error('Failed to retrieve daily patient stats', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data statistik harian pasien'
            ], 500);
        }
    }

    /**
     * Mengambil statistik kenaikan pasien bulanan
     * Mengembalikan data 12 bulan terakhir
     *
     * @return JsonResponse
     */
    public function getMonthlyPatientStats(): JsonResponse
    {
        try {
            // Log request untuk statistik bulanan
            Log::info('Monthly patient stats requested', [
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            DB::beginTransaction();

            // Ambil data 12 bulan terakhir
            $monthlyStats = Patient::selectRaw('YEAR(registration_date) as year, MONTH(registration_date) as month, COUNT(*) as count')
                ->where('registration_date', '>=', Carbon::now()->subMonths(12))
                ->whereNull('deleted_at')
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get()
                ->keyBy(function($item) {
                    return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                });

            // Buat array untuk 12 bulan terakhir dengan nilai 0 jika tidak ada data
            $result = [];
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $key = $date->format('Y-m');
                $result[] = [
                    'month' => $key,
                    'count' => $monthlyStats->get($key)->count ?? 0,
                    'formatted_month' => $date->format('M Y')
                ];
            }

            DB::commit();

            // Log successful stats retrieval
            Log::info('Monthly patient stats retrieved successfully', [
                'user_id' => Auth::id(),
                'months_count' => count($result),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'data' => $result
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error
            Log::error('Failed to retrieve monthly patient stats', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data statistik bulanan pasien'
            ], 500);
        }
    }

    /**
     * Mengambil ringkasan statistik komprehensif
     * Menggabungkan berbagai data statistik untuk dashboard
     *
     * @return JsonResponse
     */
    public function getComprehensiveStats(): JsonResponse
    {
        try {
            // Log request untuk statistik komprehensif
            Log::info('Comprehensive stats requested', [
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            DB::beginTransaction();

            // Statistik hari ini
            $today = Carbon::today();
            $todayPatients = Patient::whereDate('registration_date', $today)
                ->whereNull('deleted_at')
                ->count();

            $todayExaminations = Examination::whereDate('examination_date', $today)
                ->whereNull('deleted_at')
                ->count();

            $todayRevenue = Transaction::whereDate('created_at', $today)
                ->where('status', 'paid')
                ->whereNull('deleted_at')
                ->sum('amount');

            // Statistik minggu ini
            $weekStart = Carbon::now()->startOfWeek();
            $weekPatients = Patient::where('registration_date', '>=', $weekStart)
                ->whereNull('deleted_at')
                ->count();

            // Statistik bulan ini
            $monthStart = Carbon::now()->startOfMonth();
            $monthPatients = Patient::where('registration_date', '>=', $monthStart)
                ->whereNull('deleted_at')
                ->count();

            $monthRevenue = Transaction::where('created_at', '>=', $monthStart)
                ->where('status', 'paid')
                ->whereNull('deleted_at')
                ->sum('amount');

            // Persentase pertumbuhan bulan ini vs bulan lalu
            $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
            $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
            $lastMonthPatients = Patient::whereBetween('registration_date', [$lastMonthStart, $lastMonthEnd])
                ->whereNull('deleted_at')
                ->count();

            $growthPercentage = $lastMonthPatients > 0
                ? round((($monthPatients - $lastMonthPatients) / $lastMonthPatients) * 100, 2)
                : 0;

            $comprehensiveStats = [
                'today' => [
                    'patients' => $todayPatients,
                    'examinations' => $todayExaminations,
                    'revenue' => $todayRevenue
                ],
                'week' => [
                    'patients' => $weekPatients
                ],
                'month' => [
                    'patients' => $monthPatients,
                    'revenue' => $monthRevenue,
                    'growth_percentage' => $growthPercentage
                ],
                'last_month' => [
                    'patients' => $lastMonthPatients
                ]
            ];

            DB::commit();

            // Log successful stats retrieval
            Log::info('Comprehensive stats retrieved successfully', [
                'user_id' => Auth::id(),
                'stats' => $comprehensiveStats,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'data' => $comprehensiveStats
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error
            Log::error('Failed to retrieve comprehensive stats', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data statistik komprehensif'
            ], 500);
        }
    }
}
