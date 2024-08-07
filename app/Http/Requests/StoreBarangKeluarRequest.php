<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangKeluarRequest extends FormRequest
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
            "barang" => "required|exists:barang,id_barang",
            "quantity" => "required|numeric|min:1",
            "keterangan" => "required",
            'tgl_keluar' => "required|date",
            'user' => 'required|exists:users,id_user'
        ];
    }

    public function messages(): array
    {
        return [
            "barang.required" => "Silahkan pilih barang.",
            "barang.exists" => "Barang tidak terdaftar.tgl_masuk",
            "quantity.required" => "Quantity harus diisi.",
            "quantity.numeric" => "Quantity harus numeric.",
            "quantity.min" => "Quantity minimal :min."
        ];
    }
}