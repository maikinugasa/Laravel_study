<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adresses', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id'); //ユーザーのID(userテーブルと結合)
			$table->string('name', 100); //お届け先名
			$table->string('postalcode, 30'); //郵便番号
			$table->string('prefecture', 100); //都道府県
			$table->string('city', 100); //市町村
			$table->string('adress', 100); //その他住所
			$table->string('phonenumber', 30); //電話番号
			$table->timestamps(); //作成・更新日時(このカラムタイプを指定した場合、Timestamp型の「created_at」と「updated_at」が２つ生成される)
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
        Schema::dropIfExists('adresses');
    }
}
