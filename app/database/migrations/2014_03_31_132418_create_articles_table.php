<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 120)->unique();
			$table->text('content');
			$table->string('slug')->unique();
			$table->enum('status', array('published', 'sticky', 'draft'));
			$table->integer('author_id');
			$table->integer('edit_id');
			$table->string('been_read');
			$table->string('favorited');
			$table->string('mentions');
			$table->text('attachment');
			$table->dateTime('show_on_calendar');
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
		Schema::drop('articles');
	}

}
