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
            'kode_prodi' => 'DK',
            'nama_prodi' => 'Dokter',
            'deskripsi' => 'Program Studi Dokter',
        ]);
        Prodi::create([
            'fakultas_id' => 2,
            'kode_prodi' => 'TI',
            'nama_prodi' => 'Teknik Informatika',
            'deskripsi' => 'Program Studi Teknik Informatika',
        ]);
    }
}
