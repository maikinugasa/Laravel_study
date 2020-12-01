<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('user_id'); //ユーザーのID
			$table->unsignedInteger('item_id'); //アイテムのID
			$table->unsignedInteger('quantity'); //購入数
            $table->timestamps(); //作成・更新時間
			$table->softDeletes(); //倫理削除
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
