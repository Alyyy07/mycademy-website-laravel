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
        Schema::create('rps_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rps_matakuliah_id')->constrained('rps_matakuliahs')->cascadeOnDelete();
            $table->integer('sesi_pertemuan');
            $table->date('tanggal_pertemuan');
            $table->text('capaian_pembelajaran')->nullable();
            $table->text('indikator')->nullable();
            $table->text('metode_pembelajaran')->nullable();
            $table->text('kriteria_penilaian')->nullable();
            $table->text('materi_pembelajaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rps_details');
    }
};
