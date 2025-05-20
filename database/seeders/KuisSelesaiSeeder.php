<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\RpsDetail;
use Carbon\Carbon;
use Faker\Factory;

class KuisSelesaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $now   = Carbon::now();

        // Ambil semua mahasiswa (role 'mahasiswa')
        $mahasiswaIds = User::whereHas('mahasiswa', function ($q) {
            $q->where('semester', 8);
        })->pluck('id');

        // Ambil RpsDetail per matakuliah (untuk menentukan tanggal pertemuan)
        RpsDetail::where('tanggal_pertemuan', '<', $now)
            ->orderBy('rps_matakuliah_id')
            ->orderBy('sesi_pertemuan')
            ->get()
            ->groupBy('rps_matakuliah_id')
            ->each(function ($detailsGroup) use ($mahasiswaIds, $faker, $now) {
                $details = $detailsGroup->values();

                foreach ($details as $index => $current) {
                    $next = $details->get($index + 1);

                    // Tentukan batas on-time berdasarkan tanggal_pertemuan RpsDetail
                    $startOnTime = Carbon::parse($current->tanggal_pertemuan);
                    if ($next) {
                        $endOnTime = Carbon::parse($next->tanggal_pertemuan)->subSecond();
                    } else {
                        $endOnTime = $startOnTime->copy()->addDays(7);
                    }
                    // Batasi endOnTime maksimal ke sekarang
                    if ($endOnTime->greaterThan($now)) {
                        $endOnTime = $now;
                    }

                    // Jendela late: mulai setelah endOnTime hingga +5 hari, batas ke sekarang
                    $startLate = $endOnTime->copy()->addSecond();
                    if ($startLate->greaterThan($now)) {
                        // jika belum masuk jendela late, skip sesi ini
                        continue;
                    }
                    $endLate = $startLate->copy()->addDays(5);
                    if ($endLate->greaterThan($now)) {
                        $endLate = $now;
                    }

                    // Ambil semua kuis untuk sesi RpsDetail ini
                    $kuisList = DB::table('kuisses')
                        ->where('rps_detail_id', $current->id)
                        ->pluck('id');

                    foreach ($kuisList as $kuisId) {
                        foreach ($mahasiswaIds as $userId) {
                            // 70% nilai tinggi, 30% rendah -> nilai multiples of 20
                            $highScore = $faker->boolean(70);
                            $nilaiOptions = $highScore ? [80, 100] : [20, 40, 60];
                            $nilai = $faker->randomElement($nilaiOptions);

                            // 80% on-time submission, 20% late
                            $onTime = $faker->boolean(80);
                            $completedAt = $onTime
                                ? $faker->dateTimeBetween($startOnTime, $endOnTime)
                                : $faker->dateTimeBetween($startLate, $endLate);

                            // Insert ke kuis_mahasiswa
                            $kmId = DB::table('kuis_mahasiswa')->insertGetId([
                                'user_id'    => $userId,
                                'kuis_id'    => $kuisId,
                                'nilai'      => $nilai,
                                'created_at' => $completedAt,
                                'updated_at' => $completedAt,
                            ]);

                            // Ambil semua pertanyaan untuk kuis ini
                            $questions = DB::table('kuis_questions')
                                ->where('kuis_id', $kuisId)
                                ->get();

                            // Hitung jawaban benar berdasarkan nilai
                            $correctCount = intval($nilai / 20);
                            $correctQIds = $questions->pluck('id')
                                ->random(min($correctCount, $questions->count()))
                                ->toArray();

                            foreach ($questions as $question) {
                                $options = DB::table('kuis_options')
                                    ->where('kuis_question_id', $question->id)
                                    ->get();

                                if (in_array($question->id, $correctQIds)) {
                                    $pickOpt = $options->firstWhere('is_correct', 1);
                                } else {
                                    $incorrects = $options->where('is_correct', 0)->values();
                                    $pickOpt = $incorrects->count()
                                        ? $incorrects->random()
                                        : null;
                                }

                                if ($pickOpt) {
                                    DB::table('kuis_mahasiswa_answers')->insert([
                                        'kuis_mahasiswa_id' => $kmId,
                                        'question_id'       => $question->id,
                                        'option_id'         => $pickOpt->id,
                                        'created_at'        => $completedAt,
                                        'updated_at'        => $completedAt,
                                    ]);
                                }
                            }
                        }
                    }
                }
            });
    }
}
