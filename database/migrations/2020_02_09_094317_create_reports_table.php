<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('to_user',false,true);
            $table->bigInteger('reporter',false,true);
            $table->text('report')->nullable();
            $table->boolean('seen')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('to_user')->references('id')->on('users');
            $table->foreign('reporter')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
