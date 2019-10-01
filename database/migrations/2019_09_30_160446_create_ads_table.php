<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
			$table->charset = 'utf8';
			$table->collation = 'utf8_unicode_ci';
            $table->bigIncrements('id');
			$table->bigInteger('user')->default(0);
			$table->string('title',60);
			$table->float('price',50,2);
			$table->text('description');
			$table->float('size',50,2);
			$table->smallInteger('gen_type', false, true);
			$table->smallInteger('type', false, true);
			$table->smallInteger('floor', false, true)->nullable();
			$table->smallInteger('rooms', false, true)->nullable();
			$table->smallInteger('pathroom', false, true)->nullable();
			$table->smallInteger('kitchen', false, true)->nullable();
			$table->smallInteger('finish', false, true)->nullable();
			$table->smallInteger('furniture', false, true)->nullable();
			$table->smallInteger('parking', false, true)->nullable();
			$table->text('image')->nullable();
			$table->text('images')->nullable();
			$table->text('address');
			$table->tinyInteger('seen', false, true)->default(0);
			$table->tinyInteger('show', false, true)->default(0);
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
