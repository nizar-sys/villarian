<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class RequestStoreOrUpdateVilla extends FormRequest
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
            'nama_villa' => 'required|max:255',
            'alamat' => 'required|max:255',
            'deskripsi' => 'required',
            'harga_sewa' => 'required|numeric',
        ];

        if($this->method() == 'POST') {
            $rules['foto'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4048';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nama_villa.required' => 'Nama Villa harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'harga_sewa.required' => 'Harga Sewa harus diisi',
            'foto.required' => 'Foto harus diisi',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Foto harus berupa gambar',
            'foto.max' => 'Foto tidak boleh lebih dari 4MB',
            'harga_sewa.numeric' => 'Harga Sewa harus berupa angka',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'uuid' => Str::uuid(),
        ]);

        if ($this->method() == 'POST') {
            $this->merge([
                'created_at' => now(),
            ]);
        } else {
            $this->merge([
                'updated_at' => now(),
            ]);
        }
    }
}
