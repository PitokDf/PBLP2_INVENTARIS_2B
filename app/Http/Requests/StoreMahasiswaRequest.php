<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMahasiswaRequest extends FormRequest
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
            "nama_mahasiswa" => "required|regex:/^[a-zA-Z]",
            "nim" => "required|regex:/^[0-9]+$/u|digits:10",
            "prodi" => "required",
            "angkatan" => "required",
            "ipk" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            "nama_mahasiswa.required" => "Nama Mahasiswa harus diisi.",
            "nama_mahasiswa.regex" => "Nama Mahasiswa hanya boleh huruf.",
            "nim.required" => "NIM harus diisi.",
            "nim.regex" => "NIM hanya boleh angka.",
            "nim.digits" => "NIM harus :digits karakter.",
            "prodi.requiredi" => "Pilih prodi.",
            "angkatan.required" => "Pilih angkatan.",
            "ipk.required" => "IPK harus diisi.",
        ];
    }
}