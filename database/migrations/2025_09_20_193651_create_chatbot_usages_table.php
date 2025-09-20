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
        Schema::create('chatbot_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('bot_key', ['mood', 'tarot', 'strength']);
            $table->date('date');
            $table->integer('count')->default(0);
            $table->timestamps();
            
            // 1日1回無料のカウント判定に使用するユニーク制約
            $table->unique(['user_id', 'bot_key', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_usages');
    }
};
