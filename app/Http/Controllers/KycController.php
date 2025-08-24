<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KycDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Satusehat\Integration\KYC;

class KycController extends Controller
{
    public function index()
    {
        // Check SATUSEHAT_ENV if not PROD, redirect to home with error message
        if(env('SATUSEHAT_ENV')!="PROD"){
            return redirect('/')->with('error', 'KYC memerlukan settingan environment SATUSEHAT Production.');
        }

        $kyc = new KYC;

        // Pass current user name and NIK to generate URL
        $user = Auth::user();

        // Generate URL KYC
        // Check if user has card_number
        if (!$user->info || !$user->info->card_number) {
            return redirect('/')->with('error', 'Anda tidak memiliki NIK yang terdaftar. Silakan lengkapi data diri Anda terlebih dahulu.');
        }
        $json = $kyc->generateUrl($user->name, $user->info->card_number);
        $kyc_link = json_decode($json, true);

        return redirect($kyc_link['data']['url']);
    }
}
