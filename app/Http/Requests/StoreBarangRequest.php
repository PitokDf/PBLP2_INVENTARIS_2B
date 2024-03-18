<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangRequest extends FormRequest
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
            "kode_barang" => ["required"],
            "nama_barang" => ["required"],
            "kategori" => ["required"],
            "jumlah" => ["required"],
            "foto" => ["required"],
            "posisi" => ["required"],
        ];
    }

    public function messages(): array
    {
        return [
            "kode_barang.required" => "Kode Barang harus diisi.",
            "nama_barang.required" => "Nama Barang harus diisi.",
            "kategori.required" => "Pilih Kategori.",
            "jumlah.required" => "Jumlah harus diisi.",
            "foto" => "pilih file gambar.",
            "posisi.required" => "Posisi harus diisi."
        ];
    }
}