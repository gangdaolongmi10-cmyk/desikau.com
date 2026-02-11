<?php

namespace App\Http\Requests\Admin;

use App\Enums\AnnouncementStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * お知らせリクエスト
 */
class AnnouncementRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:10000'],
            'status' => ['required', Rule::in(AnnouncementStatus::values())],
            'category_id' => ['nullable', 'exists:announcement_categories,id'],
            'published_at' => ['required', 'date'],
            'closed_at' => ['nullable', 'date', 'after:published_at'],
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
            'title' => 'タイトル',
            'content' => '本文',
            'status' => 'ステータス',
            'category_id' => 'カテゴリ',
            'published_at' => '公開日時',
            'closed_at' => '公開終了日時',
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
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'content.required' => '本文を入力してください。',
            'content.max' => '本文は10000文字以内で入力してください。',
            'status.required' => 'ステータスを選択してください。',
            'published_at.required' => '公開日時を入力してください。',
            'published_at.date' => '有効な日時を入力してください。',
            'closed_at.date' => '有効な日時を入力してください。',
            'closed_at.after' => '公開終了日時は公開日時より後にしてください。',
        ];
    }
}
