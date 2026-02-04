<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 出品者テーブルのマイグレーション
 */
return new class extends Migration
{
    /**
     * マイグレーションを実行
     */
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('shop_name');
            $table->string('slug')->unique();
            $table->string('main_category');
            $table->text('description')->nullable();
            $table->string('twitter_username')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('twitch_username')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('email');
        });
    }

    /**
     * マイグレーションをロールバック
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
