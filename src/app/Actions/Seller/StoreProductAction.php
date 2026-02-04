<?php

namespace App\Actions\Seller;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\Seller;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * 商品登録アクション
 */
final class StoreProductAction
{
    public function __construct(
        private readonly FileUploadService $fileUploadService
    ) {}

    /**
     * 商品を登録
     */
    public function execute(Seller $seller, array $validated, ?UploadedFile $file = null): Product
    {
        $product = new Product();
        $product->seller_id = $seller->id;
        $product->name = $validated['name'];
        $product->slug = $this->generateUniqueSlug($validated['name']);
        $product->category_id = $validated['category_id'];
        $product->description = $validated['description'] ?? null;
        $product->price = $validated['price'];
        $product->original_price = $validated['original_price'] ?? null;
        $product->image_url = $validated['image_url'] ?? null;
        $product->file_format = $validated['file_format'] ?? null;
        $product->file_size = $validated['file_size'] ?? null;
        $product->status = ProductStatus::from($validated['status']);
        $product->save();

        // ファイルアップロード（商品ID確定後に実行）
        if ($file) {
            $path = $this->fileUploadService->uploadProductFile($file, $product);
            $product->file_path = $path;
            if (empty($product->file_size)) {
                $product->file_size = $this->formatFileSize($file->getSize());
            }
            $product->save();
        }

        return $product;
    }

    /**
     * ユニークなスラッグを生成
     */
    private function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);

        // 日本語など非ASCII文字の場合はランダム文字列を使用
        if (empty($baseSlug)) {
            $baseSlug = Str::random(10);
        }

        $slug = $baseSlug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * バイト数を読みやすいファイルサイズ文字列に変換
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
