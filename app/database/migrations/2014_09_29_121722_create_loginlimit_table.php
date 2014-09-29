<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginLimitTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loginlimit', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('ip_address', 16);
			$table->dateTime('failed_at');
			$table->integer('attempts');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('loginlimit');
	}

}
