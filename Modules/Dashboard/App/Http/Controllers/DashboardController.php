<?php

namespace Modules\Dashboard\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
}
