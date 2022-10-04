<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderConfirmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'shipping_store_name' => 'required|max:255',
            'shipping_store_zip_code' => 'required|max:255',
            'shipping_store_address_1' => 'required|max:255',
            'shipping_store_address_2' => 'nullable|max:255',
            'shipping_store_tel_number' => 'required|max:255',
            'store_pic' => 'required|max:255',
            'delivery_date' => 'nullable|date',
            'order_quantity.*' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'shipping_store_name.required' => '店舗名を入力して下さい。',
            'shipping_store_name.max' => '店舗名は255文字以下で入力して下さい。',
            'shipping_store_zip_code.required' => '郵便番号を入力して下さい。',
            'shipping_store_zip_code.max' => '郵便番号は255文字以下で入力して下さい。',
            'shipping_store_address_1.required' => '住所1を入力して下さい。',
            'shipping_store_address_1.max' => '住所1は255文字以下で入力して下さい。',
            'shipping_store_address_2.max' => '住所2は255文字以下で入力して下さい。',
            'shipping_store_tel_number.required' => '電話番号を入力して下さい。',
            'shipping_store_tel_number.max' => '電話番号は255文字以下で入力して下さい。',
            'store_pic.required' => '担当者を入力して下さい。',
            'store_pic.max' => '担当者は255文字以下で入力して下さい。',
            'delivery_date.date' => '配送希望日が正しくありません。',
            'order_quantity.*.required' => '発注数を入力して下さい。',
            'order_quantity.*.integer' => '発注数は数値を入力して下さい。',
            'order_quantity.*.min' => '発注数は1以上の数値を入力して下さい。',
        ];
    }
}
