<?php

namespace App\Http\Requests;

use App\Models\MappingMatakuliah;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class RpsMatakuliahRequest extends FormRequest
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
        $tahunAjaran = MappingMatakuliah::find($this->input('mapping_matakuliah_id'))->tahunAjaran;
        $tanggalMulai = $tahunAjaran->tanggal_mulai;
        $tanggalSelesai = $tahunAjaran->tanggal_selesai;
        return [
            'mapping_matakuliah_id' => ['required', 'integer', 'exists:mapping_matakuliahs,id', 'unique:rps_matakuliahs,mapping_matakuliah_id'],
            'tanggal_mulai' => ['required', 'date', 'date_format:Y-m-d', 'before:tanggal_selesai',function($attribute, $value, $fail) use ($tanggalMulai, $tanggalSelesai) {
                if ($value < $tanggalMulai || $value > $tanggalSelesai) {
                    $tanggalMulai = Carbon::parse($tanggalMulai)->locale('id')->translatedFormat('d F Y');
                    $tanggalSelesai = Carbon::parse($tanggalSelesai)->locale('id')->translatedFormat('d F Y');
                    $fail("Tanggal mulai harus berada di antara $tanggalMulai dan $tanggalSelesai");
                }
            }],
            'tanggal_selesai' => ['required', 'date', 'date_format:Y-m-d', 'after:tanggal_mulai', function($attribute, $value, $fail) use ($tanggalMulai, $tanggalSelesai) {
                if ($value < $tanggalMulai || $value > $tanggalSelesai) {
                    $tanggalMulai = Carbon::parse($tanggalMulai)->locale('id')->translatedFormat('d F Y');
                    $tanggalSelesai = Carbon::parse($tanggalSelesai)->locale('id')->translatedFormat('d F Y');
                    $fail("Tanggal selesai harus berada di antara $tanggalMulai dan $tanggalSelesai");
                }
            }],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {

        return [
            'mapping_matakuliah_id.required' => 'Matakuliah wajib diisi',
            'mapping_matakuliah_id.exists' => 'Matakuliah tidak ditemukan',
            'mapping_matakuliah_id.unique' => 'RPS sudah ada',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_mulai.date' => 'Tanggal mulai harus berupa tanggal',
            'tanggal_mulai.date_format' => 'Format tanggal mulai tidak valid',
            'tanggal_mulai.before' => "Tanggal mulai harus sebelum tanggal selesai",
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.date' => 'Tanggal selesai harus berupa tanggal',
            'tanggal_selesai.date_format' => 'Format tanggal selesai tidak valid',
            'tanggal_selesai.after' => "Tanggal selesai harus setelah tanggal mulai",
        ];
    }
}
