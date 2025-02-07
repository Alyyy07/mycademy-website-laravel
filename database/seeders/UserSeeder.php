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
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345'),
            'remember_token' => Str::random(10),
        ]);

        $admin->assignRole('administrator');

        $mentor = User::create([
            'name' => 'mentor',
            'email' => 'mentor@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $mentor->assignRole('mentor');

        $siswa = User::create([
            'name' => 'siswa',
            'email' => 'siswa@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $siswa->assignRole('siswa');

        $siswa2 = User::create([
            'name' => 'siswa2',
            'email' => 'siswa2@gmail.com',
            'verification_code' => '123456',
            'email_verified_at' => null,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $siswa2->assignRole('siswa');

        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
