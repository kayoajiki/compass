<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_feature_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('theme');
            $table->json('tags');
            $table->json('sources');
            $table->float('score');
            $table->timestamp('refreshed_at');
            $table->timestamps();
            
            $table->unique(['user_id', 'theme']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_feature_tags');
    }
};
