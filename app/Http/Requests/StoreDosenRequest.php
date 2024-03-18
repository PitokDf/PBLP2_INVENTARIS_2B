<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDosenRequest extends FormRequest
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
            "name" => ["required", "regex:/^[a-zA-Z\s]+$/u"],
            "nip" => ["required", "regex:/^[0-9]+$/u", "digits:10"],
            "jabatan" => ["required"],
            "no_telpn" => ["required", "max:12"],
            "email" => ["required", "email", "unique:dosen,email"],
            // "dir_foto" => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Nama harus diisi.",
            "name.regex" => "Nama tidak boleh terdapat karakter unik ataupun angka.",
            "nip.required" => "NIP harus diisi.",
            "nip.regex" => "NIP tidak boleh terdapat karakter huruf.",
            "nip.digits" => "NIP harus :digits karakter angka.",
            "jabatan.required" => "Jabatan harus diisi.",
            "no_telpn.required" => "No Telepon harus diisi.",
            "email.unique" => "Email sudah tersedia.",
            "email.required" => "Email harus diisi.",
        ];
    }
}