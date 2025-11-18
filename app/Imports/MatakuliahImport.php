<?php

namespace App\Imports;

use App\Models\Akademik\Matakuliah;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class MatakuliahImport implements ToCollection, WithCalculatedFormulas
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Ambil dan bersihkan kolom
            $kode = isset($row[2]) ? trim($row[2]) : null;
            $nama = isset($row[3]) ? trim($row[3]) : null;
            $sks = isset($row[9]) ? (int) $row[9] : null;

            // Cek apakah data valid
            if (!$kode || !$nama || !$sks) {
                continue;
            }

            Matakuliah::updateOrCreate(
                ['kode_matakuliah' => $kode],
                [
                    'nama_matakuliah' => ucwords(strtolower($nama)),
                    'sks' => $sks,
                    'prodi_id' => 2,
                    'deskripsi' => null,
                ]
            );
        }
    }
}
