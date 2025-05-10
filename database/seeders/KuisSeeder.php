<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KuisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosenIotId = User::where('name', 'like', 'Arda Gusema%')->first()->id;
        $dosenAndroidId = User::where('name', 'like', 'Iddrus%')->first()->id;

        $kuisIoT = require_once database_path('seeders/data/kuis_iot.php');
        $kuisAndroid = require_once database_path('seeders/data/kuis_android.php');

        foreach ($kuisIoT as $rpsDetailId => $quizData) {
            $quizId = DB::table('kuisses')->insertGetId([
                'rps_detail_id' => $rpsDetailId,
                'title' => $quizData['title'],
                'description' => $quizData['description'],
                'status' => 'verified',
                'uploader_id' => $dosenIotId,
                'verifier_id' => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($quizData['questions'] as $q) {
                list($text, $opts) = $q;
                $questionId = DB::table('kuis_questions')->insertGetId([
                    'kuis_id' => $quizId,
                    'question_text' => "<p>{$text}</p>",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($opts as $optText => $isCorrect) {
                    DB::table('kuis_options')->insert([
                        'kuis_question_id' => $questionId,
                        'option_text' => "<p>{$optText}</p>",
                        'is_correct' => $isCorrect,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        } 

        foreach ($kuisAndroid as $rpsDetailId => $quizData) {
            $quizId = DB::table('kuisses')->insertGetId([
                'rps_detail_id' => $rpsDetailId,
                'title' => $quizData['title'],
                'description' => $quizData['description'],
                'status' => 'verified',
                'uploader_id' => $dosenAndroidId,
                'verifier_id' => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($quizData['questions'] as $q) {
                list($text, $opts) = $q;
                $questionId = DB::table('kuis_questions')->insertGetId([
                    'kuis_id' => $quizId,
                    'question_text' => "<p>{$text}</p>",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($opts as $optText => $isCorrect) {
                    DB::table('kuis_options')->insert([
                        'kuis_question_id' => $questionId,
                        'option_text' => "<p>{$optText}</p>",
                        'is_correct' => $isCorrect,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
