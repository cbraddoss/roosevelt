<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vacations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->dateTime('start_date');
			$table->dateTime('end_date');
			$table->integer('total_hours');
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
		Schema::drop('vacations');
	}

}
