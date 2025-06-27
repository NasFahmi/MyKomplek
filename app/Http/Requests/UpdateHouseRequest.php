<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'house_number' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'house_number.required' => 'Nomor rumah wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'status.required' => 'Status wajib diisi.',
        ];
    }
}
