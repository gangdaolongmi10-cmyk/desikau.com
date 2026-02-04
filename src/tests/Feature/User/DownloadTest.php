<?php

namespace Tests\Feature\User;

use App\Models\Product;
use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * ダウンロード機能のFeatureテスト
 */
class DownloadTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->product = Product::factory()->create();

        // テスト用ファイルを作成
        Storage::disk('local')->put('private/products/' . $this->product->id . '/test-file.zip', 'dummy content');
        $this->product->update([
            'file_path' => 'private/products/' . $this->product->id . '/test-file.zip',
        ]);
    }

    protected function tearDown(): void
    {
        // テスト用ファイルを削除
        Storage::disk('local')->deleteDirectory('private/products');
        parent::tearDown();
    }

    /**
     * 購入済みユーザーがファイルをダウンロードできる
     */
    public function test_purchased_user_can_download_file(): void
    {
        // 購入履歴を作成
        PurchaseHistory::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get("/download/{$this->product->id}");

        $response->assertOk();
        $response->assertDownload('test-file.zip');
    }

    /**
     * 未購入ユーザーは403になる
     */
    public function test_unpurchased_user_gets_403(): void
    {
        $response = $this->actingAs($this->user)
            ->get("/download/{$this->product->id}");

        $response->assertForbidden();
    }

    /**
     * 未ログインユーザーはログインページにリダイレクトされる
     */
    public function test_unauthenticated_user_is_redirected(): void
    {
        $response = $this->get("/download/{$this->product->id}");

        $response->assertRedirect();
    }

    /**
     * ファイルが設定されていない商品で404になる
     */
    public function test_product_without_file_returns_404(): void
    {
        $productWithoutFile = Product::factory()->create([
            'file_path' => null,
        ]);

        // 購入履歴を作成
        PurchaseHistory::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $productWithoutFile->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get("/download/{$productWithoutFile->id}");

        $response->assertNotFound();
    }
}
