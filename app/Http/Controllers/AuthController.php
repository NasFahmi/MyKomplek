<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use function Illuminate\Log\log;

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
            // 1. Validasi input dari form
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);

            // 2. Coba untuk mengautentikasi pengguna
            if (Auth::attempt($credentials)) {
                // 3. Jika berhasil, regenerate session untuk keamanan
                $request->session()->regenerate();

                // 4. Redirect ke halaman yang seharusnya (dashboard)
                // Menggunakan intended() akan mengarahkan user ke halaman yang ingin mereka akses sebelum dipaksa login.
                // Jika tidak ada, default-nya akan ke 'dashboard.index'.
                // dd(auth()->user());
                return redirect()->intended(route('dashboard.index'));
            }

            // 5. Jika gagal, kembalikan ke halaman login dengan pesan error
            return back()->withErrors([
                'username' => 'username atau Password yang Anda masukkan salah.',
            ])->onlyInput('username');


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
            $data = $request->validated();

            if ($this->userService->resetPassword($data['username'], $data['password'])) {
                return redirect()
                    ->route('login')
                    ->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
            }

            return back()
                ->withInput()
                ->with('error', 'Gagal mereset password. Username tidak ditemukan.');

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

