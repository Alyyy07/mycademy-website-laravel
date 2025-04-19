<?php

namespace Database\Seeders;

use App\Imports\MatakuliahImport;
use App\Models\Akademik\Matakuliah;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new MatakuliahImport, storage_path('app/public/seeder/seederMatakuliah.xlsx'));
    }
}
