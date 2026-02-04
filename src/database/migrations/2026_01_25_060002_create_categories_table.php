<?php

use App\Enums\IsActive;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * カテゴリーテーブルのマイグレーション
 */
return new class extends Migration
{
    /**
     * マイグレーションを実行
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('カテゴリー名');
            $table->string('slug')->comment('URL');
            $table->unsignedTinyInteger('sort_no')->comment('並び順');
            $table->boolean('is_active')->comment('有効/無効')->default(IsActive::Active);
            $table->timestamps();

            $table->index('slug');
            $table->index(['is_active', 'sort_no']);
        });
    }

    /**
     * マイグレーションをロールバック
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
