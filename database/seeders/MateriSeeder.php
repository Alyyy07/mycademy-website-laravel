<?php

namespace Database\Seeders;

use App\Models\Materi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Materi::create([
            'rps_detail_id' => 1,
            'title' => 'Pengenalan IoT',
            'tipe_materi' => 'video',
            'video_path'=>'https://www.youtube.com/watch?v=n-f8B76Hozk',
            'status' => 'verified',
            'uploader_id' => 'b4bbc461-be6c-4464-b529-aca0e8ab3719',
            'verifier_id' => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
            'created_at' => now(),
        ]);
    }
}
