<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpgradeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------|
| GUEST
|--------------------------------------------------------------------------|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');



/*
|--------------------------------------------------------------------------
| LANDING / GUEST
|--------------------------------------------------------------------------
*/
Route::get('/fitur', [BillController::class, 'fitur'])->name('fitur');
Route::get('/manfaat', [BillController::class, 'manfaat'])->name('manfaat');
Route::get('/harga', [BillController::class, 'harga'])->name('harga');
Route::get('/bantuan', [BillController::class, 'bantuan'])->name('bantuan');

/*
|--------------------------------------------------------------------------|
| AUTHENTICATED USER
|--------------------------------------------------------------------------|
*/



Route::middleware('auth')->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');



    /*
    |--------------------------------------------------------------------------|
    | DASHBOARD (SATU-SATUNYA DASHBOARD)
    |--------------------------------------------------------------------------|
    */
    Route::get('/dashboard', [BillController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------|
    | BILLS
    |--------------------------------------------------------------------------|
    */
    Route::get('/bills/index', [BillController::class, 'index'])->name('bills.index');
    Route::get('/bills/create', [BillController::class, 'create'])->name('bills.create');
    Route::post('/bills', [BillController::class, 'store'])->name('bills.store');
    Route::get('/bills/{bill}/edit', [BillController::class, 'edit'])->name('bills.edit');
    Route::put('/bills/{bill}', [BillController::class, 'update'])->name('bills.update');
    Route::delete('/bills/{bill}', [BillController::class, 'destroy'])->name('bills.destroy');

    /*
    |--------------------------------------------------------------------------|
    | EXPORT (PREMIUM ONLY – DIKUNCI DI CONTROLLER)
    |--------------------------------------------------------------------------|
    */
    Route::get('/bills/export', [BillController::class, 'export'])
        ->name('bills.export');

    /*
    |--------------------------------------------------------------------------|
    | TEST REMINDER
    |--------------------------------------------------------------------------|
    */
    Route::post('/bills/{bill}/test-reminder', function (\App\Models\Bill $bill) {
        $user = auth()->user();

        if ($bill->user_id !== $user->id) {
            abort(403);
        }

        if ($user->isPremium()) {
            \Illuminate\Support\Facades\Mail::to($user->email)
                ->send(new \App\Mail\BillReminderMail($bill));
        }

        return back()->with('success', '🔔 Test reminder berhasil dikirim');
    })->name('bills.testReminder');

    /*
|--------------------------------------------------------------------------
| UPGRADE PREMIUM
|--------------------------------------------------------------------------
*/
Route::get('/upgrade', [UpgradeController::class, 'index'])
    ->name('upgrade.index');

Route::post('/upgrade/pay', [UpgradeController::class, 'pay'])
    ->name('upgrade.pay');

/*
|--------------------------------------------------------------------------
| DUMMY SUCCESS (SET PREMIUM)
|--------------------------------------------------------------------------
*/
Route::post('/upgrade/success', function () {
    $user = auth()->user();

    $user->is_premium = true;
    $user->save();

    return response()->json(['success' => true]);
})->name('upgrade.success');

/*
|--------------------------------------------------------------------------
| MIDTRANS CALLBACK (OPSIONAL)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/callback', [UpgradeController::class, 'callback']);

});



Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users');
    });


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
