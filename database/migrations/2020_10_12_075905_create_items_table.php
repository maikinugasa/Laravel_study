<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
			$table->increments('id');
			$table->string('product_name', 100); //商品名：最長100文字を指定したVARCHARカラム
			$table->text('description'); //商品説明：TEXTカラム
			$table->unsignedInteger('price'); //価格：INT符号なし
			$table->integer('stock'); //在庫数：INT
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
        Schema::dropIfExists('items');
    }
}
