<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KuisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quizId = DB::table('kuisses')->insertGetId([
            'rps_detail_id' => 1, // Ganti dengan ID rps_detail yang valid
            'title' => 'Kuis Pengenalan IoT',
            'description' => 'Kuis ini bertujuan untuk mengukur pemahaman dasar tentang Internet of Things (IoT)',
            'status' => 'verified',
            'uploader_id' => 'b4bbc461-be6c-4464-b529-aca0e8ab3719',
            'verifier_id' => 'd7d74b70-bfb2-463d-b8aa-e3ee8ce95b71',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data soal dan opsi
        $questions = [
            [
                'question' => '<p>Apa kepanjangan dari IoT?</p>',
                'options' => [
                    ['text' => '<p>Internet of Things</p>', 'correct' => true],
                    ['text' => '<p>Interface of Technology</p>', 'correct' => false],
                    ['text' => '<p>Input over Transmission</p>', 'correct' => false],
                    ['text' => '<p>Integrated Optical Transmitter</p>', 'correct' => false],
                ],
            ],
            [
                'question' => '<p>Perangkat manakah yang merupakan contoh IoT?</p>',
                'options' => [
                    ['text' => '<p>Smart TV</p>', 'correct' => true],
                    ['text' => '<p>Mesin Ketik</p>', 'correct' => false],
                    ['text' => '<p>Kipas Angin Manual</p>', 'correct' => false],
                    ['text' => '<p>Kalkulator</p>', 'correct' => false],
                ],
            ],
            [
                'question' => '<p>Komponen utama dalam sistem IoT adalah...</p>',
                'options' => [
                    ['text' => '<p>Sensor, jaringan, dan aktuator</p>', 'correct' => true],
                    ['text' => '<p>Harddisk, keyboard, dan monitor</p>', 'correct' => false],
                    ['text' => '<p>RAM, CPU, dan GPU</p>', 'correct' => false],
                    ['text' => '<p>CD-ROM, BIOS, dan casing</p>', 'correct' => false],
                ],
            ],
        ];

        // Simpan pertanyaan dan opsi
        foreach ($questions as $q) {
            $questionId = DB::table('kuis_questions')->insertGetId([
                'kuis_id' => $quizId,
                'question_text' => $q['question'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($q['options'] as $opt) {
                DB::table('kuis_options')->insert([
                    'kuis_question_id' => $questionId,
                    'option_text' => $opt['text'],
                    'is_correct' => $opt['correct'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
