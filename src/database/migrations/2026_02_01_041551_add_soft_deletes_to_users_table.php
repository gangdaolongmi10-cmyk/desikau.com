<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * usersテーブルに論理削除カラムを追加
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        // emailのユニーク制約を仮想カラムで管理
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['email']);

            // 仮想カラム: deleted_atがnullの時だけemailを保持
            $table->string('active_email')
                ->virtualAs('case when deleted_at is null then email else null end')
                ->nullable();

            // 仮想カラムにユニーク制約
            $table->unique('active_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['active_email']);
            $table->dropColumn('active_email');
            $table->unique('email');
            $table->dropSoftDeletes();
        });
    }
};
