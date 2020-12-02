<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Item;

class Cart extends Model
{
	protected $fillable = [
		'user_id', 'item_id', 'quantity',
	];
	protected $table = 'carts';

	//倫理削除
	use SoftDeletes;
	protected $dates = ['deleted_at'];

	//リレーション(itemテーブルと結合)
	public function item() {
		return $this->belongsTo('App\Item', 'item_id');
	}
	//商品ごとの合計金額計算
	public function subtotal() {
		$result = $this->item->price * $this->quantity;
		return $result;
	}
}
