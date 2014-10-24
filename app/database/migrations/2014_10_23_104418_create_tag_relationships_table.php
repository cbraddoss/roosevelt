<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagRelationshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag_relationships', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tag_id');
			$table->enum('type', array('account','project','billable','article','help','invoice','vault','asset','personal'));
			$table->integer('type_id');
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
		Schema::drop('tag_relationships');
	}

}
