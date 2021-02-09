<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id'); //ユーザーID(userテーブルと結合)
			$table->unsignedInteger('purchase_id'); //購入情報ID(purchaseテーブルと結合)→どの購入に対する支払いかを管理
			$table->string('transaction_id'); //stripeから支払いごとに発行されるコード
			$table->integer('amount'); //決済金額
			$table->string('currency'); //通貨
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
		Schema::dropIfExists('payments');
	}
}
