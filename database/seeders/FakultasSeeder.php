<?php

namespace Database\Seeders;

use App\Models\Akademik\Fakultas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fakultas::create([
            'kode_fakultas' => 'FST',
            'nama_fakultas' => 'Fakultas Sains dan Teknologi',
            'email' => 'fst@university.ac.id',
            'deskripsi' => 'Fakultas Sains dan Teknologi',
            'logo' => 'image/fakultas-logo/dd1cfe2f182da4742bd948fd4bf6e03c8cbb08a3aadfbd99af0df876b648bf03.png',
        ]);
        Fakultas::create([
            'kode_fakultas' => 'FTI',
            'nama_fakultas' => 'Fakultas Teknik dan Informatika',
            'email' => 'fti@university.ac.id',
            'deskripsi' => 'Fakultas Teknik dan Informatika',
        ]);
    }
}
