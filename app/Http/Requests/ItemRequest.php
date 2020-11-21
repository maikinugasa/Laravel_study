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
				'string', //文字列かどうか
				'max:50' //50文字以内
			],
			'description' => [
				'nullable', //null許容
				'string', //文字列かどうか
				'max:200' //200文字以内
			],
			'price' => [
				'integer', //整数がどうか
				'digits_between:1,9', //9桁以内であるか
				'min:1' //1以上の数字であるか
			],
			'stock' => [
				'integer' //整数かどうか
			]
        ];
    }
	public function messages()
	{
		return [
			'product_name.max' => '商品名：50文字以内で記入してください',
			'description.max' => '商品説明：200文字以内で記入してください',
			'price.integer' => '金額：整数で指定してください',
			'price.min' => '金額：1以上の数字を入力してください',
			'price.digits_between' => '金額：1-9桁で入力してください',
			'stock.integer' => '在庫数：整数で指定してください'
		];
	}
}
