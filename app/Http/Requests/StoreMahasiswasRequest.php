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
            "nama_mahasiswa" => "required|regex:/^[a-zA-Z]+$/",
            "nim" => "required|numeric|digits:10|unique:mahasiswa,nim",
            "prodi" => "required",
            "angkatan" => "required|numeric|min:2000|max:" . date('Y'),
            "ipk" => "required|numeric|min:0|max:4",
        ];
    }
}