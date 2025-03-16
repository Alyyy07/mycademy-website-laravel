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
            'kode_fakultas' => 'FK',
            'nama_fakultas' => 'Fakultas Kedokteran',
            'email' => 'kedokteran@gmail.com',
            'deskripsi' => 'Fakultas ini adalah fakultas kedokteran',
            'logo' => 'image/fakultas-logo/dd1cfe2f182da4742bd948fd4bf6e03c8cbb08a3aadfbd99af0df876b648bf03.png',
        ]);
    }
}
