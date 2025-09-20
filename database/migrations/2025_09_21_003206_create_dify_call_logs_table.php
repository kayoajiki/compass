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
        Schema::create('dify_call_logs', function (Blueprint $table) {
            $table->id();
            $table->string('app_code');
            $table->boolean('success')->default(false);
            $table->integer('duration_ms')->nullable();
            $table->integer('http_status')->nullable();
            $table->text('request_data')->nullable();
            $table->text('response_data')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index(['app_code', 'success']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dify_call_logs');
    }
};
