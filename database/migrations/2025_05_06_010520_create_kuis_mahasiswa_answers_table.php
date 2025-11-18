<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kuis_mahasiswa_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuis_mahasiswa_id')
                ->constrained('kuis_mahasiswa')
                ->onDelete('cascade');
            $table->foreignId('question_id')
                ->constrained('kuis_questions')
                ->onDelete('cascade');
            $table->foreignId('option_id')
                ->constrained('kuis_options')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuis_mahasiswa_answers');
    }
};
