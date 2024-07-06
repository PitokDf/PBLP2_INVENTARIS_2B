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
            "kategori" => ["required", "exists:kategori_barang,id"],
            "jumlah" => ["required", "numeric", "min:1"],
            "foto" => ["nullable", "image", "mimes:jpg,jpeg,png", "max:2048"],
            "posisi" => ["required"],
            'merk' => 'required|exists:merks,id',
            'tanggal_masuk' => 'required|date',
            'pemasok' => 'required|exists:pemasoks,id',
            'deskripsi' => 'required|min:3'
        ];

    }

    public function messages(): array
    {
        return [
            "kode_barang.required" => "Kode Barang harus diisi.",
            "nama_barang.required" => "Nama Barang harus diisi.",
            "kategori.required" => "Pilih Kategori.",
            "jumlah.required" => "Jumlah harus diisi.",
            "foto.required" => "Pilih salah satu gambar.",
            "foto.max" => "File maksimal berukuran 2MB",
            "posisi.required" => "Posisi harus diisi."
        ];
    }
}