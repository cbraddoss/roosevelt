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
			$table->string('title', 120);
			$table->text('content');
			$table->enum('department', array('Design','Development','S.E.M.','Print'));
			$table->enum('priority', array('low', 'normal', 'high'));
			$table->string('stage',60);
			$table->integer('assigned_id');
			$table->integer('template_id');
			$table->integer('account_id');
			$table->dateTime('due_date');
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
		Schema::drop('projects');
	}

}
