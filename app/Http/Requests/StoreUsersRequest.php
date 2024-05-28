<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
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
            "name" => "required",
            "email" => [
                "unique:users,email",
                "required",
            ],
            'nim' => 'nullable|exists:mahasiswa,id_mahasiswa',
            'nip' => 'nullable|exists:dosen,id_dosen',
            "role" => "required",
            "password" => "min:8",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Nama tidak boleh kosong.",
            "email.required" => "Email tidak boleh kosong.",
            "email.unique" => "Email sudah pernah digunakan",
            "role.required" => "Pilih salah satu dari role yang tersedia.",
            "password.min" => "Password minimal :min karakter.",
        ];
    }
}