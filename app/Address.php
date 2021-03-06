<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
	protected $fillable = [
		'user_id', 'name', 'postalcode', 'prefecture', 'city', 'address', 'phonenumber',
	];
	protected $table = 'addresses';

	//倫理削除
	use SoftDeletes;
	protected $dates = ['deleted_at'];

	//リレーション(userテーブルと結合)
	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}
}
