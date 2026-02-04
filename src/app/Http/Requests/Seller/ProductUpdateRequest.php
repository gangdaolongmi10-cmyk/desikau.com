<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 商品更新リクエスト
 */
class ProductUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'integer', 'min:0', 'max:10000000'],
            'original_price' => ['nullable', 'integer', 'min:0', 'max:10000000'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'file' => ['nullable', 'file', 'max:512000'],
            'file_format' => ['nullable', 'string', 'max:100'],
            'file_size' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'integer', 'in:0,1'],
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
            'name' => '商品名',
            'category_id' => 'カテゴリー',
            'description' => '商品説明',
            'price' => '価格',
            'original_price' => '元価格',
            'image_url' => '商品画像URL',
            'file' => 'デジタルコンテンツファイル',
            'file_format' => 'ファイル形式',
            'file_size' => 'ファイルサイズ',
            'status' => '公開ステータス',
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
            'name.required' => '商品名を入力してください。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'category_id.required' => 'カテゴリーを選択してください。',
            'category_id.exists' => '指定されたカテゴリーが見つかりません。',
            'description.max' => '商品説明は5000文字以内で入力してください。',
            'price.required' => '価格を入力してください。',
            'price.min' => '価格は0以上で入力してください。',
            'price.max' => '価格は10,000,000以下で入力してください。',
            'original_price.min' => '元価格は0以上で入力してください。',
            'original_price.max' => '元価格は10,000,000以下で入力してください。',
            'image_url.url' => '有効なURLを入力してください。',
            'image_url.max' => '商品画像URLは500文字以内で入力してください。',
            'file.file' => '有効なファイルをアップロードしてください。',
            'file.max' => 'ファイルサイズは500MB以下にしてください。',
            'status.required' => '公開ステータスを選択してください。',
            'status.in' => '無効なステータスが指定されました。',
        ];
    }
}
