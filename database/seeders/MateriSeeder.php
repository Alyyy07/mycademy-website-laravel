<?php

namespace Database\Seeders;

use App\Models\Materi;
use App\Models\User;
use App\Models\RpsDetail;
use App\Models\RpsMatakuliah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Teknologi IoT
        $dosenIotId = User::where('name', 'like', 'Arda Gusema%')->first()->id;
        $dosenAndroidId = User::where('name', 'like', 'Iddrus%')->first()->id;

        Storage::disk('public')
            ->copy('seeder/iot_pertemuan_1.pdf', 'materi/pdf/iot_pertemuan_1.pdf');

        Storage::disk('public')->copy('seeder/android_pertemuan_1.pdf', 'materi/pdf/android_pertemuan_1.pdf');

        // Materi entries
        $materiIoT = [
            [1, 'Pengenalan IoT', 'pdf', 'materi/pdf/pertemuan_1.pdf'],
            [2, 'Jenis sensor dan aktuator pada IoT', 'teks', '<section>
                <h1>Jenis sensor dan aktuator pada IoT</h1>
                <p>Sensor dan aktuator adalah dua komponen penting dalam sistem IoT. Sensor digunakan untuk mengumpulkan data dari lingkungan, sedangkan aktuator digunakan untuk mengendalikan perangkat berdasarkan data yang diterima.</p>
                <h2>Sensor</h2>
                <p>Sensor adalah perangkat yang dapat mendeteksi perubahan fisik atau lingkungan dan mengubahnya menjadi sinyal listrik. Contoh sensor yang umum digunakan dalam IoT antara lain:</p>
                <ul>
                    <li>Sensor suhu</li>
                    <li>Sensor kelembapan</li>
                    <li>Sensor cahaya</li>
                    <li>Sensor gerak</li>
                </ul>
                <h2>Aktuator</h2>
                <p>Aktuator adalah perangkat yang dapat mengubah energi listrik menjadi gerakan fisik. Contoh aktuator yang umum digunakan dalam IoT antara lain:</p>
                <ul>
                    <li>Motor DC</li>
                    <li>Servo motor</li>
                    <li>Relay</li>
                </ul>
                <h2>Kesimpulan</h2>
                <p>Sensor dan aktuator adalah komponen penting dalam sistem IoT. Sensor digunakan untuk mengumpulkan data dari lingkungan, sedangkan aktuator digunakan untuk mengendalikan perangkat berdasarkan data yang diterima.</p>
            </section>'],
            [3, 'Protokol komunikasi pada IoT', 'video', 'https://www.youtube.com/watch?v=wz_RGcvZJHw'],
            [4, 'Perancangan jaringan IoT', 'video', 'https://www.youtube.com/watch?v=mKtxItZWfcI'],
            [5, 'ESP32: setup dan pemrograman awal', 'video', 'https://www.youtube.com/watch?v=tc3Qnf79Ny8'],
            [6, 'Publish/Subscribe MQTT', 'video', 'https://www.youtube.com/watch?v=CKekwlMiF_E'],
            [7, 'Dashboard menggunakan Node‑RED', 'video', 'https://www.youtube.com/watch?v=c3WYSUaFZqA'],
            [8, 'Keamanan: TLS/SSL pada MQTT', 'video', 'https://www.youtube.com/watch?v=1Tu0tc0VHuc'],
            [9, 'Integrasi IoT dengan AWS IoT Core', 'video', 'https://www.youtube.com/watch?v=WtQmVudtfyM'],
            [10, 'Data processing dasar', 'video', 'https://www.youtube.com/watch?v=D7hiqHk3jSk'],
            [11, 'Event‑driven notification', 'video', 'https://www.youtube.com/watch?v=CtaVAPHkxvM'],
            [12, 'Edge computing untuk IoT', 'video', 'https://www.youtube.com/watch?v=cAUAwFlcIds'],
            [13, 'Implementasi edge computing', 'video', 'https://www.youtube.com/watch?v=tQtvsu_kJog'],
            [14, 'REST API untuk IoT', 'video', 'https://www.youtube.com/watch?v=cRV4HQ39S2s'],
            [15, 'Studi kasus IoT end‑to‑end', 'video', 'https://www.youtube.com/watch?v=ixuWoR0vJxA'],
            [16, 'Pengukuran performa IoT', 'video', 'https://www.youtube.com/watch?v=lPrutFbjfZE'],
        ];

        $androidMateri = [
            1  => ['Pengantar Android dan arsitektur', 'pdf',   'materi/pdf/android_pertemuan_1.pdf'],
            2  => ['Android Studio & SDK',            'teks',  '<section>
                    <h1>Android Studio & SDK</h1>

  <p><strong>Android Studio</strong> adalah lingkungan pengembangan terintegrasi (IDE) resmi untuk pengembangan aplikasi Android. Dikembangkan oleh Google, Android Studio didasarkan pada IntelliJ IDEA dan menyediakan berbagai fitur canggih untuk meningkatkan produktivitas developer.</p>

  <h2>Fitur Utama Android Studio</h2>
  <ul>
    <li>Editor kode cerdas dengan auto-complete dan refactoring.</li>
    <li>Emulator Android untuk pengujian aplikasi tanpa perangkat fisik.</li>
    <li>Layout Editor drag-and-drop untuk desain UI.</li>
    <li>Integrasi dengan Firebase dan layanan Google lainnya.</li>
    <li>Build system berbasis Gradle yang fleksibel.</li>
  </ul>

  <h2>Software Development Kit (SDK)</h2>
  <p><strong>Android SDK</strong> adalah kumpulan alat pengembangan yang diperlukan untuk membuat aplikasi Android. SDK ini menyediakan API Android, emulator, tools debugging, dan build utilities.</p>

  <h3>Komponen Utama Android SDK:</h3>
  <ul>
    <li><strong>SDK Tools:</strong> Termasuk adb (Android Debug Bridge), fastboot, dll.</li>
    <li><strong>SDK Platform-tools:</strong> Tools khusus untuk platform Android tertentu.</li>
    <li><strong>SDK Build-tools:</strong> Compiler dan utilitas untuk membangun aplikasi.</li>
    <li><strong>System Images:</strong> Diperlukan untuk emulator.</li>
    <li><strong>Android Platform API:</strong> Kumpulan library API berdasarkan versi Android tertentu.</li>
  </ul>

  <h2>Langkah Instalasi Android Studio</h2>
  <ol>
    <li>Unduh Android Studio dari situs resmi: <a href="https://developer.android.com/studio" target="_blank">developer.android.com/studio</a></li>
    <li>Install Android Studio dan ikuti wizard setup.</li>
    <li>Pastikan SDK Manager sudah mengunduh SDK platform terbaru.</li>
    <li>Buat proyek baru dan mulai coding!</li>
  </ol>

  <h2>Contoh Kode Sederhana</h2>
  <p>Berikut adalah contoh kode <code>MainActivity.java</code> pada aplikasi Android dasar:</p>
  <pre><code>package com.example.helloworld;

import android.os.Bundle;
import android.widget.TextView;
import androidx.appcompat.app.AppCompatActivity;

public class MainActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        TextView textView = new TextView(this);
        textView.setText("Hello, Android!");
        setContentView(textView);
    }
}</code></pre>
  <h2>Kesimpulan</h2>
  <p>Android Studio dan SDK adalah fondasi utama dalam pengembangan aplikasi Android modern. Dengan memahami keduanya, developer dapat membangun aplikasi yang efisien, handal, dan menarik. Disarankan untuk terus memperbarui Android Studio dan SDK agar mendapatkan fitur terbaru dan kompatibilitas dengan versi Android terbaru.</p>
    <p>Untuk informasi lebih lanjut, kunjungi dokumentasi resmi Android Studio di <a href="https://developer.android.com/studio" target="_blank">developer.android.com/studio</a>.</p>
                </section>'],
            3  => ['View, Layout, dan Resource',      'video',  'https://www.youtube.com/watch?v=aJ8zsPbjdqc'],
            4  => ['Layout XML dan ConstraintLayout', 'video',  'https://www.youtube.com/watch?v=VsgXFdynDuQ'],
            5  => ['Activity & Fragment Lifecycle',    'video',  'https://www.youtube.com/watch?v=SJw3Nu_h8kk'],
            6  => ['Intent dan Data Passing',          'video',  'https://www.youtube.com/watch?v=cg3-m2S3Bb8'],
            7  => ['SharedPreferences & SQLite',       'video',  'https://www.youtube.com/watch?v=jiD2fxn8iKA'],
            8  => ['Room Persistence Library',         'video',  'https://www.youtube.com/watch?v=bOd3wO0uFr8'],
            9  => ['MVVM & LiveData',                  'video',  'https://www.youtube.com/watch?v=eUQebUJLnXI'],
            10 => ['Retrofit & JSON Parsing',          'video',  'https://www.youtube.com/watch?v=aV3EkU-6SCk'],
            11 => ['Kotlin Coroutines',                'video',  'https://www.youtube.com/watch?v=e7tKQDJsTGs'],
            12 => ['RecyclerView & Adapter',           'video',  'https://www.youtube.com/watch?v=__OMnFR-wZU'],
            13 => ['Navigation Component',             'video',  'https://www.youtube.com/watch?v=DI0NIk-7cz8'],
            14 => ['Firebase Authentication',          'video',  'https://www.youtube.com/watch?v=wm626abfMM8'],
            15 => ['Publishing Android App',           'video',  'https://www.youtube.com/watch?v=VfGW0Qiy2I0'],
            16 => ['Unit Test & Debugging',            'video',  'https://www.youtube.com/watch?v=2I6fuD20qlY'],
        ];

        foreach ($materiIoT as [$rpsDetailId, $title, $type, $content]) {
            $data = [
                'rps_detail_id' => $rpsDetailId,
                'title'         => $title,
                'tipe_materi'   => $type,
                'status'        => 'verified',
                'uploader_id'   => $dosenIotId,
                'verifier_id'   => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
                'created_at'    => Carbon::parse(RpsMatakuliah::find(1)->created_at)->subDays(3),
            ];

            if ($type === 'pdf') {
                $data['file_path'] = $content;
            } elseif ($type === 'teks') {
                $data['text_content'] = $content;
            } elseif ($type === 'video') {
                $data['video_path'] = $content;
            }

            Materi::create($data);
        }

        foreach ($androidMateri as $rpsDetailId => [$title, $type, $content]) {
            $data = [
                'rps_detail_id' => (16 + $rpsDetailId),
                'title'         => $title,
                'tipe_materi'   => $type,
                'status'        => 'verified',
                'uploader_id'   => $dosenAndroidId,
                'verifier_id'   => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
                'created_at'    => Carbon::parse(RpsMatakuliah::find(2)->created_at)->subDays(3),
            ];

            if ($type === 'pdf') {
                $data['file_path'] = $content;
            } elseif ($type === 'teks') {
                $data['text_content'] = $content;
            } elseif ($type === 'video') {
                $data['video_path'] = $content;
            }

            Materi::create($data);
        }
    }
}
