<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePaymentRequest extends FormRequest
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
            'house_id' => 'required|string',
            'resident_id' => 'required|string',
            'status' => 'required|string',
            'fees' => 'required|array', // Memastikan fees adalah array
            'fees.*.start_month' => 'required|integer|between:1,12', // Validasi bulan mulai
            'fees.*.start_year' => 'required|integer|min:2020', // Validasi tahun mulai
            'fees.*.end_month' => 'required|integer|between:1,12', // Validasi bulan akhir
            'fees.*.end_year' => 'required|integer|min:2020', // Validasi tahun akhir
            'fees.*.amount' => 'required|numeric|min:0', // Validasi jumlah
            'description' => 'nullable|string',


        ];
    }
    public function messages()
    {
        return [
            'house_id.required' => 'Rumah wajib dipilih.',
            'resident_id.required' => 'Penghuni wajib dipilih.',
            'status.required' => 'Status wajib diisi.',
            'fees.required' => 'Iuran wajib diisi.',
            'fees.array' => 'Iuran harus berupa array.',
            'fees.*.start_month.required' => 'Bulan mulai wajib diisi.',
            'fees.*.start_month.integer' => 'Bulan mulai harus berupa angka.',
            'fees.*.start_month.between' => 'Bulan mulai harus antara 1 dan 12.',
            'fees.*.start_year.required' => 'Tahun mulai wajib diisi.',
            'fees.*.start_year.integer' => 'Tahun mulai harus berupa angka.',
            'fees.*.start_year.min' => 'Tahun mulai harus minimal 2020.',
            'fees.*.end_month.required' => 'Bulan akhir wajib diisi.',
            'fees.*.end_month.integer' => 'Bulan akhir harus berupa angka.',
            'fees.*.end_month.between' => 'Bulan akhir harus antara 1 dan 12.',
            'fees.*.end_year.required' => 'Tahun akhir wajib diisi.',
            'fees.*.end_year.integer' => 'Tahun akhir harus berupa angka.',
            'fees.*.end_year.min' => 'Tahun akhir harus minimal 2020.',
            'fees.*.amount.required' => 'Jumlah wajib diisi.',
            'fees.*.amount.numeric' => 'Jumlah harus berupa angka.',
            'fees.*.amount.min' => 'Jumlah harus minimal 0.',

        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!isset($this->fees))
                return;

            foreach ($this->fees as $feeId => $fee) {
                $start = intval($fee['start_year']) * 100 + intval($fee['start_month']);
                $end = intval($fee['end_year']) * 100 + intval($fee['end_month']);

                if ($start > $end) {
                    $validator->errors()->add("fees.$feeId.start_month", 'Tanggal mulai harus lebih kecil atau sama dengan tanggal akhir.');
                    $validator->errors()->add("fees.$feeId.start_year", 'Tanggal mulai harus lebih kecil atau sama dengan tanggal akhir.');
                }
            }
        });
    }

    public function failedValidation(Validator $validator)
    {
        // Cek apakah kesalahan berasal dari periode tanggal (custom logic)
        $customError = null;

        foreach ($this->fees as $feeId => $fee) {
            $start = intval($fee['start_year']) * 100 + intval($fee['start_month']);
            $end = intval($fee['end_year']) * 100 + intval($fee['end_month']);

            if ($start > $end) {
                $customError = 'Tanggal mulai iuran tidak boleh lebih besar dari tanggal akhir.';
                break;
            }
        }

        // Jika custom error ditemukan, tampilkan sebagai session flash message
        if ($customError) {
            session()->flash('error', $customError);
            throw new HttpResponseException(
                redirect()->back()->withInput()
            );
        }

        // Jika bukan error custom, jalankan default handler
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
        );
    }

}
