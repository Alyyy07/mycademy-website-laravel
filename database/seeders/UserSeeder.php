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

        $adminMatakuliah1 = User::create([
            'id' => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
            'name' => 'Admin Matakuliah',
            'email' => 'adminmatakuliah@gmail.com',
            'email_verified_at' => now(),
            'password' => '12345',
            'remember_token' => Str::random(10),
        ]);

        $adminMatakuliah1->assignRole('admin-matakuliah');


        Excel::import(new \App\Imports\DosenImport, storage_path('app/public/seeder/seederDosen.xlsx'));
    }
}
