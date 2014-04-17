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
			$table->string('email', 50)->unique();
			$table->string('password', 60);
			$table->string('userrole', 20);
			$table->string('first_name', 50);
			$table->string('last_name', 50);
			$table->string('extension', 40);
			$table->string('cell_phone', 40);
			$table->string('user_path', 128)->unique();
			$table->dateTime('last_login');
			$table->string('status', 8);
			$table->string('remember_token',100)->nullable();
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
