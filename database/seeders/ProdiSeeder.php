<?php

namespace Database\Seeders;

use App\Models\Akademik\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prodi::create([
            'fakultas_id' => 1,
            'kode_prodi' => 'DU',
            'nama_prodi' => 'Dokter Umum',
            'deskripsi' => 'Program Studi Dokter Umum',
        ]);
        Prodi::create([
            'fakultas_id' => 2,
            'kode_prodi' => 'TI',
            'nama_prodi' => 'Teknik Informatika',
            'deskripsi' => 'Program Studi Teknik Informatika',
        ]);
    }
}
