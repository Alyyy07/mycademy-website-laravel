<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataMahasiswaRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'npm' => 'required|string|max:9|unique:data_mahasiswas,npm',
                'prodi_id' => 'required|exists:prodis,id',
                'nik' => 'nullable|string|max:20',
                'tempat_lahir' => 'nullable|string|max:50',
                'tanggal_lahir' => 'nullable|date',
                'jenis_kelamin' => 'nullable|string|max:10',
                'agama' => 'nullable|string|max:20',
                'alamat' => 'nullable|string|max:255',
                'no_hp' => 'nullable|string|max:15',
                'nama_ibu' => 'nullable|string|max:50',
                'semester' => 'nullable|in:1,2,3,4,5,6,7,8',
            ];
        }
        $id = $this->route('data_mahasiswa')->id; 
        return [
            'npm' => "required|string|max:9|unique:data_mahasiswas,npm,$id",
            'prodi_id' => 'required|exists:prodis,id',
            'nik' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:10',
            'agama' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'nama_ibu' => 'nullable|string|max:50',
            'semester' => 'nullable|in:1,2,3,4,5,6,7,8',
        ];
    }

    public function messages()
    {
        return [
            'npm.required' => 'Npm wajib diisi',
            'npm.string' => 'Npm harus berupa string',
            'npm.max' => 'Npm maksimal 9 karakter',
            'npm.unique' => 'Npm sudah terdaftar',
            'nama.required' => 'Nama wajib diisi',
            'prodi_id.required' => 'Prodi ID wajib diisi',
            'prodi_id.exists' => 'Prodi ID tidak valid',
            'nik.string' => 'NIK harus berupa string',
            'nik.max' => 'NIK maksimal 20 karakter',
            'tempat_lahir.string' => 'Tempat lahir harus berupa string',
            'tempat_lahir.max' => 'Tempat lahir maksimal 50 karakter',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid',
            'jenis_kelamin.string' => 'Jenis kelamin harus berupa string',
            'jenis_kelamin.max' => 'Jenis kelamin maksimal 10 karakter',
            'agama.string' => 'Agama harus berupa string',
            'agama.max' => 'Agama maksimal 20 karakter',
            'alamat.string' => 'Alamat harus berupa string',
            'alamat.max' => 'Alamat maksimal 255 karakter',
            'no_hp.string' => 'No HP harus berupa string',
            'no_hp.max' => 'No HP maksimal 15 karakter',
            'nama_ibu.string' => 'Nama ibu harus berupa string',
            'nama_ibu.max' => 'Nama ibu maksimal 50 karakter',
            'semester.in' => 'Semester tidak valid',
        ];
    }
}
