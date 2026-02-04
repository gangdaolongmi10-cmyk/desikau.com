<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーション実行
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating')->comment('評価（1〜5）');
            $table->string('title')->comment('レビュータイトル');
            $table->text('body')->comment('レビュー本文');
            $table->timestamps();

            // 同一ユーザーが同一商品に複数レビューを投稿できないようにする
            $table->unique(['product_id', 'user_id']);

            // 商品ごとのレビュー取得用インデックス
            $table->index(['product_id', 'created_at']);
        });
    }

    /**
     * マイグレーションロールバック
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
