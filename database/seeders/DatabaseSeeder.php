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
            UserSeeder::class,
            TahunAjaranSeeder::class,
            FakultasSeeder::class,
            MatakuliahSeeder::class,
            PermissionSeeder::class,
            AccessSeeder::class,
        ]);
    }
}
