<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array
     */
    public function rules()
    {
        return [
			'product_name' => [
				'required', //入力必須
				'string', //文字列かどうか
				'max:100' //100文字以内
			],
			'description' => [
				'nullable', //null許容
				'string', //文字列かどうか
				'max:200' //200文字以内
			],
			'price' => [
				'required', //入力必須
				'integer', //整数がどうか
				'min:0', //0以上
				'max:10000000' //10000000以内
			],
			'stock' => [
				'required', //入力必須
				'integer', //整数かどうか
				'min:0', //0以上
				'max:10000000' //10000000以内
			]
        ];
    }
	public function messages()
	{
		return [
			//商品名
			'product_name.required' => '商品名：入力必須です',
			'product_name.max' => '商品名：100文字以内で記入してください',
			//商品説明
			'description.max' => '商品説明：200文字以内で記入してください',
			//金額
			'price.required' => '金額：入力必須です',
			'price.integer' => '金額：整数で指定してください',
			'price.min' => '金額：不正な数字です',
			'price.max' => '金額：不正な数字です',
			//在庫数
			'stock.required' => '在庫数：入力必須です',
			'stock.integer' => '在庫数：整数で指定してください',
			'stock.min' => '金額：不正な数字です',
			'stock.max' => '金額：不正な数字です',
		];
	}
}
