<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
			$table->bigInteger('user_id',false,true)->nullable();
			$table->string('title',60);
			$table->decimal('price',20,2);
			$table->text('description');
			$table->float('size',50,2);
            $table->enum('general_type',['sell','rent']);
            $table->enum('type',['apartment','villa','land','houses','shop','chalet']);
            $table->smallInteger('floor', false, true)->nullable();
            $table->smallInteger('rooms', false, true)->nullable();
            $table->smallInteger('bathrooms', false, true)->nullable();
            $table->smallInteger('kitchens', false, true)->nullable();
            $table->enum('finish', ['full','not_full','red_bricks'])->default('full');
            $table->enum('furniture',['yes','no'])->default('no');
            $table->enum('parking',['yes','no'])->default('no');
            $table->text('address');
            $table->boolean('seen')->default(false);
            $table->boolean('show')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->bigInteger('updated_by',false,true)->nullable();
            $table->softDeletes();

            $table->foreign('updated_by')->references('id')->on('admins');
            $table->foreign('user_id')->references('id')->on('users');
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
