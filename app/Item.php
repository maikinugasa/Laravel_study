<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Item extends Model
{
    protected $fillable = [
        'product_name', 'description', 'price', 'stock', 'pic'
    ];
	protected $table = 'items';
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
