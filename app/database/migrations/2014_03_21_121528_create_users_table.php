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
			$table->enum('userrole', array('admin', 'standard','non-standard'));
			$table->string('first_name', 50);
			$table->string('last_name', 50);
			$table->dateTime('anniversary');
			$table->string('extension', 40)->nullable();
			$table->string('cell_phone', 40)->nullable();
			$table->string('user_path', 128)->unique();
			$table->dateTime('last_login')->nullable();
			$table->enum('status', array('active', 'inactive'));
			$table->enum('can_manage', array('no','yes'));
			$table->string('remember_token',100)->nullable();
			$table->string('ip_address',16);
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
