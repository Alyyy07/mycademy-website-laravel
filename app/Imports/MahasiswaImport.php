<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Akademik\DataMahasiswa;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $email = $row[12]; // kolom M
            $name = $row[1] . ' ' . $row[2]; // kolom B dan C

            // Cek user by email
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'id' => Str::uuid(),
                    'name' => $name,
                    'password' => '12345',
                    'is_active' => true,
                ]
            );

            // add role
            $user->assignRole('mahasiswa');

            $indoToEnBulan = [
                'Januari' => 'January',
                'Februari' => 'February',
                'Maret' => 'March',
                'April' => 'April',
                'Mei' => 'May',
                'Juni' => 'June',
                'Juli' => 'July',
                'Agustus' => 'August',
                'September' => 'September',
                'Oktober' => 'October',
                'November' => 'November',
                'Desember' => 'December',
            ];

            $tanggalString = preg_replace('/\s+/', ' ', trim($row[8]));
            foreach ($indoToEnBulan as $indo => $en) {
                $tanggalString = str_ireplace($indo, $en, $tanggalString);
            }

            try {
                $tanggalLahir = is_numeric($row[8])
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8])->format('Y-m-d')
                    : \Carbon\Carbon::createFromFormat('d F Y', $tanggalString)->format('Y-m-d');
            } catch (\Exception $e) {
                $tanggalLahir = null;
            }

            // Simpan data mahasiswa
            DataMahasiswa::create([
                'npm' => $row[0], // kolom A
                'nama' => $name,
                'user_id' => $user->id,
                'nik' => $row[3], // kolom D
                'jenis_kelamin' => $row[4], // kolom E
                'nama_ibu' => $row[5], // kolom F
                'agama' => $row[6], // kolom G
                'tempat_lahir' => $row[7], // kolom H
                'tanggal_lahir' => $tanggalLahir, // kolom I
                'alamat' => $row[9] . ' ' . $row[10], // kolom J + K
                'no_hp' => $row[11], // kolom L
                'semester' => $row[13], // kolom O
                'prodi_id' => 2,
            ]);
        }
    }
}
