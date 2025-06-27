<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHouseRequest extends FormRequest
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
            'house_number' => 'required|string',
            'address' => 'required|string',
            'status' => 'boolean',
        ];
    }
    public function messages()
    {
        return [
            'house_number.required' => 'Nomor rumah wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
        ];
    }
}
