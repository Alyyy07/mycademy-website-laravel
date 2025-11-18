<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MatakuliahRequest extends FormRequest
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
        $matakuliahId = $this->route('matakuliah');
        return [
            'kode_matakuliah' => [
                'required',
                'string',
                'max:7',
                Rule::unique('matakuliahs', 'kode_matakuliah')->ignore($matakuliahId)
            ],
            'nama_matakuliah' => ['required', 'string', 'max:255'],
            'prodi_id' => ['required', 'integer'],
            'sks' => ['required', 'integer'],
            'deskripsi' => ['string', 'nullable'],
        ];
    }
}
