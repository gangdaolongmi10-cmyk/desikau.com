<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * likesテーブル作成マイグレーション
 */
return new class extends Migration
{
    /**
     * マイグレーション実行
     */
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // 同じユーザーが同じ商品に複数回いいねできないようにする
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * ロールバック
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
