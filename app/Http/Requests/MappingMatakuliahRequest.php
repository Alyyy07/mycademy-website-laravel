<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Akademik\TahunAjaran;

class MappingMatakuliahRequest extends FormRequest
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
        // Mendapatkan tahun ajaran aktif
        $tahunAjaranId = TahunAjaran::getActive()['id'];

        return [
            'matakuliah_id' => [
                'required',
                'exists:matakuliahs,id',
                Rule::unique('mapping_matakuliahs')
                    ->where(function ($query) use ($tahunAjaranId) {
                        return $query->where('tahun_ajaran_id', $tahunAjaranId)
                            ->where('matakuliah_id', $this->input('matakuliah_id'))
                            ->where('dosen_id', $this->input('dosen_id'))
                            ->where('admin_verifier_id', $this->input('admin_verifier_id'))
                            ->where('semester', $this->input('semester'));
                    })
                    ->ignore($this->route('mapping_matakuliah')) // Agar tidak error saat update
            ],
            'dosen_id' => ['required', 'exists:users,id'],
            'admin_verifier_id' => ['required', 'exists:users,id'],
            'semester' => ['required', 'in:1,2,3,4,5,6,7,8'],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'matakuliah_id.required' => 'Matakuliah harus dipilih.',
            'matakuliah_id.exists' => 'Matakuliah yang dipilih tidak valid.',
            'dosen_id.required' => 'Dosen harus dipilih.',
            'dosen_id.exists' => 'Dosen yang dipilih tidak valid.',
            'admin_verifier_id.required' => 'Admin Verifier harus dipilih.',
            'admin_verifier_id.exists' => 'Admin Verifier yang dipilih tidak valid.',
            'prodi_id.required' => 'Program Studi harus dipilih.',
            'prodi_id.exists' => 'Program Studi yang dipilih tidak valid.',
            'semester.required' => 'Semester harus diisi.',
            'semester.in' => 'Semester yang dipilih tidak valid.',
            'matakuliah_id' => 'Data dengan kombinasi ini sudah ada dalam tahun ajaran yang sama.',
        ];
    }
}
