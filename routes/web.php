<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', action: [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authLogin'])->name('login.auth');

// Auth Routes
Route::middleware('auth')->group(function () {


    // Pengaturan
    Route::get('/pengaturan', function () {
        return view('pages.dashboard.pengaturan.index');
    })->name('pengaturan.index');


    // Dashboard
    Route::get('/dashboard', function () {
        return view('pages.dashboard.index');
    })->name('dashboard.index');

    // Rumah
    Route::get('/rumah', function () {
        return view('pages.dashboard.rumah.index');
    })->name('rumah.index');

    // Warga
    Route::get('/warga', function () {
        return view('pages.dashboard.warga.index');
    })->name('warga.index');

    // Pembayaran
    Route::get('/pembayaran', function () {
        return view('pages.dashboard.pembayaran.index');
    })->name('pembayaran.index');

    // Pengeluaran
    Route::get('/pengeluaran', function () {
        return view('pages.dashboard.pengeluaran.index');
    })->name('pengeluaran.index');


    Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('reset-password.index');
    Route::put('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.put');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

