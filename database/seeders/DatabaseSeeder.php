<?php

namespace Database\Seeders;

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
            MatakuliahSeeder::class,
            MappingMatakuliahSeeder::class,
            RpsMatakuliahSeeder::class,
            RpsDetailSeeder::class,
            KuisSeeder::class,
        ]);
    }
}
