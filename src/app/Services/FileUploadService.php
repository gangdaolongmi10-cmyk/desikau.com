<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * 商品ファイルのアップロード・削除を管理するサービス
 */
class FileUploadService
{
    /**
     * 保存先ディレクトリのプレフィックス
     */
    private const STORAGE_DIR = 'private/products';

    /**
     * 商品ファイルをアップロードして保存パスを返す
     */
    public function uploadProductFile(UploadedFile $file, Product $product): string
    {
        $directory = self::STORAGE_DIR . '/' . $product->id;
        $fileName = $file->getClientOriginalName();

        // 同名ファイルが既に存在する場合は上書き
        $path = $file->storeAs($directory, $fileName, 'local');

        return $path;
    }

    /**
     * 商品に紐づく既存ファイルを削除
     */
    public function deleteProductFile(Product $product): void
    {
        if ($product->file_path === null) {
            return;
        }

        Storage::disk('local')->delete($product->file_path);
    }
}
