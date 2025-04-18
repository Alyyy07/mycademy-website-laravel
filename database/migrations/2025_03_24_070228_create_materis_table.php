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
        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rps_detail_id')->constrained('rps_details')->onDelete('cascade');
            $table->string('title');
            $table->enum('tipe_materi', ['pdf', 'video', 'teks']);
            $table->string('file_path')->nullable();
            $table->string('video_path')->nullable();
            $table->text('text_content')->nullable();
            $table->enum('status', ['draft', 'uploaded', 'verified', 'rejected'])->default('draft');
            $table->char('uploader_id', 36);
            $table->foreign('uploader_id')->references('id')->on('users')->onDelete('cascade');
            $table->char('verifier_id', 36)->nullable();
            $table->foreign('verifier_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
