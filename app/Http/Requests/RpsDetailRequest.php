<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\RpsMatakuliah;

class RpsDetailRequest extends FormRequest
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
        $rpsDetailId = $this->route('rpsDetail');
        $rpsMatakuliahId = $this->rps_matakuliah_id;
        return [
            'sesi_pertemuan' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('rps_details', 'sesi_pertemuan')->where('rps_matakuliah_id', $rpsMatakuliahId)->ignore($rpsDetailId)
            ],
            'tanggal_pertemuan' => [
                'required',
                'date',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    if (!$this->rps_matakuliah_id) {
                        $fail('RPS Mata Kuliah tidak ditemukan.');
                        return;
                    }

                    $rpsMatakuliah = RpsMatakuliah::find($this->rps_matakuliah_id);
                    if (!$rpsMatakuliah) {
                        $fail('Data RPS Mata Kuliah tidak ditemukan.');
                        return;
                    }

                    $startDate = $rpsMatakuliah->tanggal_mulai;
                    $endDate = $rpsMatakuliah->tanggal_selesai;

                    if ($value < $startDate || $value > $endDate) {
                        $startDate = Carbon::parse($rpsMatakuliah->tanggal_mulai)->locale('id')->translatedFormat('d F Y');
                        $endDate = Carbon::parse($rpsMatakuliah->tanggal_selesai)->locale('id')->translatedFormat('d F Y');
                        $fail('Tanggal pertemuan harus berada di antara ' . $startDate . ' dan ' . $endDate);
                    }
                }
            ],
            'capaian_pembelajaran' => ['required', 'string'],
            'indikator' => ['required', 'string'],
            'metode_pembelajaran' => ['required', 'string'],
            'kriteria_penilaian' => ['required', 'string'],
            'materi_pembelajaran' => ['required', 'string'],
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
            'sesi_pertemuan.required' => 'Sesi pertemuan wajib diisi.',
            'sesi_pertemuan.integer' => 'Sesi pertemuan harus berupa angka.',
            'sesi_pertemuan.min' => 'Sesi pertemuan minimal 1.',
            'sesi_pertemuan.unique' => 'Sesi pertemuan sudah ada.',
            'tanggal_pertemuan.required' => 'Tanggal pertemuan wajib diisi.',
            'tanggal_pertemuan.date' => 'Tanggal pertemuan harus berupa tanggal.',
            'tanggal_pertemuan.date_format' => 'Format tanggal pertemuan tidak valid.',
            'capaian_pembelajaran.required' => 'Capaian pembelajaran wajib diisi.',
            'capaian_pembelajaran.string' => 'Capaian pembelajaran harus berupa teks.',
            'indikator.required' => 'Indikator wajib diisi.',
            'indikator.string' => 'Indikator harus berupa teks.',
            'metode_pembelajaran.required' => 'Metode pembelajaran wajib diisi.',
            'metode_pembelajaran.string' => 'Metode pembelajaran harus berupa teks.',
            'kriteria_penilaian.required' => 'Kriteria penilaian wajib diisi.',
            'kriteria_penilaian.string' => 'Kriteria penilaian harus berupa teks.',
            'materi_pembelajaran.required' => 'Materi pembelajaran wajib diisi.',
            'materi_pembelajaran.string' => 'Materi pembelajaran harus berupa teks.',
        ];
    }
}
