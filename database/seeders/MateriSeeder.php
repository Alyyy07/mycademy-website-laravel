<?php

namespace Database\Seeders;

use App\Models\Materi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Materi::create([
            'rps_detail_id' => 1,
            'title' => 'Pengenalan IoT',
            'tipe_materi' => 'video',
            'video_path' => 'https://www.youtube.com/watch?v=n-f8B76Hozk',
            'status' => 'verified',
            'uploader_id' => 'b4bbc461-be6c-4464-b529-aca0e8ab3719',
            'verifier_id' => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
            'created_at' => now(),
        ]);
        Materi::create([
            'rps_detail_id' => 1,
            'title' => 'Pengenalan IoT 2',
            'tipe_materi' => 'teks',
            'text_content' => '<section>  <h1>Pengenalan Internet of Things (IoT)</h1>  <p>Internet of Things (IoT) adalah konsep di mana objek fisik sehari-hari dilengkapi dengan sensor, perangkat lunak, dan konektivitas jaringan, sehingga dapat mengumpulkan dan bertukar data.</p>  <h2>Komponen Utama IoT</h2>  <ul>    <li><strong>Sensor dan Aktuator</strong>: Mengukur kondisi fisik (suhu, kelembapan, cahaya) dan melakukan aksi (menyalakan motor, membuka katup).</li>    <li><strong>Perangkat Edge</strong>: Mikrocontroller atau single-board computer (contoh: Arduino, Raspberry Pi) yang memproses data awal.</li>    <li><strong>Jaringan</strong>: Konektivitas (Wi‑Fi, Bluetooth, LoRa, NB‑IoT) untuk mengirim data ke cloud atau server.</li>    <li><strong>Cloud/Server</strong>: Menyimpan, mengolah, dan menganalisis data untuk menghasilkan insight.</li>    <li><strong>Antarmuka Pengguna</strong>: Aplikasi web atau mobile untuk monitoring dan kontrol.</li>  </ul>  <h2>Bagaimana IoT Bekerja</h2>  <ol>    <li><em>Pengumpulan Data</em>: Sensor mengukur parameter fisik.</li>    <li><em>Transmisi</em>: Data dikirim melalui jaringan ke cloud.</li>    <li><em>Penyimpanan & Pemrosesan</em>: Server menyimpan dan menganalisis data.</li>    <li><em>Visualisasi & Kontrol</em>: Hasil analisis ditampilkan di dashboard; pengguna dapat melakukan perintah balik.</li>  </ol>  <h2>Contoh Aplikasi IoT</h2>  <ul>    <li>Smart Home: Lampu, termostat, dan kunci pintu yang dapat dikontrol jarak jauh.</li>    <li>Agrikultur Cerdas: Sensor kelembapan tanah untuk optimasi irigasi.</li>    <li>Kesehatan</strong>: Monitor detak jantung dan tekanan darah real‑time.</li>  </ul>  <p>Dengan memahami komponen dan alur kerja ini, Anda sudah memiliki gambaran dasar tentang bagaimana sistem IoT dirancang dan diimplementasikan.</p></section>',
            'status' => 'verified',
            'uploader_id' => 'b4bbc461-be6c-4464-b529-aca0e8ab3719',
            'verifier_id' => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
            'created_at' => now(),
        ]);
    }
}
