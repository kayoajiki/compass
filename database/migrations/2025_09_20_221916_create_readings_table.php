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
        Schema::create('readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('person_id')->nullable()->constrained('profiles')->onDelete('set null'); // 鑑定対象人物
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null'); // 鑑定商品
            $table->enum('status', ['pending_generation', 'generating', 'ready', 'failed'])->default('pending_generation');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->longText('json_result')->nullable();
            $table->text('notes')->nullable(); // 質問票の自由記述
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readings');
    }
};
