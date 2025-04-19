<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

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
            'id' => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
            'name' => 'Admin OOP',
            'email' => 'adminoop@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $adminMatakuliah1->assignRole('admin-matakuliah');

        $dosen1 = User::create([
            'id' => 'b4bbc461-be6c-4464-b529-aca0e8ab3719',
            'name' => 'Dosen OOP',
            'email' => 'dosenoop@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $dosen1->assignRole('dosen');


        Excel::import(new \App\Imports\DosenImport, storage_path('app/public/seeder/seederDosen.xlsx'));
    }
}
