<?php

namespace App\Http\Requests;

use App\Models\MappingMatakuliah;
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
            'tanggal_mulai' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:tanggal_selesai', "after_or_equal:$tanggalMulai", "before_or_equal:$tanggalSelesai"],
            'tanggal_selesai' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:tanggal_mulai', "after_or_equal:$tanggalMulai", "before_or_equal:$tanggalSelesai"],
        ];
    }
}
