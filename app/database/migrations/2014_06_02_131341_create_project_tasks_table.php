<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_tasks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('project_id');
			$table->string('section');
			$table->text('content');
			$table->enum('checkbox', array('open','closed'));
			$table->text('notes');
			$table->integer('user_finished_id');
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
		Schema::drop('project_tasks');
	}

}
