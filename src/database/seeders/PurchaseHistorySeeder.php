<?php

namespace Database\Seeders;

use App\Enums\TaxRate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * 購入履歴シーダー
 *
 * 各ユーザーにランダムな商品の購入履歴を作成し、
 * 購入された商品にダウンロード用ダミーファイルを配置する。
 */
class PurchaseHistorySeeder extends Seeder
{
    /**
     * ダミーファイルの拡張子マッピング
     */
    private const FORMAT_EXTENSIONS = [
        'PNG' => 'zip',
        'JPG' => 'zip',
        'PSD' => 'zip',
        'AI' => 'zip',
        'FBX' => 'zip',
        'OBJ' => 'zip',
        'BLEND' => 'zip',
        'MAX' => 'zip',
    ];

    /**
     * シーディングを実行
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        // まず全商品にダミーファイルを配置
        $this->createDummyFiles($products);

        // 各ユーザーに1〜4件の注文を作成
        foreach ($users as $user) {
            $orderCount = rand(1, 4);

            for ($i = 0; $i < $orderCount; $i++) {
                // 1注文あたり1〜3商品
                $itemCount = rand(1, min(3, $products->count()));
                $orderProducts = $products->random($itemCount);

                $this->createOrderWithHistory($user, $orderProducts);
            }
        }
    }

    /**
     * 注文と購入履歴を作成
     *
     * @param User $user
     * @param \Illuminate\Support\Collection<int, Product> $orderProducts
     */
    private function createOrderWithHistory(User $user, $orderProducts): void
    {
        $paidAt = fake()->dateTimeBetween('-3 months', 'now');

        // 小計計算
        $subtotal = $orderProducts->sum('price');
        $tax = TaxRate::default()->calculateTax($subtotal);
        $total = $subtotal + $tax;

        // 注文レコード作成
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => Order::generateOrderNumber() . '-' . fake()->unique()->randomNumber(4),
            'stripe_checkout_session_id' => 'cs_seed_' . fake()->unique()->uuid(),
            'stripe_payment_intent_id' => 'pi_seed_' . fake()->unique()->uuid(),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'status' => Order::STATUS_PAID,
            'paid_at' => $paidAt,
        ]);

        // 注文アイテムと購入履歴を作成
        foreach ($orderProducts as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ]);

            // 同一ユーザー+商品の重複を防止
            PurchaseHistory::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ],
                [
                    'price' => $product->price,
                    'status' => 1,
                    'purchased_at' => $paidAt,
                ],
            );
        }
    }

    /**
     * 全商品にダミーのダウンロードファイルを作成
     *
     * @param \Illuminate\Database\Eloquent\Collection<int, Product> $products
     */
    private function createDummyFiles($products): void
    {
        foreach ($products as $product) {
            $extension = self::FORMAT_EXTENSIONS[$product->file_format] ?? 'zip';
            $fileName = str_replace(' ', '_', $product->name) . '.' . $extension;
            $directory = 'private/products/' . $product->id;
            $filePath = $directory . '/' . $fileName;

            // ダミーファイルの中身を生成（商品情報テキスト）
            $content = $this->generateDummyContent($product);
            Storage::disk('local')->put($filePath, $content);

            // 商品のfile_pathを更新
            $product->update([
                'file_path' => $filePath,
                'file_size' => $this->formatFileSize(strlen($content)),
            ]);
        }
    }

    /**
     * ダミーファイルの中身を生成
     */
    private function generateDummyContent(Product $product): string
    {
        return implode("\n", [
            '==========================================',
            '  desikau - デジタルコンテンツ',
            '==========================================',
            '',
            '商品名: ' . $product->name,
            '商品ID: ' . $product->id,
            'ファイル形式: ' . ($product->file_format ?? '不明'),
            '',
            'これはシーダーで生成されたダミーファイルです。',
            '実際の商品ファイルはこのファイルの代わりに配置されます。',
            '',
            '生成日時: ' . now()->format('Y-m-d H:i:s'),
            '==========================================',
        ]);
    }

    /**
     * バイト数を読みやすい形式に変換
     */
    private function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $index = 0;
        $size = (float) $bytes;

        while ($size >= 1024 && $index < count($units) - 1) {
            $size /= 1024;
            $index++;
        }

        return round($size, 1) . $units[$index];
    }
}
