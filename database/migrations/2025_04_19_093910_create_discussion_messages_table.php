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
        Schema::create('discussion_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materi_id')->constrained('materis')->onDelete('cascade');
            $table->char('sender_id', 36);
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('message');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_messages');
    }
};
