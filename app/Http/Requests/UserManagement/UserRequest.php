<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $passwordRule = $this->isMethod('POST') ? 'required|string' : 'nullable|string|confirmed';
        $emailRule = $this->isMethod('POST') ? 'required|email|unique:users' : 'required|email|unique:users,email,'.$this->user->id;
        return [
            "name" => "required|string",
            "email" => $emailRule,
            "password" => $passwordRule,
            "role" => "required|string",
            "profile_photo" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
        ];
    }
}
