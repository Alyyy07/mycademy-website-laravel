<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $superAdmin->assignRole('super-admin');

        $adminMatakuliah = User::create([
            'name' => 'Admin Web',
            'email' => 'adminweb@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $adminMatakuliah->assignRole('admin-matakuliah');

        $dosen = User::create([
            'name' => 'Dosen Web',
            'email' => 'dosenweb@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $dosen->assignRole('dosen');

        $adminMatakuliah1 = User::create([
            'name' => 'Admin OOP',
            'email' => 'adminoop@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $adminMatakuliah1->assignRole('admin-matakuliah');

        $dosen1 = User::create([
            'name' => 'Dosen OOP',
            'email' => 'dosenoop@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $dosen1->assignRole('dosen');

        $mahasiswa = User::create([
            'name' => 'mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $mahasiswa->assignRole('mahasiswa');

        $mahasiswa2 = User::create([
            'name' => 'mahasiswa2',
            'email' => 'mahasiswa2@gmail.com',
            'verification_code' => '123456',
            'email_verified_at' => null,
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $mahasiswa2->assignRole('mahasiswa');
    }
}
