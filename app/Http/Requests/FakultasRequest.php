<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FakultasRequest extends FormRequest
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
        $fakultasId = $this->route('fakulta') ? $this->route('fakulta')->id : null;
        return [
            "kode_fakultas" => [
                'required',
                'string',
                'max:5',
                Rule::unique('fakultas', 'kode_fakultas')->ignore($fakultasId),
            ],
            "nama_fakultas" => "required|string|max:255",
            "deskripsi" => "nullable|string",
            "email" => [
                'required',
                'email',
                Rule::unique('fakultas', 'email')->ignore($fakultasId),
            ],
            "logo" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
        ];
    }
}
