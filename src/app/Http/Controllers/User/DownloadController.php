<?php

namespace App\Http\Controllers\User;

use App\Actions\User\DownloadProductAction;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * 購入済み商品のダウンロードコントローラー
 */
final class DownloadController extends Controller
{
    /**
     * 購入済み商品のファイルをダウンロード
     */
    public function download(Product $product, DownloadProductAction $action): StreamedResponse
    {
        return $action->execute(Auth::user(), $product);
    }
}
