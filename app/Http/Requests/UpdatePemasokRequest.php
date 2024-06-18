<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePemasokRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_pemasok' => 'required',
            'kode_pos' => 'required|numeric|digits:5',
            'kota' => 'required',
            'no_hp' => 'required|' . Rule::unique('pemasoks')->ignore($this->route('pemasok')),
            'alamat' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pemasok.required' => 'Nama pemasok tidak boleh kosong.',
            'kode_pos.required' => 'Kode pos tidak boleh kosong.',
            'kode_pos.numeric' => 'Kode pos harus berupa angka.',
            'kode_pos.digits' => 'Kode pos harus terdiri :digits.',
            'kota.required' => 'Kota tidak boleh kosong.',
            'no_hp.required' => 'No hp tidak boleh kosong.',
            'no_hp.unique' => 'No hp sudah tersedia.',
            'alamat.required' => 'Alamat tidak boleh kosong.',
        ];
    }
}