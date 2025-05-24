<?php

namespace Database\Seeders;

use App\Models\Materi;
use App\Models\RpsDetail;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriSelesaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $now   = Carbon::now();

        $mahasiswaIds = User::whereHas('mahasiswa', function ($q) {
            $q->where('semester', 8);
        })->pluck('id');

        RpsDetail::with('rpsMatakuliah')
            ->where('tanggal_pertemuan', '<', $now)
            ->orderBy('rps_matakuliah_id')
            ->orderBy('sesi_pertemuan')
            ->get()
            ->groupBy('rps_matakuliah_id')
            ->each(function ($detailsGroup) use ($mahasiswaIds, $faker, $now) {
                $details = $detailsGroup->values();
                $count   = $details->count();

                for ($i = 0; $i < $count; $i++) {
                    $current = $details[$i];
                    $next    = $details->get($i + 1);

                    $startOnTime = Carbon::parse($current->tanggal_pertemuan);
                    if ($next) {
                        $endOnTime = Carbon::parse($next->tanggal_pertemuan)->subSecond();
                    } else {
                        $endOnTime = $startOnTime->copy()->addDays(7);
                    }
                    // if ($endOnTime->greaterThan($now)) {
                    //     $endOnTime = $now;
                    // }

                    $startLate = $endOnTime->copy()->addSecond();
                    $endLate   = $startLate->copy()->addDays(5);
                    // if ($startLate->greaterThan($now)) {
                    //     continue;
                    // }
                    // if ($endLate->greaterThan($now)) {
                    //     $endLate = $now;
                    // }

                    Materi::where('rps_detail_id', $current->id)
                        ->get()
                        ->each(function ($materi) use (
                            $mahasiswaIds,
                            $faker,
                            $startOnTime,
                            $endOnTime,
                            $startLate,
                            $endLate
                        ) {
                            foreach ($mahasiswaIds as $userId) {
                                $onTime        = $faker->boolean(80);
                                $isUnderstand  = $faker->boolean(70);

                                $completedAt = $onTime
                                    ? $faker->dateTimeBetween($startOnTime, $endOnTime)
                                    : $faker->dateTimeBetween($startLate, $endLate);

                                DB::table('materi_mahasiswa')->insert([
                                    'user_id'         => $userId,
                                    'materi_id'       => $materi->id,
                                    'skala_pemahaman' => (string) ($isUnderstand ? 4 : $faker->numberBetween(1, 3)),
                                    'created_at'      => $completedAt,
                                    'updated_at'      => $completedAt,
                                ]);
                            }
                        });
                }
            });
    }
}
