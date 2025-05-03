<?php

namespace Database\Seeders;

use App\Models\MappingMatakuliah;
use Illuminate\Database\Seeder;

class MappingMatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MappingMatakuliah::create([
            'tahun_ajaran_id' => '5',
            'matakuliah_id' => '4',
            'dosen_id' => 'b4bbc461-be6c-4464-b529-aca0e8ab3719',
            'admin_verifier_id' => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
            'semester' => '8',
        ]);
    }
}
