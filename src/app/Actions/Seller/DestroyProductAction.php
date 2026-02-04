<?php

namespace App\Actions\Seller;

use App\Models\Product;
use App\Services\FileUploadService;

/**
 * 商品削除アクション
 */
final class DestroyProductAction
{
    public function __construct(
        private readonly FileUploadService $fileUploadService
    ) {}

    /**
     * 商品を削除
     */
    public function execute(Product $product): void
    {
        $this->fileUploadService->deleteProductFile($product);
        $product->delete();
    }
}
