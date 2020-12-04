<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
			'quantity' => [
				'required', //入力必須
				'integer', //整数かどうか
				'min:1', //1以上
				'max:5' //5以内
			],
        ];
    }
	public function messages()
	{
		return [
			//購入数
			'quantity.required' => '購入数：入力必須です',
			'quantity.integer' => '購入数：無効な文字が入力されています',
			'quantity.min' => '購入数：1-5で選択してください',
			'quantity.max' => '購入数：1-5で選択してください',
		];
	}
}
