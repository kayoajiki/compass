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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 核データ（変更不可）
            $table->string('name')->comment('氏名（変更不可）');
            $table->date('birth_date')->comment('生年月日（変更不可）');
            $table->time('birth_time')->nullable()->comment('出生時刻');
            $table->string('birth_place')->comment('出生地（都道府県）');
            $table->decimal('longitude', 10, 7)->nullable()->comment('経度（補正用）');
            $table->decimal('latitude', 10, 7)->nullable()->comment('緯度（補正用）');
            $table->boolean('longitude_corrected')->default(false)->comment('経度補正済みフラグ');
            
            // メタデータ
            $table->boolean('is_completed')->default(false)->comment('プロフィール完成フラグ');
            $table->timestamp('completed_at')->nullable()->comment('完成日時');
            
            $table->timestamps();
            
            // インデックス
            $table->index(['user_id', 'is_completed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
