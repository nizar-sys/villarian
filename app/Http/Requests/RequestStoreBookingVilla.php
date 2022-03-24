<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreBookingVilla extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'tanggal_checkin' => 'required|date|after_or_equal:today',
            'tanggal_checkout' => 'required|date|after:tanggal_checkin',
            'total_bayar' => 'required|numeric',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'nama_pemesan.required' => 'Nama Pemesan tidak boleh kosong',
            'no_hp.required' => 'No HP tidak boleh kosong',
            'tanggal_checkin.required' => 'Tanggal Checkin tidak boleh kosong',
            'tanggal_checkout.required' => 'Tanggal Checkout tidak boleh kosong',
            'total_bayar.required' => 'Total Bayar tidak boleh kosong',
            'tanggal_checkin.after_or_equal' => 'Tanggal Checkin tidak boleh lebih kecil dari tanggal hari ini',
            'tanggal_checkout.after' => 'Tanggal Checkout tidak boleh lebih kecil dari tanggal Checkin',
            'total_bayar.numeric' => 'Total Bayar harus berupa angka',
        ];
    }
}
