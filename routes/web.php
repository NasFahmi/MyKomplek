<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;


Route::get('/', action: [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authLogin'])->name('login.auth');

// Auth Routes
Route::middleware('auth')->group(function () {


    // Pengaturan
    Route::get('/pengaturan', [SettingController::class, 'index'])->name('pengaturan.index');


    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Rumah
    Route::get('/rumah', [HouseController::class, 'index'])->name('rumah.index');
    Route::get('/rumah/create', [HouseController::class, 'create'])->name('rumah.create');
    Route::post('/rumah/create', [HouseController::class, 'store'])->name('rumah.store');
    Route::get('/rumah/{house}', [HouseController::class, 'show'])->name('rumah.show');
    Route::get('/rumah/{house}/edit', [HouseController::class, 'edit'])->name('rumah.edit');
    Route::put('/rumah/{house}', [HouseController::class, 'update'])->name('rumah.update');
    Route::delete('/rumah/{house}', [HouseController::class, 'destroy'])->name('rumah.destroy');

    // create penghuni from rumah
    Route::get('/rumah/{house}/create-penghuni', [HouseController::class, 'createResident'])->name('rumah.create-penghuni');
    Route::post('/rumah/{house}/create-penghuni', [HouseController::class, 'storeResident'])->name('rumah.store-penghuni');

    //detail penghuni from rumah
    Route::get('/rumah/{house}/penghuni/{resident}', [HouseController::class, 'showResident'])->name('rumah.show-penghuni');

    // penghuni checkout from rumah
    Route::patch('/rumah/${house}/penghuni/{resident}/checkout', [HouseController::class, 'checkoutResident'])->name('rumah.show-penghuni-checkout');


    // Warga
    Route::get('/warga', [ResidentController::class, 'index'])->name('warga.index');
    Route::get('/warga/create', [ResidentController::class, 'create'])->name('warga.create');
    Route::post('/warga/create', [ResidentController::class, 'store'])->name('warga.store');
    Route::get('/warga/{resident}', [ResidentController::class, 'show'])->name('warga.show');
    Route::get('/warga/{resident}/edit', [ResidentController::class, 'edit'])->name('warga.edit');
    Route::put('/warga/{resident}', [ResidentController::class, 'update'])->name('warga.update');
    Route::delete('/warga/{resident}', [ResidentController::class, 'destroy'])->name('warga.destroy');

    // warga checkout
    Route::patch('/warga/{resident}', [ResidentController::class, 'checkout'])->name('warga.checkout');

    // Pembayaran
    Route::get('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran.index');

    // Pengeluaran
    Route::get('/pengeluaran', [ExpenseController::class, 'index'])->name('pengeluaran.index');


    Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('reset-password.index');
    Route::put('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.put');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

