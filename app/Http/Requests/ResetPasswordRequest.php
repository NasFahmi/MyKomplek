<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk melakukan permintaan ini.
     */
    public function authorize(): bool
    {
        return Auth::check(); // hanya izinkan jika user sudah login
    }

    /**
     * Aturan validasi yang berlaku untuk permintaan reset password.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|exists:users,username',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * Pesan validasi kustom (opsional).
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Username wajib diisi.',
            'username.exists' => 'Username tidak ditemukan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
