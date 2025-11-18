<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\RpsMatakuliah;
use App\Models\RpsDetail;
use Illuminate\Support\Facades\Log;

class RpsDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Ambil model RpsDetail bila ada (route model binding)
        $rpsDetailModel = $this->route('rps_detail');
        if (is_numeric($rpsDetailModel)) {
            $rpsDetailModel = RpsDetail::find($rpsDetailModel);
        }
        Log::info('RpsDetailRequest: Validating RPS Detail', [
            'rpsDetailModel' => $rpsDetailModel ? $rpsDetailModel->toArray() : null,
            'method' => $this->method(),
            'input' => $this->all(),
        ]);

        $rpsDetailId = $rpsDetailModel ? $rpsDetailModel->id : null;

        $rpsMatakuliahId = $rpsDetailModel
            ? $rpsDetailModel->rps_matakuliah_id
            : $this->input('rps_matakuliah_id');

        $rules = [
            'capaian_pembelajaran'  => ['required', 'string'],
            'indikator'             => ['required', 'string'],
            'metode_pembelajaran'   => ['required', 'string'],
            'kriteria_penilaian'    => ['required', 'string'],
            'materi_pembelajaran'   => ['required', 'string'],
        ];
        if ($this->isMethod('POST')) {
            $rules['sesi_pertemuan'] = [
                'required',
                'integer',
                'min:1',
                Rule::unique('rps_details', 'sesi_pertemuan')
                    ->where('rps_matakuliah_id', $rpsMatakuliahId),
            ];
        }
        elseif ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            if ($this->has('sesi_pertemuan')) {
                $rules['sesi_pertemuan'] = [
                    'required',
                    'integer',
                    'min:1',
                    Rule::unique('rps_details', 'sesi_pertemuan')
                        ->where('rps_matakuliah_id', $rpsMatakuliahId)
                        ->ignore($rpsDetailId),
                ];
            }

        }
        $rules['tanggal_pertemuan'] = [
            'required',
            'date',
            'date_format:Y-m-d',
            function ($attribute, $value, $fail) use ($rpsMatakuliahId, $rpsDetailModel) {
                if (! $rpsMatakuliahId) {
                    return $fail('RPS Mata Kuliah tidak ditemukan.');
                }

                $rpsMatakuliah = RpsMatakuliah::find($rpsMatakuliahId);
                if (! $rpsMatakuliah) {
                    return $fail('Data RPS Mata Kuliah tidak ditemukan.');
                }

                $valueDate = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
                $startDate = Carbon::parse($rpsMatakuliah->tanggal_mulai)->startOfDay();
                $endDate   = Carbon::parse($rpsMatakuliah->tanggal_selesai)->endOfDay();

                if ($valueDate->lt($startDate) || $valueDate->gt($endDate)) {
                    $startFmt = $startDate->locale('id')->translatedFormat('d F Y');
                    $endFmt   = $endDate->locale('id')->translatedFormat('d F Y');
                    return $fail("Tanggal pertemuan harus berada di antara $startFmt dan $endFmt.");
                }

                $currentSessionNumber = $this->input('sesi_pertemuan')
                    ?? ($rpsDetailModel->sesi_pertemuan ?? null);
                if ($currentSessionNumber) {
                    $previousSession = RpsDetail::where('rps_matakuliah_id', $rpsMatakuliahId)
                        ->where('sesi_pertemuan', '<', $currentSessionNumber)
                        ->when($rpsDetailModel, fn($q) => $q->where('id', '<>', $rpsDetailModel->id))
                        ->orderBy('sesi_pertemuan', 'desc')
                        ->first();

                    if ($previousSession) {
                        $prevDate = Carbon::parse($previousSession->tanggal_pertemuan)->startOfDay();
                        if ($valueDate->lte($prevDate)) {
                            $prevFmt = $prevDate->locale('id')->translatedFormat('d F Y');
                            return $fail("Tanggal pertemuan harus setelah sesi sebelumnya yang berakhir pada $prevFmt.");
                        }
                    }
                }
            },
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'sesi_pertemuan.required'        => 'Sesi pertemuan wajib diisi.',
            'sesi_pertemuan.integer'         => 'Sesi pertemuan harus berupa angka.',
            'sesi_pertemuan.min'             => 'Sesi pertemuan minimal 1.',
            'sesi_pertemuan.unique'          => 'Sesi pertemuan sudah ada untuk RPS ini.',

            'tanggal_pertemuan.required'     => 'Tanggal pertemuan wajib diisi.',
            'tanggal_pertemuan.date'         => 'Tanggal pertemuan harus berupa tanggal.',
            'tanggal_pertemuan.date_format'  => 'Format tanggal pertemuan tidak valid (Y-m-d).',

            'capaian_pembelajaran.required'  => 'Capaian pembelajaran wajib diisi.',
            'capaian_pembelajaran.string'    => 'Capaian pembelajaran harus berupa teks.',
            'indikator.required'             => 'Indikator wajib diisi.',
            'indikator.string'               => 'Indikator harus berupa teks.',
            'metode_pembelajaran.required'   => 'Metode pembelajaran wajib diisi.',
            'metode_pembelajaran.string'     => 'Metode pembelajaran harus berupa teks.',
            'kriteria_penilaian.required'    => 'Kriteria penilaian wajib diisi.',
            'kriteria_penilaian.string'      => 'Kriteria penilaian harus berupa teks.',
            'materi_pembelajaran.required'   => 'Materi pembelajaran wajib diisi.',
            'materi_pembelajaran.string'     => 'Materi pembelajaran harus berupa teks.',
        ];
    }
}
