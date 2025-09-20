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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->enum('type', ['physical', 'digital', 'service']);
            $table->integer('price_cents');
            $table->string('currency', 3)->default('JPY');
            $table->integer('stock')->nullable(); // null = unlimited
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable(); // 五行タグなど
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
