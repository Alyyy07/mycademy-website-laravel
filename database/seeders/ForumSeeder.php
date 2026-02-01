<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Materi;
use App\Models\RpsDetail;
use Carbon\Carbon;
use Faker\Factory;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $now   = Carbon::now();

        // Get first two lecturers (will be used for IoT and Android courses)
        $dosens = User::role('dosen')->get();
        $dosenIotId = $dosens->get(0)->id;
        $dosenAndroidId = $dosens->get(1)->id;
        $mahasiswaIds = User::whereHas('mahasiswa', function ($q) {
            $q->where('semester', 8);
        })->pluck('id');

        // Ambil materi yang RpsDetail-nya sudah direalisasi
        $materis = Materi::with('rpsDetail')
            ->whereHas('rpsDetail', function ($q) {
                $q->whereNotNull('tanggal_realisasi');
            })
            ->get();

        foreach ($materis as $materi) {
            $rps       = $materi->rpsDetail;
            $realisasi = Carbon::parse($rps->tanggal_realisasi);

            // Temukan RpsDetail berikutnya untuk batas jawaban
            $next = RpsDetail::where('rps_matakuliah_id', $rps->rps_matakuliah_id)
                ->where('sesi_pertemuan', '>', $rps->sesi_pertemuan)
                ->orderBy('sesi_pertemuan')
                ->first();

            // Tentukan batas akhir jawaban: sebelum pertemuan berikutnya atau sekarang
            if ($next) {
                $endReply = Carbon::parse($next->tanggal_pertemuan)->subSecond();
                if ($endReply->greaterThan($now)) {
                    $endReply = $now;
                }
            } else {
                $endReply = $now;
            }

            // 1. Buat pertanyaan dari dosen
            $senderDosen  = $materi->id <= 16 ? $dosenIotId : $dosenAndroidId;
            $questionTime = $faker->dateTimeBetween($realisasi, min($realisasi->copy()->addHour(), $endReply));

            DB::table('discussion_messages')->insert([
                'materi_id'  => $materi->id,
                'sender_id'  => $senderDosen,
                'message'    => $faker->sentence(mt_rand(6, 12)),
                'created_at' => $questionTime,
                'updated_at' => $questionTime,
            ]);

            // 2. Respons mahasiswa (~80% menjawab)
            foreach ($mahasiswaIds as $userId) {
                if (! $faker->boolean(80)) {
                    continue;
                }

                // Waktu mulai jawaban minimal setelah pertanyaan
                $start = Carbon::parse($questionTime);
                if ($start >= $endReply) {
                    continue;
                }
                $replyTime = $faker->dateTimeBetween($start, $endReply);

                DB::table('discussion_messages')->insert([
                    'materi_id'  => $materi->id,
                    'sender_id'  => $userId,
                    'message'    => $faker->sentence(mt_rand(8, 15)),
                    'created_at' => $replyTime,
                    'updated_at' => $replyTime,
                ]);
            }
        }
    }
}
