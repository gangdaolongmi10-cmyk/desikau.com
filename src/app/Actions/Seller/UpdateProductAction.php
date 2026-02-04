<?php

namespace App\Actions\Seller;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;

/**
 * 商品更新アクション
 */
final class UpdateProductAction
{
    public function __construct(
        private readonly FileUploadService $fileUploadService
    ) {}

    /**
     * 商品を更新
     */
    public function execute(Product $product, array $validated, ?UploadedFile $file = null): Product
    {
        $product->name = $validated['name'];
        $product->category_id = $validated['category_id'];
        $product->description = $validated['description'] ?? null;
        $product->price = $validated['price'];
        $product->original_price = $validated['original_price'] ?? null;
        $product->image_url = $validated['image_url'] ?? null;
        $product->file_format = $validated['file_format'] ?? null;
        $product->file_size = $validated['file_size'] ?? null;
        $product->status = ProductStatus::from($validated['status']);

        // ファイル差し替え
        if ($file) {
            $this->fileUploadService->deleteProductFile($product);
            $path = $this->fileUploadService->uploadProductFile($file, $product);
            $product->file_path = $path;
            if (empty($validated['file_size'])) {
                $product->file_size = $this->formatFileSize($file->getSize());
            }
        }

        $product->save();

        return $product;
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
