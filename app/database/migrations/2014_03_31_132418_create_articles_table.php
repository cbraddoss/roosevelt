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
			$table->string('link')->unique();
			$table->enum('status', array('published', 'draft'));
			$table->integer('author_id');
			$table->string('been_read')->nullable();
			$table->string('favorited')->nullable();
			$table->string('mentions')->nullable();
			$table->string('attachment')->nullable();
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
