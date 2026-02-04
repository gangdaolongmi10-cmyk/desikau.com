<?php

namespace App\Http\Requests\User;

use App\Rules\AlphanumericPassword;
use App\Rules\ProhibitedCharacters;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * パスワード変更リクエストのバリデーション
 */
final class ChangePasswordRequest extends FormRequest
{
    /**
     * リクエストの認可
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * バリデーションルール
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                'current_password:web',
            ],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'max:25',
                new AlphanumericPassword(),
                new ProhibitedCharacters(),
                'different:current_password',
                'confirmed',
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
            'current_password.required' => '現在のパスワードを入力してください。',
            'current_password.string' => '現在のパスワードは文字列で入力してください。',
            'current_password.current_password' => '現在のパスワードが正しくありません。',
            'new_password.required' => '新しいパスワードを入力してください。',
            'new_password.string' => '新しいパスワードは文字列で入力してください。',
            'new_password.min' => '新しいパスワードは8文字以上で入力してください。',
            'new_password.max' => '新しいパスワードは25文字以内で入力してください。',
            'new_password.different' => '新しいパスワードは現在のパスワードと異なるものを入力してください。',
            'new_password.confirmed' => '新しいパスワード（確認）が一致しません。',
        ];
    }
}
