<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVaultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vaults', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->unique();
			$table->string('slug')->unique();
			$table->integer('author_id');
			$table->integer('edit_id');
			$table->integer('account_id');
			$table->text('tag_id');
			$table->enum('type',array('website','ftp','database','email','server','generic'));
			$table->string('url');
			$table->string('username');
			$table->string('password');
			$table->string('database_name')->nullable;
			$table->string('ftp_path')->nullable;
			$table->string('notes')->nullable;
			$table->text('attachment')->nullable;
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
		Schema::drop('vaults');
	}

}
