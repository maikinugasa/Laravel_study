<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdressRequest extends FormRequest
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
			'name' => [
				'required', //入力必須
				'string', //文字列かどうか
				'max:30' //30文字以内
			],
			'postalcode' => [
				'required', //入力必須
				'regex:/^\d{3}\-\d{4}$/', //例：000-0000
			],
			'prefecture' => [
				'required', //入力必須
				'string', //文字列かどうか
				'in:北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,新潟県,富山県,石川県,福井県,山梨県,長野県,岐阜県,静岡県,愛知県,三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県'
			],
			'city' => [
				'required', //入力必須
				'string', //文字列かどうか
				'max:30' //30以内
			],
			'adress' => [
				'required', //入力必須
				'string', //文字列かどうか
				'max:50' //50以内
			],
			'phonenumber' => [
				'required', //入力必須
				'regex:/^0\d{1,3}\-\d{2,4}\-\d{4}$/', //例：00-0000-0000/090-0000-0000
				'min:12', //12文字以上
				'max:13' //13文字以内
			]
		];
	}
	public function messages()
	{
		return [
			//氏名
			'name.required' => '氏名：入力必須です',
			'name.string' => '氏名：使用できない文字が含まれています',
			'name.max' => '氏名：30文字以内で記入してください',
			//郵便番号
			'postalcode.required' => '郵便番号：入力必須です',
			'postalcode.regex' => '郵便番号：形式に誤りがあります',
			//都道府県
			'prefecture.required' => '都道府県：入力必須です',
			'prefecture.string' => '都道府県：使用できない文字が含まれています',
			'prefecture.in' => '都道府県：入力に誤りがあります',
			//市区町村
			'city.required' => '市区町村：入力必須です',
			'city.string' => '市区町村：使用できない文字が含まれています',
			'city.max' => '市区町村：30文字以内で入力してください',
			//番地
			'adress.required' => '番地：入力必須です',
			'adress.string' => '番地：使用できない文字が含まれています',
			'adress.max' => '番地：50文字以内で入力してください',
			//電話番号
			'phonenumber.required' => '電話番号：入力必須です',
			'phonenumber.regex' => '電話番号：形式に誤りがあります',
			'phonenumber.min' => '電話番号：形式に誤りがあります',
			'phonenumber.max' => '電話番号：形式に誤りがあります',
		];
	}
}
