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
            $table->foreignId('mapping_matakuliah_id')->constrained('mapping_matakuliahs')->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['file', 'video','teks']);
            $table->string('file_path')->nullable();
            $table->string('video_path')->nullable();
            $table->text('text_content')->nullable();
            $table->enum('status', ['draft','uploaded','verified','rejected'])->default('draft');
            $table->foreignUlid('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('verified_by')->constrained('users')->onDelete('cascade');
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
