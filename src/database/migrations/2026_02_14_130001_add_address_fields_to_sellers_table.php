<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションを実行
     */
    public function up(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('postal_code', 8)->nullable()->after('twitch_username')->comment('郵便番号');
            $table->string('prefecture', 10)->nullable()->after('postal_code')->comment('都道府県');
            $table->string('city', 50)->nullable()->after('prefecture')->comment('市区町村');
            $table->string('address', 100)->nullable()->after('city')->comment('それ以降の住所');
            $table->string('building', 100)->nullable()->after('address')->comment('建物名・部屋番号');
            $table->string('phone_number', 15)->nullable()->after('building')->comment('電話番号');
        });
    }

    /**
     * マイグレーションをロールバック
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn([
                'postal_code',
                'prefecture',
                'city',
                'address',
                'building',
                'phone_number',
            ]);
        });
    }
};
