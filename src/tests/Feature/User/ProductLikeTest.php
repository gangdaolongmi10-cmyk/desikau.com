<?php

namespace Tests\Feature\User;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * 商品いいね機能のFeatureテスト
 */
class ProductLikeTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->product = Product::factory()->create(['likes_count' => 0]);
    }

    /**
     * 認証済みユーザーが商品にいいねできる
     */
    public function test_authenticated_user_can_like_product(): void
    {
        $response = $this->actingAs($this->user)
            ->post("/products/{$this->product->id}/likes");

        $response->assertNoContent();

        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $this->product->refresh();
        $this->assertEquals(1, $this->product->likes_count);
    }

    /**
     * 認証済みユーザーがいいねを解除できる
     */
    public function test_authenticated_user_can_unlike_product(): void
    {
        // 先にいいねを追加
        $this->product->likedUsers()->attach($this->user->id);
        $this->product->increment('likes_count');

        $response = $this->actingAs($this->user)
            ->delete("/products/{$this->product->id}/likes");

        $response->assertNoContent();

        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $this->product->refresh();
        $this->assertEquals(0, $this->product->likes_count);
    }

    /**
     * 未認証ユーザーはいいねできない（401または302リダイレクト）
     */
    public function test_unauthenticated_user_cannot_like_product(): void
    {
        $response = $this->postJson("/products/{$this->product->id}/likes");

        $response->assertUnauthorized();

        $this->assertDatabaseMissing('likes', [
            'product_id' => $this->product->id,
        ]);
    }

    /**
     * 未認証ユーザーはいいね解除できない（401または302リダイレクト）
     */
    public function test_unauthenticated_user_cannot_unlike_product(): void
    {
        $response = $this->deleteJson("/products/{$this->product->id}/likes");

        $response->assertUnauthorized();
    }

    /**
     * 同じ商品に二重いいねしてもカウントは増えない
     */
    public function test_double_like_does_not_increment_count(): void
    {
        // 1回目のいいね
        $this->actingAs($this->user)
            ->post("/products/{$this->product->id}/likes");

        // 2回目のいいね
        $response = $this->actingAs($this->user)
            ->post("/products/{$this->product->id}/likes");

        $response->assertNoContent();

        // カウントは1のまま
        $this->product->refresh();
        $this->assertEquals(1, $this->product->likes_count);

        // レコードも1件のみ
        $this->assertEquals(1, $this->product->likedUsers()->count());
    }

    /**
     * いいねしていない商品を解除してもエラーにならない
     */
    public function test_unlike_without_like_does_not_cause_error(): void
    {
        $response = $this->actingAs($this->user)
            ->delete("/products/{$this->product->id}/likes");

        $response->assertNoContent();

        // カウントは0のまま
        $this->product->refresh();
        $this->assertEquals(0, $this->product->likes_count);
    }

    /**
     * 存在しない商品へのいいねは404
     */
    public function test_like_nonexistent_product_returns_404(): void
    {
        $response = $this->actingAs($this->user)
            ->post('/products/99999/likes');

        $response->assertNotFound();
    }

    /**
     * 複数ユーザーが同じ商品にいいねできる
     */
    public function test_multiple_users_can_like_same_product(): void
    {
        $user2 = User::factory()->create();

        $this->actingAs($this->user)
            ->post("/products/{$this->product->id}/likes");

        $this->actingAs($user2)
            ->post("/products/{$this->product->id}/likes");

        $this->product->refresh();
        $this->assertEquals(2, $this->product->likes_count);
        $this->assertEquals(2, $this->product->likedUsers()->count());
    }
}
