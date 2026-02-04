<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * カート商品追加リクエスト
 */
class CartAddRequest extends FormRequest
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
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['integer', 'min:1'],
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
            'product_id' => '商品ID',
            'quantity' => '数量',
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
            'product_id.required' => '商品を選択してください。',
            'product_id.exists' => '指定された商品が見つかりません。',
            'quantity.min' => '数量は1以上を指定してください。',
        ];
    }
}
