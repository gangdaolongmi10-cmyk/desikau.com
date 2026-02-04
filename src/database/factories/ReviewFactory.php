<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * レビューファクトリー
 *
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * モデルのデフォルト状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            '期待通りの品質でした',
            '素晴らしいコンテンツです',
            '初心者にもおすすめ',
            'プロ仕様で満足',
            'コスパ最高',
            '使いやすくて助かりました',
            '想像以上の出来栄え',
            'リピート確定です',
            'クオリティが高い',
            '買ってよかった',
            'デザインが素敵',
            '作業効率が上がりました',
            'おすすめできます',
            '期待以上でした',
            'まさに探していたもの',
        ];

        $bodies = [
            'このコンテンツを購入して本当に良かったです。クオリティが高く、すぐに使い始めることができました。サポートも丁寧で安心できます。',
            '仕事で使用していますが、とても満足しています。細部まで作り込まれており、プロフェッショナルな印象を与えることができます。',
            '初めての購入でしたが、分かりやすい説明があり、すぐに活用できました。初心者の方にもおすすめです。',
            '価格以上の価値があると思います。他の類似商品と比べても、このクオリティでこの価格は非常にお得です。',
            'デザインが洗練されていて、様々なプロジェクトで活用しています。汎用性が高いのも魅力です。',
            '購入から使用開始までスムーズでした。ダウンロードも早く、すぐに作業に取り掛かれました。',
            'チームメンバーにも好評で、共同作業がしやすくなりました。おかげで納期に余裕ができました。',
            '何度もリピートしています。新作が出るたびにチェックしています。今後も期待しています。',
            '細かいところまで配慮されていて、使い勝手が良いです。カスタマイズもしやすいです。',
            'ポートフォリオの質が格段に上がりました。クライアントからの評価も上々です。',
        ];

        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'title' => fake()->randomElement($titles),
            'body' => fake()->randomElement($bodies),
        ];
    }

    /**
     * 高評価（4-5）のレビュー
     */
    public function highRating(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(4, 5),
        ]);
    }

    /**
     * 低評価（1-2）のレビュー
     */
    public function lowRating(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(1, 2),
            'title' => fake()->randomElement([
                '期待外れでした',
                '改善の余地あり',
                'もう少し工夫が欲しい',
            ]),
            'body' => fake()->randomElement([
                '期待していた内容と少し違いました。説明をもう少し詳しくしてほしかったです。',
                '悪くはないですが、価格に見合った価値があるかは微妙です。改善を期待します。',
                '使い方が分かりにくく、サポートに問い合わせが必要でした。マニュアルの充実を希望します。',
            ]),
        ]);
    }
}
