<?php

class ArticlesTableSeeder extends Seeder {

	public function run()
	{
		Article::truncate();

		Article::create(array(
			'title' => 'New Post',
			'content' => 'Hello world. This is our first news article!',
			'author_id' => '1',
			'scheduled' => '2014-04-01 08:00:00',
		));

		Article::create(array(
			'title' => 'Test Post',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'author_id' => '2',
			'scheduled' => '2014-04-01 08:00:00',
		));

		Article::create(array(
			'title' => 'Another Post',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'author_id' => '3',
			'scheduled' => '2014-04-01 08:00:00',
		));

		Article::create(array(
			'title' => 'Post Again',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'author_id' => '4',
			'scheduled' => '2014-04-01 08:00:00',
		));
	}
}