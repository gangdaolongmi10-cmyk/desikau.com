<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 特定商取引法に基づく表記リクエスト
 */
class SellerLegalInfoRequest extends FormRequest
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
            'company_name' => ['required', 'string', 'max:255'],
            'representative_name' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'price_description' => ['required', 'string', 'max:5000'],
            'payment_method' => ['required', 'string', 'max:5000'],
            'delivery_period' => ['required', 'string', 'max:5000'],
            'return_policy' => ['required', 'string', 'max:5000'],
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
            'company_name' => '販売業者名',
            'representative_name' => '代表者名',
            'postal_code' => '郵便番号',
            'address' => '所在地',
            'phone_number' => '電話番号',
            'email' => 'メールアドレス',
            'price_description' => '販売価格について',
            'payment_method' => '支払方法',
            'delivery_period' => '引渡し時期',
            'return_policy' => '返品・キャンセルについて',
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
            'company_name.required' => '販売業者名を入力してください。',
            'company_name.max' => '販売業者名は255文字以内で入力してください。',
            'representative_name.required' => '代表者名を入力してください。',
            'representative_name.max' => '代表者名は255文字以内で入力してください。',
            'postal_code.required' => '郵便番号を入力してください。',
            'postal_code.max' => '郵便番号は10文字以内で入力してください。',
            'address.required' => '所在地を入力してください。',
            'address.max' => '所在地は255文字以内で入力してください。',
            'phone_number.required' => '電話番号を入力してください。',
            'phone_number.max' => '電話番号は20文字以内で入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'price_description.required' => '販売価格についてを入力してください。',
            'price_description.max' => '販売価格については5000文字以内で入力してください。',
            'payment_method.required' => '支払方法を入力してください。',
            'payment_method.max' => '支払方法は5000文字以内で入力してください。',
            'delivery_period.required' => '引渡し時期を入力してください。',
            'delivery_period.max' => '引渡し時期は5000文字以内で入力してください。',
            'return_policy.required' => '返品・キャンセルについてを入力してください。',
            'return_policy.max' => '返品・キャンセルについては5000文字以内で入力してください。',
        ];
    }
}
