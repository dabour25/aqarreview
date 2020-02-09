<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
			$table->charset = 'utf8';
			$table->collation = 'utf8_unicode_ci';
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('slug')->unique();
            $table->string('email',50)->unique();
            $table->string('password',100);
			$table->string('phone',30)->nullable($value = true);
			$table->date('age');
			$table->enum('role',["user","renter","developer","contractor","corporation","owner","broker","engineer","blocked"]);
            $table->rememberToken();
			$table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
            $table->bigInteger('deleted_by',false,true)->nullable();

            $table->foreign('deleted_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
