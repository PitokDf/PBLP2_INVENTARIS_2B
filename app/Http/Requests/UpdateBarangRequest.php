<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
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
            "posisi" => ["required"],
            "foto" => [
                "max:2048",
                "mimes:jpeg,png,jpg",
            ]
        ];
    }

    public function messages(): array
    {
        return [
            "kode_barang.required" => "Kode Barang harus diisi.",
            "nama_barang.required" => "Nama Barang harus diisi.",
            "kategori.required" => "Pilih Kategori.",
            "jumlah.required" => "Jumlah harus diisi.",
            "posisi.required" => "Posisi harus diisi.",
            "foto.max" => "Max ukuran image 2Mb.",
            "foto.mimes" => "Hanya file jpg, jpeg, png yang diizinkan.",
        ];
    }
}