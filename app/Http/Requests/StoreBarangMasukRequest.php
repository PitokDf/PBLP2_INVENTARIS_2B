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
            'quantity' => 'required|numeric|min:1',
            'penerima' => 'required',
            'tanggal_masuk' => 'required|date',
            'pemasok' => 'required|exists:pemasoks,id',
            'keterangan' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'barang.required' => 'Barang tidak boleh kosong',
            'barang.exists' => 'Barang tidak terdaftar.',
            'quantity.required' => 'Quantity harus diisi.',
            'quantity.numeric' => 'Quantity harus terdiri dari angka.',
            'pemasok.required' => 'Pemasok tidak boleh kosong',
            'penerima.required' => 'Penerima tidak boleh kosong',
            'tanggal_masuk.required' => 'Tanggal tidak boleh kosong',
            'tanggal_masuk.date' => 'Tanggal harus format yang benar',
        ];
    }
}