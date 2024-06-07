<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMahasiswasRequest extends FormRequest
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
            "nama_mahasiswa" => "required",
            "nim" => "required|numeric|digits:10|unique:mahasiswa,nim",
            "prodi" => "required",
            "angkatan" => "required|numeric|min:2000|max:" . date('Y'),
            "ipk" => "required|numeric|min:0|max:4",
        ];
    }

    public function messages()
    {
        return [
            "nama_mahasiswa.required" => "nama tidak boleh kosong",
            "nim.required" => "NIM tidak boleh kosong",
            "nim.numeric" => "NIM harus berupa angka",
            "nim.digits" => "NIM harus 10 digit",
            "nim.unique" => "NIM sudah terdaftar",
            "prodi.required" => "Prodi tidak boleh kosong",
            "angkatan.required" => "Angkatan tidak boleh kosong",
            "angkatan.numeric" => "Angkatan harus berupa angka",
            "angkatan.min" => "Angkatan minimal tahun 2000",
            "angkatan.max" => "Angkatan maximal tahun :max",
            "ipk.required" => "IPK tidak boleh kosong",
            "ipk.numeric" => "IPK harus berupa angka",
            "ipk.min" => "IPK minimal 0.00",
            "ipk.max" => "IPK maximal 4.00",


        ];
    }
}