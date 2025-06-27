<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreResidentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',

            // FIX: Ganti 'enum' dengan 'Rule::in'
            'status' => ['required', Rule::in(['tetap', 'kontrak'])],

            'married_status' => 'required|boolean',
            'identity_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Tambahkan validasi yang lebih spesifik
            'house' => 'required',

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'status.required' => 'Status penghuni wajib dipilih.',
            'status.in' => 'Status penghuni tidak valid.',
            'married_status.required' => 'Status perkawinan wajib diisi.',
            'identity_photo.required' => 'Foto identitas wajib diunggah.',
            'identity_photo.image' => 'File yang diunggah harus berupa gambar.',
            'identity_photo.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'identity_photo.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'house.required' => 'Rumah wajib dipilih.',
        ];
    }
}
