<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
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
            'item_code' => [
                Rule::unique('items')->ignore($this->item_id, 'item_id')
            ],
            'item_category' => 'max:255',
            'item_jan_code' => 'max:13',
            'item_name' => 'max:255',
        ];
    }

    public function messages()
    {
        return [
            'item_code.unique' => '商品コードが重複しています。',
            'item_category.max' => '255文字以下で設定して下さい。（商品カテゴリ）',
            'item_jan_code.max' => '13文字以下で設定して下さい。（商品JANコード）',
            'item_name.max' => '255文字以下で設定して下さい。（商品名）',
        ];
    }
}
