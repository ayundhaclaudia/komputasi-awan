<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Subscription;
use Carbon\Carbon;


class UpgradeController extends Controller
{
    public function index()
    {
        return view('upgrade.index');
    }


    public function pay()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $user = auth()->user();

        $params = [
            'transaction_details' => [
                'order_id' => 'UPGRADE-' . uniqid(),
                'gross_amount' => 50000,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'token' => $snapToken
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | 🔥 DUMMY SUCCESS (UNTUK UAS / SANDBOX)
    |--------------------------------------------------------------------------
    */
    public function success()
    {
        $user = auth()->user();

        $user->update([
            'is_premium' => true
        ]);

        return redirect()->route('dashboard')
            ->with('success', '🎉 Akun kamu berhasil upgrade ke Premium');
    }

    /*
    |--------------------------------------------------------------------------
    | REAL CALLBACK (OPSIONAL, BOLEH ADA)
    |--------------------------------------------------------------------------
    */
    public function callback(Request $request)
    {
        // untuk UAS boleh dikosongkan / tidak dipakai
        return response()->json(['status' => 'ok']);
    }
}
