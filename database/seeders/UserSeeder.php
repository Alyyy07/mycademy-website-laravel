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
            'name' => 'Admin Matakuliah',
            'email' => 'adminmatakuliah@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $adminMatakuliah->assignRole('admin-matakuliah');

        $dosen = User::create([
            'name' => 'dosen',
            'email' => 'dosen@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $dosen->assignRole('dosen');

        $mahasiswa = User::create([
            'name' => 'mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'email_verified_at' => now(),
            'password' =>'12345',
            'remember_token' => Str::random(10),
        ]);

        $mahasiswa->assignRole('mahasiswa');

        $mahasiswa2 = User::create([
            'name' => 'mahasiswa2',
            'email' => 'mahasiswa2@gmail.com',
            'verification_code' => '123456',
            'email_verified_at' => null,
            'password' =>'12345',
            'remember_token' => Str::random(10),
        ]);

        $mahasiswa2->assignRole('mahasiswa');
    }
}
