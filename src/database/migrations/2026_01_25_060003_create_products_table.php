<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 商品テーブルのマイグレーション
 */
return new class extends Migration
{
    /**
     * マイグレーションを実行
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable()->constrained('sellers')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('price')->unsigned();
            $table->integer('original_price')->unsigned()->nullable();
            $table->string('image_url')->nullable();
            $table->string('file_format')->nullable();
            $table->string('file_size')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('likes_count')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('status');
            $table->index('likes_count');
            $table->index(['status', 'created_at']);
            $table->index(['status', 'category_id', 'created_at']);
        });
    }

    /**
     * マイグレーションをロールバック
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
