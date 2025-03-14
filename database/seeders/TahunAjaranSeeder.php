<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TahunAjaran::create([
            'kode_tahun_ajaran' => 'TH21',
            'tahun_ajaran' => '2021/2022',
            'tanggal_mulai' => '2021-07-01',
            'tanggal_selesai' => '2022-06-30',
            'is_active' => 1,
            'created_at' => now()
        ]);
    }
}
