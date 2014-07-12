<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 255)->unique();
			$table->string('slug', 255)->unique();
			$table->text('content');
			$table->enum('priority', array('low', 'normal', 'high'));
			$table->string('stage',120);
			$table->string('type',120);
			$table->enum('status',array('open','closed','archived'));
			$table->integer('manager_id');
			$table->integer('author_id');
			$table->string('subscribed');
			$table->integer('assigned_id');
			$table->integer('template_id');
			$table->integer('account_id');
			$table->dateTime('due_date');
			$table->enum('period',array('ending','recurring'));
			$table->dateTime('start_date');
			$table->dateTime('end_date');
			$table->text('attachment');
			$table->integer('edit_id');
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
		Schema::drop('projects');
	}

}
