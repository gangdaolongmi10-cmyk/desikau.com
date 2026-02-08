<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 特定商取引法に基づく表記テーブルを作成
 */
return new class extends Migration
{
    /**
     * マイグレーションを実行
     */
    public function up(): void
    {
        Schema::create('seller_legal_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->unique()->constrained('sellers')->cascadeOnDelete();
            $table->string('company_name')->comment('販売業者名');
            $table->string('representative_name')->comment('代表者名');
            $table->string('postal_code', 10)->comment('郵便番号');
            $table->string('address')->comment('所在地');
            $table->string('phone_number', 20)->comment('電話番号');
            $table->string('email')->comment('メールアドレス');
            $table->text('price_description')->comment('販売価格について');
            $table->text('payment_method')->comment('支払方法');
            $table->text('delivery_period')->comment('引渡し時期');
            $table->text('return_policy')->comment('返品・キャンセルについて');
            $table->timestamps();
        });
    }

    /**
     * マイグレーションをロールバック
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_legal_infos');
    }
};
