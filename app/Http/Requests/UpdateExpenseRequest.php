<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
            'expense_type' => 'required|string',
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'payment_method' => 'required|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ];
    }
    public function messages()
    {
        return [
            'expense_type.required' => 'Jenis pengeluaran harus diisi.',
            'amount.required' => 'Jumlah harus diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'category.required' => 'Kategori harus diisi.',
            'payment_method.required' => 'Metode pembayaran harus diisi.',
            'date.required' => 'Tanggal harus diisi.',
            'date.date' => 'Tanggal harus berupa tanggal.',

        ];
    }
}
