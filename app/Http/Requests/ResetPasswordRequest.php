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
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ];
    }

    /**
     * Pesan validasi kustom (opsional).
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Password saat ini harus diisi.',
            'password.required' => 'Password baru harus diisi.',
            'password.min' => 'Password baru harus memiliki minimal 6 karakter.',
            'password.confirmed' => 'Password baru tidak cocok dengan konfirmasi password.',
            'password_confirmation.required' => 'Konfirmasi password harus diisi.',
            'password_confirmation.min' => 'Konfirmasi password harus memiliki minimal 6 karakter.',
        ];
    }
}
