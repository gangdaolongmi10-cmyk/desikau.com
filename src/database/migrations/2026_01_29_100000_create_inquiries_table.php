<?php

use App\Enums\InquiryStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * お問い合わせテーブルのマイグレーション
 */
return new class extends Migration
{
    /**
     * マイグレーション実行
     */
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('guest_token', 36)->nullable()->index();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->tinyInteger('status')->default(InquiryStatus::UNREAD->value);
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    /**
     * マイグレーションのロールバック
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
