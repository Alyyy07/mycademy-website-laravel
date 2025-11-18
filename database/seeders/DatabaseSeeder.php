<?php

namespace Database\Seeders;

use App\Models\Kuis;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MenuSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            AccessSeeder::class,
            UserSeeder::class,
            TahunAjaranSeeder::class,
            FakultasSeeder::class,
            ProdiSeeder::class,
            MahasiswaSeeder::class,
            MatakuliahSeeder::class,
            MappingMatakuliahSeeder::class,
            RpsMatakuliahSeeder::class,
            RpsDetailSeeder::class,
            MateriSeeder::class,
            KuisSeeder::class,
            MateriSelesaiSeeder::class,
            KuisSelesaiSeeder::class,
            ForumSeeder::class,
        ]);
    }
}
