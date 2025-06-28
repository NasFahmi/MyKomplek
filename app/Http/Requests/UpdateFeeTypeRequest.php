<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeeTypeRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'effective_date' => 'required|date|after_or_equal:today'
        ];
    }
    public function messages(){
        return [
            'name.required' => 'Nama wajib diisi.',
            'amount.required' => 'Jumlah wajib diisi.',
            'is_active.required' => 'Status wajib diisi.',
            'effective_date.required' => 'Tanggal mulai berlaku wajib diisi.',
            'effective_date.after_or_equal' => 'Tanggal mulai berlaku harus setelah tanggal hari ini.',
        ];
    }
}
