<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        return view('pages.auth.login');
    }
    public function authLogin(LoginRequest $request)
    {
        try {
            $data = $request->validated();
            if ($this->userService->login($data)) {
                return redirect()->route('dashboard.index')->with('success', 'Login berhasil.');
            }
            return back()->with('error', 'Username atau password salah.');


        } catch (\Exception $e) {
            Log::error('Login error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat login.');
        }

    }


    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            // Jika kode sampai di sini, berarti SEMUA validasi di ResetPasswordRequest sudah LULUS.
            // Data juga sudah aman karena kita panggil $request->validated().
            $validatedData = $request->validated();

            // Panggil service hanya dengan data yang dibutuhkan untuk proses update.
            // Service tidak perlu lagi melakukan validasi password.
            $this->userService->updateUserPassword($validatedData['password']);

            return redirect()->route('login')->with('success', 'Password berhasil direset.');

        } catch (\Exception $e) {
            Log::error('Reset password error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat reset password.');
        }
    }
    public function logout(Request $request)
    {
        $this->userService->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

