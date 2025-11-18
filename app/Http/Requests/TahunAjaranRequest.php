<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TahunAjaranRequest extends FormRequest
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
        // Ambil ID tahun ajaran jika sedang dalam mode update
        $tahunAjaranId = $this->route('tahun_ajaran');
        return [
            'kode_tahun_ajaran' => [
                'required',
                'string',
                'max:5',
                Rule::unique('tahun_ajarans', 'kode_tahun_ajaran')->ignore($tahunAjaranId)
            ],
            'tahun_ajaran_awal' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2099'],
            'tahun_ajaran_akhir' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2099', 'gt:tahun_ajaran_awal'],
            'tanggal_mulai' => [
                'required',
                'date',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    $tahunAjaranAwal = $this->input('tahun_ajaran_awal');
                    if ($tahunAjaranAwal && date('Y', strtotime($value)) != $tahunAjaranAwal) {
                        $fail("Tanggal mulai harus berada dalam tahun ajaran awal ($tahunAjaranAwal).");
                    }
                }
            ],
            'tanggal_selesai' => [
                'required',
                'date','date_format:Y-m-d',
                'after:tanggal_mulai',
                function ($attribute, $value, $fail) {
                    $tahunAjaranAkhir = $this->input('tahun_ajaran_akhir');
                    if ($tahunAjaranAkhir && date('Y', strtotime($value)) != $tahunAjaranAkhir) {
                        $fail("Tanggal selesai harus berada dalam tahun ajaran akhir ($tahunAjaranAkhir).");
                    }
                }
            ],
        ];
    }
}
