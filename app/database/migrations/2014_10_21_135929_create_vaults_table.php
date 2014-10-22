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
			$table->string('title');
			$table->string('slug');
			$table->integer('author_id');
			$table->integer('edit_id');
			$table->string('tag_id');
			$table->enum('type',array('website','ftp','database','email','server','generic'));
			$table->string('url');
			$table->string('username');
			$table->string('password');
			$table->string('database_name');
			$table->string('ftp_path');
			$table->string('notes')->nullable;
			$table->text('attachment');
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
