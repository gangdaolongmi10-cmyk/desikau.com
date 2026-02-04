<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * レビュー投稿リクエスト
 */
class ReviewRequest extends FormRequest
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
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['required', 'string', 'max:100'],
            'body' => ['required', 'string', 'max:2000'],
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
            'rating' => '評価',
            'title' => 'タイトル',
            'body' => 'レビュー内容',
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
            'rating.required' => '評価を選択してください。',
            'rating.min' => '評価は1〜5の間で選択してください。',
            'rating.max' => '評価は1〜5の間で選択してください。',
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは100文字以内で入力してください。',
            'body.required' => 'レビュー内容を入力してください。',
            'body.max' => 'レビュー内容は2000文字以内で入力してください。',
        ];
    }
}
