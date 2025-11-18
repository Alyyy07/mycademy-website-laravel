<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MateriRequest extends FormRequest
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
        $rules = [
            'rps_detail_id' => ['required', 'exists:rps_details,id'],
            'title' => ['required', 'string', 'max:255'],
            'tipe_materi' => ['required', 'in:video,pdf,teks'],
        ];

        // Validasi berdasarkan tipe materi
        $tipeMateri = $this->input('tipe_materi');

        switch ($tipeMateri) {
            case 'video':
                $rules['video_path'] = ['required', 'url'];
                break;

            case 'pdf':
                $rules['file_path'] = ['required', 'string'];
                break;

            default:
                $rules['text_content'] = ['required', 'string'];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul materi wajib diisi.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'video_path.required' => 'Link video wajib diisi.',
            'video_path.url' => 'Format link video tidak valid.',
            'file_path.required' => 'File PDF wajib diunggah.',
            'text_content.required' => 'Konten teks wajib diisi.',
        ];
    }
}
