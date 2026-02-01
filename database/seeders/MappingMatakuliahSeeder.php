<?php

namespace Database\Seeders;

use App\Models\MappingMatakuliah;
use App\Models\User;
use Illuminate\Database\Seeder;

class MappingMatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first two lecturers (will be used for IoT and Android courses)
        $dosens = User::role('dosen')->get();
        $dosenIot = $dosens->get(0);
        $dosenAndroid = $dosens->get(1);

        MappingMatakuliah::create([
            'tahun_ajaran_id' => '5',
            'matakuliah_id' => '5',
            'dosen_id' => $dosenIot->id,
            'admin_verifier_id' => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
            'semester' => '8',
        ]);

        MappingMatakuliah::create([
            'tahun_ajaran_id' => '5',
            'matakuliah_id' => '14',
            'dosen_id' => $dosenAndroid->id,
            'admin_verifier_id' => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
            'semester' => '8',
        ]);
    }
}
