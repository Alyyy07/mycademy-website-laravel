<?php

namespace Database\Seeders;

use App\Models\RpsDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RpsDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RpsDetail::create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 1,
            'tanggal_pertemuan' => '2025-04-15',
            'capaian_pembelajaran' => 'Mampu menjelaskan pengertian dan tujuan dari pemrograman web',
            'indikator' => 'Mahasiswa dapat menjelaskan pengertian dan tujuan dari pemrograman web',
            'metode_pembelajaran' => 'Diskusi',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Pengertian dan tujuan pemrograman web'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 2,
            'tanggal_pertemuan' => '2025-04-22',
            'capaian_pembelajaran' => 'Mampu menjelaskan konsep dasar HTML',
            'indikator' => 'Mahasiswa dapat menjelaskan konsep dasar HTML',
            'metode_pembelajaran' => 'Diskusi',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Konsep dasar HTML'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 3,
            'tanggal_pertemuan' => '2025-04-29',
            'capaian_pembelajaran' => 'Mampu membuat halaman web sederhana menggunakan HTML',
            'indikator' => 'Mahasiswa dapat membuat halaman web sederhana menggunakan HTML',
            'metode_pembelajaran' => 'Praktikum',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Membuat halaman web sederhana menggunakan HTML'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 4,
            'tanggal_pertemuan' => '2025-05-06',
            'capaian_pembelajaran' => 'Mampu menjelaskan konsep dasar CSS',
            'indikator' => 'Mahasiswa dapat menjelaskan konsep dasar CSS',
            'metode_pembelajaran' => 'Diskusi',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Konsep dasar CSS'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 5,
            'tanggal_pertemuan' => '2025-05-13',
            'capaian_pembelajaran' => 'Mampu membuat halaman web sederhana menggunakan CSS',
            'indikator' => 'Mahasiswa dapat membuat halaman web sederhana menggunakan CSS',
            'metode_pembelajaran' => 'Praktikum',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Membuat halaman web sederhana menggunakan CSS'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 6,
            'tanggal_pertemuan' => '2025-05-20',
            'capaian_pembelajaran' => 'Mampu menjelaskan konsep dasar JavaScript',
            'indikator' => 'Mahasiswa dapat menjelaskan konsep dasar JavaScript',
            'metode_pembelajaran' => 'Diskusi',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Konsep dasar JavaScript'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 7,
            'tanggal_pertemuan' => '2025-05-27',
            'capaian_pembelajaran' => 'Mampu membuat halaman web sederhana menggunakan JavaScript',
            'indikator' => 'Mahasiswa dapat membuat halaman web sederhana menggunakan JavaScript',
            'metode_pembelajaran' => 'Praktikum',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Membuat halaman web sederhana menggunakan JavaScript'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 8,
            'tanggal_pertemuan' => '2025-06-03',
            'capaian_pembelajaran' => 'Mampu menjelaskan konsep dasar PHP',
            'indikator' => 'Mahasiswa dapat menjelaskan konsep dasar PHP',
            'metode_pembelajaran' => 'Diskusi',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Konsep dasar PHP'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 9,
            'tanggal_pertemuan' => '2025-06-10',
            'capaian_pembelajaran' => 'Mampu membuat halaman web sederhana menggunakan PHP',
            'indikator' => 'Mahasiswa dapat membuat halaman web sederhana menggunakan PHP',
            'metode_pembelajaran' => 'Praktikum',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Membuat halaman web sederhana menggunakan PHP'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 10,
            'tanggal_pertemuan' => '2025-06-17',
            'capaian_pembelajaran' => 'Mampu menjelaskan konsep dasar MySQL',
            'indikator' => 'Mahasiswa dapat menjelaskan konsep dasar MySQL',
            'metode_pembelajaran' => 'Diskusi',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Konsep dasar MySQL'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 11,
            'tanggal_pertemuan' => '2025-06-24',
            'capaian_pembelajaran' => 'Mampu membuat halaman web sederhana menggunakan MySQL',
            'indikator' => 'Mahasiswa dapat membuat halaman web sederhana menggunakan MySQL',
            'metode_pembelajaran' => 'Praktikum',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Membuat halaman web sederhana menggunakan MySQL'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 12,
            'tanggal_pertemuan' => '2025-07-01',
            'capaian_pembelajaran' => 'Mampu menjelaskan konsep dasar framework PHP',
            'indikator' => 'Mahasiswa dapat menjelaskan konsep dasar framework PHP',
            'metode_pembelajaran' => 'Diskusi',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Konsep dasar framework PHP'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 13,
            'tanggal_pertemuan' => '2025-07-08',
            'capaian_pembelajaran' => 'Mampu membuat aplikasi web sederhana menggunakan framework PHP',
            'indikator' => 'Mahasiswa dapat membuat aplikasi web sederhana menggunakan framework PHP',
            'metode_pembelajaran' => 'Praktikum',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Membuat aplikasi web sederhana menggunakan framework PHP'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 14,
            'tanggal_pertemuan' => '2025-07-15',
            'capaian_pembelajaran' => 'Mampu menjelaskan konsep dasar REST API',
            'indikator' => 'Mahasiswa dapat menjelaskan konsep dasar REST API',
            'metode_pembelajaran' => 'Diskusi',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Konsep dasar REST API'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 15,
            'tanggal_pertemuan' => '2025-07-22',
            'capaian_pembelajaran' => 'Mampu membuat aplikasi web sederhana menggunakan REST API',
            'indikator' => 'Mahasiswa dapat membuat aplikasi web sederhana menggunakan REST API',
            'metode_pembelajaran' => 'Praktikum',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Membuat aplikasi web sederhana menggunakan REST API'
        ])->create([
            'rps_matakuliah_id' => 1,
            'sesi_pertemuan' => 16,
            'tanggal_pertemuan' => '2025-07-29',
            'capaian_pembelajaran' => 'Mampu menjelaskan konsep dasar deployment aplikasi web',
            'indikator' => 'Mahasiswa dapat menjelaskan konsep dasar deployment aplikasi web',
            'metode_pembelajaran' => 'Diskusi',
            'kriteria_penilaian' => 'Tugas',
            'materi_pembelajaran' => 'Konsep dasar deployment aplikasi web'
        ]);
    }
}
