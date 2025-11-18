<?php

namespace Database\Seeders;

use App\Models\RpsMatakuliah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RpsMatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RpsMatakuliah::create([
            'mapping_matakuliah_id' => 1,
            'tanggal_mulai' => '2025-01-17',
            'tanggal_selesai' => '2026-04-30',
            
        ]);
        RpsMatakuliah::create([
            'mapping_matakuliah_id' => 2,
            'tanggal_mulai' => '2025-01-17',
            'tanggal_selesai' => '2026-04-30',
        ]);
    }
}
