<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangMasukRequest extends FormRequest
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
            'barang' => 'required|exists:barang,id_barang',
            'quantity' => 'required|numeric',
            'pemasok' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'barang.required' => 'Barang harus dipih.',
            'barang.exists' => 'Barang tidak terdaftar.',
            'quantity.required' => 'Quantity harus diisi.',
            'quantity.numeric' => 'Quantity harus numeric.',
            'pemasok.required' => 'Pemasok harus diisi.',
        ];
    }
}