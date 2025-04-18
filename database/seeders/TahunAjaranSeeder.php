<?php

namespace Database\Seeders;

use App\Models\Akademik\TahunAjaran;
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
            'is_active' => 0,
            'created_at' => now()
        ]);
        TahunAjaran::create([
            'kode_tahun_ajaran' => 'TH22',
            'tahun_ajaran' => '2022/2023',
            'tanggal_mulai' => '2022-07-01',
            'tanggal_selesai' => '2023-06-30',
            'is_active' => 0,
            'created_at' => now()
        ]);
        TahunAjaran::create([
            'kode_tahun_ajaran' => 'TH23',
            'tahun_ajaran' => '2023/2024',
            'tanggal_mulai' => '2023-07-01',
            'tanggal_selesai' => '2024-06-30',
            'is_active' => 0,
            'created_at' => now()
        ]);

        TahunAjaran::create([
            'kode_tahun_ajaran' => 'TH24',
            'tahun_ajaran' => '2024/2025',
            'tanggal_mulai' => '2024-07-01',
            'tanggal_selesai' => '2025-06-30',
            'is_active' => 0,
            'created_at' => now()
        ]);

        TahunAjaran::create([
            'kode_tahun_ajaran' => 'TH25',
            'tahun_ajaran' => '2025/2026',
            'tanggal_mulai' => '2025-04-12',
            'tanggal_selesai' => '2026-06-30',
            'is_active' => 1,
            'created_at' => now()
        ]);
    }
}
