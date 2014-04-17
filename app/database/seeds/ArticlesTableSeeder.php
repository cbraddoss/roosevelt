<?php

class ArticlesTableSeeder extends Seeder {

	public function run()
	{
		Article::truncate();

		Article::create(array(
			'title' => 'New Post',
			'content' => 'Hello world. This is our first news article!',
			'author_id' => '1',
			'status' => 'published',
			'created_at' => '2014-02-25 21:22:48'
		));

		Article::create(array(
			'title' => 'Test Post',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'author_id' => '2',
			'status' => 'published',
			'created_at' => '2014-03-31 21:22:48'
		));

		Article::create(array(
			'title' => 'Another Post',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'author_id' => '3',
			'status' => 'published',
			'created_at' => '2014-04-01 21:22:48'
		));

		Article::create(array(
			'title' => 'Post Again',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'author_id' => '4',
			'status' => 'published',
			'created_at' => '2014-01-31 21:22:48'
		));

		Article::create(array(
			'title' => 'Post Draft',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'author_id' => '4',
			'status' => 'draft',
			'created_at' => '2014-04-16 21:22:48'
		));
	}
}