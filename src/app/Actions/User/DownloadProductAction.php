<?php

namespace App\Actions\User;

use App\Models\Product;
use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * 購入済み商品ダウンロードアクション
 */
final class DownloadProductAction
{
    /**
     * 購入済み商品のファイルをダウンロード
     *
     * ファイル未設定時は404、未購入時は403をスロー
     */
    public function execute(User $user, Product $product): StreamedResponse
    {
        if (!$product->hasFile()) {
            abort(404, 'ダウンロード可能なファイルがありません。');
        }

        $purchased = PurchaseHistory::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->exists();

        if (!$purchased) {
            abort(403, 'この商品を購入していないためダウンロードできません。');
        }

        return Storage::disk('local')->download(
            $product->file_path,
            basename($product->file_path),
        );
    }
}
