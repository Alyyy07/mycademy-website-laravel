<?php

namespace Database\Seeders;

use App\Models\Akademik\Matakuliah;
use Illuminate\Database\Seeder;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Matakuliah::create([
            'prodi_id' => 1,
            'kode_matakuliah' => 'MK001',
            'nama_matakuliah' => 'Dokter Jantung',
            'deskripsi' => 'Matakuliah ini membahas tentang dokter jantung',
            'sks' => 3,
        ]);

        Matakuliah::create([
            'prodi_id' => 1,
            'kode_matakuliah' => 'MK002',
            'nama_matakuliah' => 'Dokter Gigi',
            'deskripsi' => 'Matakuliah ini membahas tentang dokter gigi',
            'sks' => 3,
        ]);

        Matakuliah::create([
            'prodi_id' => 2,
            'kode_matakuliah' => 'MK003',
            'nama_matakuliah' => 'Pemrograman Desktop',
            'deskripsi' => 'Matakuliah ini membahas tentang pemrograman desktop',
            'sks' => 3,
        ]);

        Matakuliah::create([
            'prodi_id' => 2,
            'kode_matakuliah' => 'MK004',
            'nama_matakuliah' => 'Pemrograman Berorientasi Objek',
            'deskripsi' => 'Matakuliah ini membahas tentang pemrograman berorientasi objek',
            'sks' => 3,
        ]);

        Matakuliah::create([
            'prodi_id' => 2,
            'kode_matakuliah' => 'MK005',
            'nama_matakuliah' => 'Interaksi Manusia dan Komputer',
            'deskripsi' => 'Matakuliah ini membahas tentang interaksi manusia dan komputer',
            'sks' => 3,
        ]);
    }
}
