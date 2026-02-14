<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

/**
 * 出品者設定リクエスト
 */
class SellerSettingsRequest extends FormRequest
{
    /**
     * リクエストの認可を判定
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルールを取得
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'shop_name' => ['required', 'string', 'max:255'],
            'main_category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'twitter_username' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'twitch_username' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:8', 'regex:/^\d{3}-?\d{4}$/'],
            'prefecture' => ['nullable', 'string', 'max:10'],
            'city' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:100'],
            'building' => ['nullable', 'string', 'max:100'],
            'phone_number' => ['nullable', 'string', 'max:15', 'regex:/^[0-9\-\(\)]+$/'],
            'current_password' => ['required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * バリデーション後の追加チェック
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->filled('current_password') && $this->filled('password')) {
                    $seller = Auth::guard('seller')->user();
                    if (!Hash::check($this->input('current_password'), $seller->password)) {
                        $validator->errors()->add('current_password', '現在のパスワードが正しくありません。');
                    }
                }
            },
        ];
    }

    /**
     * バリデーション属性名を取得
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'shop_name' => 'ショップ名',
            'main_category' => '主な販売カテゴリー',
            'description' => 'ショップの紹介文',
            'twitter_username' => 'X (Twitter) ユーザー名',
            'youtube_url' => 'YouTube チャンネルURL',
            'twitch_username' => 'Twitch ユーザー名',
            'postal_code' => '郵便番号',
            'prefecture' => '都道府県',
            'city' => '市区町村',
            'address' => '住所',
            'building' => '建物名・部屋番号',
            'phone_number' => '電話番号',
            'current_password' => '現在のパスワード',
            'password' => '新しいパスワード',
        ];
    }

    /**
     * バリデーションエラーメッセージを取得
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'shop_name.required' => 'ショップ名を入力してください。',
            'shop_name.max' => 'ショップ名は255文字以内で入力してください。',
            'main_category.required' => '主な販売カテゴリーを選択してください。',
            'description.max' => 'ショップの紹介文は1000文字以内で入力してください。',
            'twitter_username.max' => 'X (Twitter) ユーザー名は255文字以内で入力してください。',
            'youtube_url.url' => '有効なURLを入力してください。',
            'youtube_url.max' => 'YouTube チャンネルURLは255文字以内で入力してください。',
            'twitch_username.max' => 'Twitch ユーザー名は255文字以内で入力してください。',
            'postal_code.regex' => '郵便番号は7桁の数字で入力してください（例: 123-4567）。',
            'postal_code.max' => '郵便番号は8文字以内で入力してください。',
            'prefecture.max' => '都道府県は10文字以内で入力してください。',
            'city.max' => '市区町村は50文字以内で入力してください。',
            'address.max' => '住所は100文字以内で入力してください。',
            'building.max' => '建物名・部屋番号は100文字以内で入力してください。',
            'phone_number.regex' => '電話番号は数字とハイフンのみで入力してください。',
            'phone_number.max' => '電話番号は15文字以内で入力してください。',
            'current_password.required_with' => 'パスワードを変更する場合は現在のパスワードを入力してください。',
            'password.min' => '新しいパスワードは8文字以上で入力してください。',
            'password.confirmed' => '新しいパスワード（確認）が一致しません。',
        ];
    }
}
