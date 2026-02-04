<?php

namespace Database\Seeders;

use App\Enums\AnnouncementStatus;
use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use Illuminate\Database\Seeder;

/**
 * お知らせシーダー
 */
class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // カテゴリを作成
        $important = AnnouncementCategory::factory()->important()->create();
        $maintenance = AnnouncementCategory::factory()->maintenance()->create();
        $update = AnnouncementCategory::factory()->update()->create();
        $campaign = AnnouncementCategory::factory()->campaign()->create();

        // ダミーデータを作成
        Announcement::factory()->create([
            'title' => '【重要】利用規約改定のお知らせ',
            'content' => "いつもDesikauをご利用いただきありがとうございます。\n\n2026年3月1日より、利用規約を改定いたします。\n\n主な変更点：\n- プライバシーポリシーの更新\n- 禁止事項の明確化\n- 返金ポリシーの改定\n\n詳細は利用規約ページをご確認ください。\n\n今後ともDesikauをよろしくお願いいたします。",
            'status' => AnnouncementStatus::PUBLISHED,
            'category_id' => $important->id,
            'published_at' => now()->subDays(2),
            'closed_at' => null,
        ]);

        Announcement::factory()->create([
            'title' => '【メンテナンス】2月5日 定期メンテナンスのお知らせ',
            'content' => "下記の日程でシステムメンテナンスを実施いたします。\n\n■メンテナンス日時\n2026年2月5日（木）02:00 〜 06:00（予定）\n\n■影響範囲\n- サイト全体がご利用いただけません\n- 決済処理が一時停止します\n\nご不便をおかけしますが、ご理解のほどよろしくお願いいたします。",
            'status' => AnnouncementStatus::PUBLISHED,
            'category_id' => $maintenance->id,
            'published_at' => now()->subDays(5),
            'closed_at' => now()->addDays(5),
        ]);

        Announcement::factory()->create([
            'title' => '新機能「お気に入りフォルダ」をリリースしました',
            'content' => "いつもDesikauをご利用いただきありがとうございます。\n\n本日、新機能「お気に入りフォルダ」をリリースしました！\n\n■新機能の概要\n- お気に入りに追加した商品をフォルダで整理できます\n- フォルダは最大20個まで作成可能\n- フォルダごとに公開/非公開を設定できます\n\nぜひご活用ください！",
            'status' => AnnouncementStatus::PUBLISHED,
            'category_id' => $update->id,
            'published_at' => now()->subWeek(),
            'closed_at' => null,
        ]);

        Announcement::factory()->create([
            'title' => '【期間限定】春の新生活キャンペーン開催中！',
            'content' => "新生活を応援！対象商品が最大30%OFF！\n\n■キャンペーン期間\n2026年2月1日 〜 3月31日\n\n■対象商品\n- UIキット全商品\n- アイコンパック\n- フォント\n\n■特典\n- 対象商品が20%〜30%OFF\n- まとめ買いでさらにお得\n\nこの機会をお見逃しなく！",
            'status' => AnnouncementStatus::PUBLISHED,
            'category_id' => $campaign->id,
            'published_at' => now()->subDays(1),
            'closed_at' => now()->addMonths(2),
        ]);

        Announcement::factory()->create([
            'title' => 'アプリバージョン2.5.0をリリースしました',
            'content' => "アプリのアップデートを行いました。\n\n■主な変更点\n- パフォーマンスの改善\n- 検索機能の強化\n- いくつかのバグ修正\n\nApp StoreおよびGoogle Playからアップデートしてください。",
            'status' => AnnouncementStatus::PUBLISHED,
            'category_id' => $update->id,
            'published_at' => now()->subWeeks(2),
            'closed_at' => null,
        ]);

        Announcement::factory()->create([
            'title' => '年末年始の営業について',
            'content' => "年末年始の営業についてお知らせいたします。\n\n■休業期間\n2025年12月29日（日）〜 2026年1月3日（金）\n\n■お問い合わせ対応\n休業期間中のお問い合わせは、1月6日（月）以降順次対応いたします。\n\n今後ともDesikauをよろしくお願いいたします。",
            'status' => AnnouncementStatus::ARCHIVED,
            'category_id' => $important->id,
            'published_at' => now()->subMonths(2),
            'closed_at' => now()->subMonth(),
        ]);
    }
}
