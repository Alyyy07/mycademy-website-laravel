<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => 'super-admin', 'description' => 'Bertanggung jawab atas pengelolaan pengguna, pembuatan RPS dan pengelolaan matakuliah']);
        Role::create(['name' => 'admin-matakuliah','description' => 'Bertanggung jawab atas pengelolaan materi, tugas, dan ujian yang diunggah oleh dosen']);
        Role::create(['name' => 'dosen','description'=> 'Bertanggung jawab atas pengunggahan materi, tugas, dan ujian,berpartisipasi dalam forum diskusi, serta memberikan nilai kepada mahasiswa']);
        Role::create(['name' => 'mahasiswa','description'=> 'Bertanggung jawab atas mengikuti perkuliahan, berpartisipasi dalam forum diskusi, mengumpulkan tugas, dan ujian']);
    }
}
