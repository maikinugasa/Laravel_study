<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseDetailsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_details', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('purchase_id'); //購入情報ID(purchaseテーブルと結合)→どの購入履歴の詳細か管理
			$table->unsignedInteger('item_id'); //アイテムID(itemテーブルと結合)
			$table->integer('quantity'); //個数
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('purchase_details');
	}
}
