<?php

namespace Database\Seeders;

use App\Models\RpsDetail;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RpsDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definisi detail per sesi untuk masing-masing matakuliah
        $courseSessions = [
            // RPS Matakuliah ID 1: Teknologi IoT
            1 => [
                1  => [
                    'capaian'  => 'Memahami konsep dasar IoT dan arsitekturnya',
                    'indikator' => 'Mahasiswa dapat menjelaskan lapisan-lapisan arsitektur IoT',
                    'metode'   => 'Ceramah dan diskusi',
                    'kriteria' => 'Quiz singkat',
                    'materi'   => 'Pengantar IoT: definisi, komponen, arsitektur',
                ],
                2  => [
                    'capaian'  => 'Mengetahui jenis sensor dan aktuator pada IoT',
                    'indikator' => 'Mahasiswa dapat mengidentifikasi sensor dan aktuator umum',
                    'metode'   => 'Presentasi dan demonstrasi',
                    'kriteria' => 'Tugas identifikasi',
                    'materi'   => 'Sensor, aktuator, dan kegunaannya',
                ],
                3  => [
                    'capaian'  => 'Memahami protokol komunikasi pada IoT',
                    'indikator' => 'Mahasiswa dapat membandingkan MQTT, HTTP, CoAP',
                    'metode'   => 'Diskusi kelompok',
                    'kriteria' => 'Laporan diskusi',
                    'materi'   => 'Protokol MQTT, HTTP, CoAP',
                ],
                4  => [
                    'capaian'  => 'Mampu merancang topologi jaringan IoT sederhana',
                    'indikator' => 'Mahasiswa dapat menggambar skema jaringan IoT',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Penilaian skema jaringan',
                    'materi'   => 'Perancangan jaringan IoT',
                ],
                5  => [
                    'capaian'  => 'Menguasai konfigurasi mikrokontroler untuk IoT',
                    'indikator' => 'Mahasiswa dapat mengupload firmware ke ESP32',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Demo praktikum',
                    'materi'   => 'ESP32: setup dan pemrograman awal',
                ],
                6  => [
                    'capaian'  => 'Memahami pengiriman data sensor ke server',
                    'indikator' => 'Mahasiswa dapat mengirim data suhu ke MQTT broker',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas praktik',
                    'materi'   => 'Publish/Subscribe MQTT',
                ],
                7  => [
                    'capaian'  => 'Mampu membuat dashboard monitoring IoT',
                    'indikator' => 'Mahasiswa dapat menampilkan data sensor secara real-time',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Penilaian dashboard',
                    'materi'   => 'Dashboard menggunakan Node-RED',
                ],
                8  => [
                    'capaian'  => 'Memahami keamanan dasar pada sistem IoT',
                    'indikator' => 'Mahasiswa dapat menjelaskan enkripsi data MQTT',
                    'metode'   => 'Ceramah dan studi kasus',
                    'kriteria' => 'Quiz terbuka',
                    'materi'   => 'Keamanan: TLS/SSL pada MQTT',
                ],
                9  => [
                    'capaian'  => 'Mampu mengintegrasi IoT dengan cloud platform',
                    'indikator' => 'Mahasiswa dapat mengirim data ke AWS IoT Core',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas integrasi',
                    'materi'   => 'AWS IoT Core atau Azure IoT Hub',
                ],
                10 => [
                    'capaian'  => 'Memahami analisis data IoT dasar',
                    'indikator' => 'Mahasiswa dapat menerapkan filter pada data waktu-nyata',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Laporan praktikum',
                    'materi'   => 'Data processing dasar',
                ],
                11 => [
                    'capaian'  => 'Mampu membuat notifikasi berbasis kejadian IoT',
                    'indikator' => 'Mahasiswa dapat mengirim alert email/WhatsApp',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Demo sistem alert',
                    'materi'   => 'Event-driven notification',
                ],
                12 => [
                    'capaian'  => 'Memahami arsitektur edge computing pada IoT',
                    'indikator' => 'Mahasiswa dapat menjelaskan konsep edge vs cloud',
                    'metode'   => 'Diskusi dan ceramah',
                    'kriteria' => 'Quiz konseptual',
                    'materi'   => 'Edge computing untuk IoT',
                ],
                13 => [
                    'capaian'  => 'Mampu menerapkan konsep edge pada project IoT',
                    'indikator' => 'Mahasiswa dapat memproses data di perangkat edge',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Penilaian kode',
                    'materi'   => 'Implementasi edge computing',
                ],
                14 => [
                    'capaian'  => 'Memahami integrasi IoT dengan mobile apps',
                    'indikator' => 'Mahasiswa dapat membuat request API dari Android',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas integrasi',
                    'materi'   => 'REST API untuk IoT',
                ],
                15 => [
                    'capaian'  => 'Mampu merancang studi kasus IoT end-to-end',
                    'indikator' => 'Mahasiswa dapat mempresentasikan arsitektur solusi',
                    'metode'   => 'Presentasi kelompok',
                    'kriteria' => 'Penilaian presentasi',
                    'materi'   => 'Studi kasus IoT',
                ],
                16 => [
                    'capaian'  => 'Mampu mengevaluasi performa sistem IoT',
                    'indikator' => 'Mahasiswa dapat mengukur latency dan throughput',
                    'metode'   => 'Praktik dan diskusi',
                    'kriteria' => 'Laporan evaluasi',
                    'materi'   => 'Pengukuran performa IoT',
                ],
            ],

            // RPS Matakuliah ID 2: Pengembangan Aplikasi Android
            2 => [
                1  => [
                    'capaian'  => 'Memahami ekosistem pengembangan Android',
                    'indikator' => 'Mahasiswa dapat menjelaskan arsitektur Android',
                    'metode'   => 'Ceramah',
                    'kriteria' => 'Quiz dasar',
                    'materi'   => 'Pengantar Android dan arsitektur',
                ],
                2  => [
                    'capaian'  => 'Mampu menyiapkan environment Android Studio',
                    'indikator' => 'Mahasiswa dapat membuat project baru',
                    'metode'   => 'Demo dan praktik',
                    'kriteria' => 'Tugas setup',
                    'materi'   => 'Android Studio & SDK',
                ],
                3  => [
                    'capaian'  => 'Memahami komponen UI dasar Android',
                    'indikator' => 'Mahasiswa dapat menggunakan TextView dan Button',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas UI sederhana',
                    'materi'   => 'View, Layout, dan Resource',
                ],
                4  => [
                    'capaian'  => 'Mampu membuat layout kompleks dengan XML',
                    'indikator' => 'Mahasiswa dapat mengimplementasi ConstraintLayout',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Penilaian layout',
                    'materi'   => 'Layout XML dan ConstraintLayout',
                ],
                5  => [
                    'capaian'  => 'Memahami activity lifecycle',
                    'indikator' => 'Mahasiswa dapat menjelaskan callback lifecycle',
                    'metode'   => 'Ceramah dan diskusi',
                    'kriteria' => 'Quiz lifecycle',
                    'materi'   => 'Activity & Fragment lifecycle',
                ],
                6  => [
                    'capaian'  => 'Mampu berkomunikasi antar activity',
                    'indikator' => 'Mahasiswa dapat menggunakan Intent',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas Intent',
                    'materi'   => 'Intent dan data passing',
                ],
                7  => [
                    'capaian'  => 'Memahami penyimpanan lokal di Android',
                    'indikator' => 'Mahasiswa dapat menggunakan SharedPreferences',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas penyimpanan',
                    'materi'   => 'SharedPreferences & SQLite',
                ],
                8  => [
                    'capaian'  => 'Mampu membuat dan mengelola database SQLite',
                    'indikator' => 'Mahasiswa dapat CRUD data',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas CRUD',
                    'materi'   => 'Room Persistence Library',
                ],
                9  => [
                    'capaian'  => 'Memahami arsitektur MVVM pada Android',
                    'indikator' => 'Mahasiswa dapat menjelaskan komponen ViewModel',
                    'metode'   => 'Ceramah',
                    'kriteria' => 'Quiz MVVM',
                    'materi'   => 'MVVM & LiveData',
                ],
                10 => [
                    'capaian'  => 'Mampu menggunakan Retrofit untuk API',
                    'indikator' => 'Mahasiswa dapat melakukan request HTTP',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas API',
                    'materi'   => 'Retrofit & JSON parsing',
                ],
                11 => [
                    'capaian'  => 'Memahami coroutine dan threading',
                    'indikator' => 'Mahasiswa dapat menjalankan operasi background',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas threading',
                    'materi'   => 'Kotlin Coroutines',
                ],
                12 => [
                    'capaian'  => 'Mampu membuat UI responsif dengan RecyclerView',
                    'indikator' => 'Mahasiswa dapat menampilkan list dinamis',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas RecyclerView',
                    'materi'   => 'RecyclerView & Adapter',
                ],
                13 => [
                    'capaian'  => 'Memahami navigasi antar fragment',
                    'indikator' => 'Mahasiswa dapat mengimplementasikan Navigation Component',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas navigasi',
                    'materi'   => 'Navigation Component',
                ],
                14 => [
                    'capaian'  => 'Mampu menambahkan fitur autentikasi',
                    'indikator' => 'Mahasiswa dapat integrasi Firebase Auth',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas Auth',
                    'materi'   => 'Firebase Authentication',
                ],
                15 => [
                    'capaian'  => 'Memahami deploy aplikasi ke Play Store',
                    'indikator' => 'Mahasiswa dapat menyiapkan release build',
                    'metode'   => 'Ceramah dan demo',
                    'kriteria' => 'Quiz proses deploy',
                    'materi'   => 'Publishing Android App',
                ],
                16 => [
                    'capaian'  => 'Mampu melakukan pengujian dan debugging',
                    'indikator' => 'Mahasiswa dapat menulis unit test',
                    'metode'   => 'Praktik lab',
                    'kriteria' => 'Tugas testing',
                    'materi'   => 'Unit Test & Debugging',
                ],
            ],
        ];

        foreach ($courseSessions as $rpsId => $sessions) {
            foreach ($sessions as $sesi => $detail) {
                // 1. Hitung tanggal pertemuan utama berdasarkan sesi
                $tanggalPertemuan = Carbon::parse('2025-01-17')
                    ->addWeeks($sesi - 1)
                    ->toDateString();

                // 2. Simulasi tanggal realisasi: pertemuan + 0–1 hari, jam acak
                $tentative = Carbon::parse($tanggalPertemuan)
                    ->addDays(rand(0, 1))
                    ->setTime(rand(8, 17), rand(0, 59), rand(0, 59));

                if ($tentative->isFuture()) {
                    $tanggalRealisasi = null;
                    $closeForum       = false;
                } else {
                    $tanggalRealisasi = $tentative->toDateTimeString();
                    // Tutup forum setelah 7 hari realisasi
                    $closeForum = $tentative->copy()->addDays(7)->isPast();
                }

                // 3. Tentukan tanggal_pengganti & status_pengganti
                //    - Misalnya: untuk sesi ke-3 => pending; sesi ke-5 => approved; sesi ke-7 => rejected
                $tanggalPengganti = null;
                $statusPengganti  = 'pending';

                if ($sesi === 3) {
                    $tanggalPengganti = Carbon::parse($tanggalPertemuan)->addDays(2)->toDateString();
                    $statusPengganti  = 'approved';
                } elseif ($sesi === 5) {
                    $tanggalPengganti = Carbon::parse($tanggalPertemuan)->addDays(3)->toDateString();
                    $statusPengganti  = 'approved';
                } elseif ($sesi === 7) {
                    $tanggalPengganti = Carbon::parse($tanggalPertemuan)->addDays(2)->toDateString();
                    $statusPengganti  = 'rejected';
                }
                // Sisanya ($sesi lainnya) biarkan null => belum ada pengajuan

                // 4. Buat record RpsDetail
                RpsDetail::create([
                    'rps_matakuliah_id'     => $rpsId,
                    'sesi_pertemuan'        => $sesi,
                    'tanggal_pertemuan'      => $tanggalPertemuan,
                    'tanggal_pengganti'     => $tanggalPengganti,      // bisa null atau date string
                    'status_pengganti'      => $statusPengganti,       // bisa null atau 'pending'/'approved'/'rejected'
                    'capaian_pembelajaran'  => $detail['capaian'],
                    'indikator'             => $detail['indikator'],
                    'metode_pembelajaran'   => $detail['metode'],
                    'kriteria_penilaian'    => $detail['kriteria'],
                    'materi_pembelajaran'   => $detail['materi'],
                    'tanggal_realisasi'     => $tanggalRealisasi,  // bisa null atau date-time string
                    'close_forum'           => $closeForum,
                ]);
            }
        }
    }
}
