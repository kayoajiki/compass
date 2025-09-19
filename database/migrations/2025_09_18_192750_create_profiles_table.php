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
            $table->time('birth_time')->nullable()->comment('出生時刻（00:00-23:00）');
            $table->string('birth_place_pref', 2)->comment('出生地都道府県コード（01-47）');
            $table->boolean('longitude_adjust')->default(false)->comment('経度補正フラグ');
            
            // メタデータ
            $table->boolean('is_completed')->default(false)->comment('プロフィール完成フラグ');
            $table->timestamp('completed_at')->nullable()->comment('完成日時');
            
            $table->timestamps();
            
            // インデックス
            $table->index(['user_id', 'is_completed']);
            $table->index('birth_place_pref');
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
