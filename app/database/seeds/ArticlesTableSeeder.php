<?php

class ArticlesTableSeeder extends Seeder {

	public function run()
	{
		Article::truncate();

		Article::create(array(
			'title' => 'New Post',
			'content' => 'Hello world. This is our first news article!',
			'link' => 'new-post',
			'author_id' => '1',
			'status' => 'published',
			'created_at' => '2014-02-25 21:22:48'
		));

		Article::create(array(
			'title' => 'Test Post',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.

			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.

			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'link' => 'test-post',
			'author_id' => '2',
			'status' => 'published',
			'created_at' => '2014-03-31 21:22:48'
		));

		Article::create(array(
			'title' => 'Another Post',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.

			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'link' => 'another-post',
			'author_id' => '3',
			'status' => 'published',
			'created_at' => '2014-04-01 21:22:48'
		));

		Article::create(array(
			'title' => 'Post Again',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.

			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.

			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.

			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'link' => 'post-again',
			'author_id' => '4',
			'status' => 'published',
			'created_at' => '2014-01-31 21:22:48'
		));

		Article::create(array(
			'title' => 'Post Draft',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
			'link' => 'post-draft',
			'author_id' => '4',
			'status' => 'draft',
			'created_at' => '2014-04-16 21:22:48'
		));

		Article::create(array(
			'title' => 'Jack\'s Computer for Corey',
			'content' => "Video Card: http://204.14.213.185/Product/Product.aspx?Item=N82E16814127763
$75

CPU: http://www.newegg.com/Product/Product.aspx?Item=N82E16819116502
$300

MOBO: http://204.14.213.185/Product/Product.aspx?Item=N82E16813128541
$90

PSU: http://204.14.213.185/Product/Product.aspx?Item=N82E16817371016
$65

Ram (16g): http://204.14.213.185/Product/Product.aspx?Item=N82E16820231568
$150

HD: http://www.newegg.com/Product/Product.aspx?Item=N82E16822148840
$65

Case: http://www.newegg.com/Product/Product.aspx?Item=11-124-159
$80

Case Fans(x2) http://www.newegg.com/Product/Product.aspx?Item=35-103-060
$22

CPU Fan: http://www.newegg.com/Product/Product.aspx?Item=N82E16835200063
$13

CD Drive: http://www.newegg.com/Product/Product.aspx?Item=N82E16827136270
$20

Total: $880

",
			'link' => 'jacks-computer-for-corey',
			'author_id' => '2',
			'status' => 'published',
			'created_at' => '2014-04-16 11:22:48'
		));

		Article::create(array(
			'title' => 'Meeting Notes 4-15-14',
			'content' => "brad:
inn at cedar falls web files sent
sending files to alaska adventures
goldberg jones subdomain setup

jim:
westhill house
blacktail logo
purple haze label
pa web ads
stay at hudson rebranding

beth:
billing
glen ayr
proof to wisconsin

jack:
maryland
utah new design launching

taylor:
updates

corey:
blogging (secretly in PT)

jenn:
logo for stay in hudson
logo for olympic peninsula
stuck on shorecrest in raven",
			'link' => 'meeting-notes-4-15-14',
			'author_id' => '2',
			'status' => 'published',
			'created_at' => '2014-04-15 12:42:48'
		));

		Article::create(array(
			'title' => 'Video User Manuals',
			'content' => "The video user manuals plugin has been reactivated.
We’ll have to update the serial number on all of the sites using it. If you find one that hasn’t been updated, please find the serial number here https://wiki.insideout.co/2011/08/31/security/ and update!
I’ll be getting inndx and directory updated here in a few minutes.",
			'link' => 'video-user-manuals',
			'author_id' => '1',
			'status' => 'published',
			'created_at' => '2014-04-04 14:22:48'
		));
	}
}