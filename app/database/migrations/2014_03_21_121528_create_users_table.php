<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username', 40)->unique();
			$table->string('password', 60);
			$table->string('userrole', 20);
			$table->string('email', 50)->unique();
			$table->string('first_name', 50);
			$table->string('last_name', 50);
			$table->string('extension', 40);
			$table->string('cell_phone', 40);
			$table->boolean('active');
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
		Schema::drop('users');
	}

}
