<?php

namespace App\Http\Requests\User;

use App\Rules\AlphanumericPassword;
use App\Rules\ProhibitedCharacters;
use Illuminate\Foundation\Http\FormRequest;

/**
 * ユーザー登録リクエストのバリデーション
 */
final class RegisterRequest extends FormRequest
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
            'username' => [
                'required',
                'string',
                'min:2',
                'max:50',
                new ProhibitedCharacters(),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
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
            'icon' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',
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
            'username.required' => 'ユーザー名を入力してください。',
            'username.string' => 'ユーザー名は文字列で入力してください。',
            'username.min' => 'ユーザー名は2文字以上で入力してください。',
            'username.max' => 'ユーザー名は50文字以内で入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.string' => 'メールアドレスは文字列で入力してください。',
            'email.email' => 'メールアドレスの形式で入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'email.unique' => 'このメールアドレスは既に登録されています。',
            'password.required' => 'パスワードを入力してください。',
            'password.string' => 'パスワードは文字列で入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは25文字以内で入力してください。',
            'icon.image' => 'プロフィール画像は画像ファイルを選択してください。',
            'icon.mimes' => 'プロフィール画像はJPEG、PNG、GIF、WebP形式で選択してください。',
            'icon.max' => 'プロフィール画像は2MB以内のファイルを選択してください。',
        ];
    }
}
