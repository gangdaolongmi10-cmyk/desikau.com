<?php

namespace Tests\Feature\User;

use App\Enums\InquiryStatus;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * お問い合わせ機能のFeatureテスト
 */
class InquiryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * お問い合わせフォームが表示される
     */
    public function test_inquiry_form_is_displayed(): void
    {
        $response = $this->get('/inquiry');

        $response->assertOk();
        $response->assertViewIs('user.inquiry.index');
    }

    /**
     * ログインユーザーがお問い合わせを送信できる
     */
    public function test_authenticated_user_can_submit_inquiry(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/inquiry', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'message' => 'これはテストメッセージです。',
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'お問い合わせを受け付けました。',
        ]);

        $this->assertDatabaseHas('inquiries', [
            'user_id' => $user->id,
            'guest_token' => null,
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'message' => 'これはテストメッセージです。',
            'status' => InquiryStatus::UNREAD->value,
        ]);
    }

    /**
     * ゲストユーザーがお問い合わせを送信できる
     */
    public function test_guest_user_can_submit_inquiry(): void
    {
        $response = $this->postJson('/inquiry', [
            'name' => 'ゲスト花子',
            'email' => 'guest@example.com',
            'message' => 'ゲストからのお問い合わせです。',
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
        ]);

        $inquiry = Inquiry::first();
        $this->assertNull($inquiry->user_id);
        $this->assertNotNull($inquiry->guest_token);
        $this->assertEquals(36, strlen($inquiry->guest_token)); // UUID形式
        $this->assertEquals('ゲスト花子', $inquiry->name);
        $this->assertEquals('guest@example.com', $inquiry->email);
        $this->assertEquals(InquiryStatus::UNREAD, $inquiry->status);
    }

    /**
     * 名前が必須
     */
    public function test_name_is_required(): void
    {
        $response = $this->postJson('/inquiry', [
            'name' => '',
            'email' => 'test@example.com',
            'message' => 'テストメッセージ',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * メールアドレスが必須
     */
    public function test_email_is_required(): void
    {
        $response = $this->postJson('/inquiry', [
            'name' => 'テスト太郎',
            'email' => '',
            'message' => 'テストメッセージ',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * メールアドレスが有効な形式である必要がある
     */
    public function test_email_must_be_valid(): void
    {
        $response = $this->postJson('/inquiry', [
            'name' => 'テスト太郎',
            'email' => 'invalid-email',
            'message' => 'テストメッセージ',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * メッセージが必須
     */
    public function test_message_is_required(): void
    {
        $response = $this->postJson('/inquiry', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'message' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['message']);
    }

    /**
     * 名前は100文字以内
     */
    public function test_name_max_length(): void
    {
        $response = $this->postJson('/inquiry', [
            'name' => str_repeat('あ', 101),
            'email' => 'test@example.com',
            'message' => 'テストメッセージ',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * メッセージは5000文字以内
     */
    public function test_message_max_length(): void
    {
        $response = $this->postJson('/inquiry', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'message' => str_repeat('あ', 5001),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['message']);
    }
}
