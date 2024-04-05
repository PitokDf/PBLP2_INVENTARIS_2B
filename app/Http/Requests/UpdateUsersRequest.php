<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersRequest extends FormRequest
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
            "role" => "required",
            "email" => "required",
        ];
    }
    public function messages(): array
    {
        return [
            "name.required" => "Nama tidak boleh kosong.",
            "email.required" => "Email tidak boleh kosong.",
            "role.required" => "Role tidak boleh kosong.",
        ];
    }
}