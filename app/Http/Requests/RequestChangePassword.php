<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestChangePassword extends FormRequest
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
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|same:new_password',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Password lama harus diisi',
            'new_password.required' => 'Password baru harus diisi',
            'confirm_new_password.required' => 'Konfirmasi password baru harus diisi',
            'confirm_new_password.same' => 'Konfirmasi password baru harus sama dengan password baru',
        ];
    }
}
