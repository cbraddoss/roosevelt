<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('article_id');
			$table->integer('reply_to_id');
			$table->text('content');
			$table->integer('author_id');
			$table->integer('edit_id');
			$table->string('mentions');
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
		Schema::drop('article_comments');
	}

}
