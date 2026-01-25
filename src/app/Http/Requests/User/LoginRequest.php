<?php

namespace App\Http\Requests\User;

use App\Rules\AlphanumericPassword;
use App\Rules\ProhibitedCharacters;
use Illuminate\Foundation\Http\FormRequest;

/**
 * ログインリクエストのバリデーション
 */
final class LoginRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                new ProhibitedCharacters(),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:25',
                new AlphanumericPassword(),
                new ProhibitedCharacters(),
            ],
            'remember' => [
                'nullable',
                'boolean',
            ],
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
            'email.required' => 'メールアドレスを入力してください。',
            'email.string' => 'メールアドレスは文字列で入力してください。',
            'email.email' => 'メールアドレスの形式で入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'password.required' => 'パスワードを入力してください。',
            'password.string' => 'パスワードは文字列で入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは25文字以内で入力してください。',
        ];
    }

    /**
     * 認証に使用する認証情報を取得
     *
     * @return array<string, string>
     */
    public function credentials(): array
    {
        return $this->only(['email', 'password']);
    }

    /**
     * ログイン状態を保持するか
     */
    public function remember(): bool
    {
        return $this->boolean('remember');
    }
}
