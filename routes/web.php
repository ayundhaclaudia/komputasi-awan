<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BillController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [BillController::class, 'index'])
        ->name('dashboard');

    Route::get('/bills/create', [BillController::class, 'create'])
        ->name('bills.create');

    Route::post('/bills', [BillController::class, 'store'])
        ->name('bills.store');

    // ===== UPGRADE =====
    Route::get('/upgrade', function () {
        return view('upgrade');
    })->name('upgrade');

    Route::post('/upgrade/activate', function () {
        $user = Auth::user();
        $user->is_premium = 1;
        $user->save();

        return redirect()->route('dashboard')
            ->with('success', 'Akun kamu sekarang Premium ⭐');
    })->name('upgrade.activate');
});

require __DIR__.'/auth.php';
