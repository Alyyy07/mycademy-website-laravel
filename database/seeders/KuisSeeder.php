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
            'status' => 'draft',
            'uploader_id' => 'b4bbc461-be6c-4464-b529-aca0e8ab3719', // Ganti dengan UUID user yang valid
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data soal dan opsi
        $questions = [
            [
                'question' => 'Apa kepanjangan dari IoT?',
                'options' => [
                    ['text' => 'Internet of Things', 'correct' => true],
                    ['text' => 'Interface of Technology', 'correct' => false],
                    ['text' => 'Input over Transmission', 'correct' => false],
                    ['text' => 'Integrated Optical Transmitter', 'correct' => false],
                ],
            ],
            [
                'question' => 'Perangkat manakah yang merupakan contoh IoT?',
                'options' => [
                    ['text' => 'Smart TV', 'correct' => true],
                    ['text' => 'Mesin Ketik', 'correct' => false],
                    ['text' => 'Kipas Angin Manual', 'correct' => false],
                    ['text' => 'Kalkulator', 'correct' => false],
                ],
            ],
            [
                'question' => 'Komponen utama dalam sistem IoT adalah...',
                'options' => [
                    ['text' => 'Sensor, jaringan, dan aktuator', 'correct' => true],
                    ['text' => 'Harddisk, keyboard, dan monitor', 'correct' => false],
                    ['text' => 'RAM, CPU, dan GPU', 'correct' => false],
                    ['text' => 'CD-ROM, BIOS, dan casing', 'correct' => false],
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
