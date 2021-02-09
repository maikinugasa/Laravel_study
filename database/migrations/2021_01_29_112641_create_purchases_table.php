<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchases', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id'); //ユーザーID(userテーブルと結合)
			$table->string('cus_id'); //顧客ID(stripeで管理されるcus_から始まる文字列)
			$table->string('cus_name'); //顧客氏名
			$table->string('postal_code'); //郵便番号
			$table->string('address'); //住所
			$table->string('phonenumber'); //電話番号
			$table->string('email'); //メールアドレス
			$table->integer('total_price'); //購入合計金額
			$table->string('status'); //決済完了、発送完了、配送済み等をステータスで把握
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
		Schema::dropIfExists('purchases');
	}
}
