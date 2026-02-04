<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 出品者登録リクエスト
 */
class SellerRegisterRequest extends FormRequest
{
    /**
     * リクエストの認可
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255', 'unique:sellers,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'shop_name' => ['required', 'string', 'max:255'],
            'main_category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'twitter_username' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'twitch_username' => ['nullable', 'string', 'max:255'],
            'agree_terms' => ['required', 'accepted'],
        ];
    }

    /**
     * バリデーションメッセージ
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスは既に登録されています。',
            'password.required' => 'パスワードは必須です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワードが一致しません。',
            'shop_name.required' => 'ショップ名は必須です。',
            'main_category.required' => '主な販売カテゴリーを選択してください。',
            'youtube_url.url' => '有効なURLを入力してください。',
            'agree_terms.required' => '利用規約への同意が必要です。',
            'agree_terms.accepted' => '利用規約への同意が必要です。',
        ];
    }
}
