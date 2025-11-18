<?php

namespace Database\Seeders;

use App\Imports\MahasiswaImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new MahasiswaImport, storage_path('app/public/seeder/seederMahasiswa.xlsx'));
    }
}
