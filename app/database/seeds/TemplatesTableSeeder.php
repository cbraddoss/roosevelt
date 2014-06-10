<?php

class TemplatesTableSeeder extends Seeder {

	public function run()
	{
		Template::truncate();

		Template::create(array(
			'name' => 'WordPress Conversion',
			'slug' => 'wordpress-conversion',
			'type' => 'project',
			'items' => '[[START]]
[[h]]Design
[[o]]do stuff
[[END]]
[[START]]
[[h]]Coding
[[o]]do stuff
[[END]]
[[START]]
[[h]]Pre-Launch
[[o]]do stuff
[[o]]do more stuff, like this and that, and that and this. (something else too).
[[END]]
[[START]]
[[h]]Launch
[[o]]do stuff
[[o]]backup stuff after DNS changed.
[[END]]',
			'status' => 'inactive',
			'created_at' => '2014-06-04 08:00:00',
		));

		Template::create(array(
			'name' => 'New Website',
			'slug' => 'new-website',
			'type' => 'project',
			'items' => '[[START]]
[[h]]Design
[[o]]do stuff
[[END]]
[[START]]
[[h]]Coding
[[o]]do stuff
[[END]]
[[START]]
[[h]]Pre-Launch
[[o]]do stuff
[[END]]
[[START]]
[[h]]Launch
[[o]]do stuff
[[END]]',
			'status' => 'active',
			'created_at' => '2014-06-04 08:00:00',
		));

		Template::create(array(
			'name' => 'General Update',
			'slug' => 'general-update',
			'type' => 'billable',
			'items' => '[[START]]
[[h]]Design
[[o]]do stuff
[[END]]
[[START]]
[[h]]Coding
[[o]]do stuff
[[END]]
[[START]]
[[h]]Pre-Launch
[[o]]do stuff
[[END]]
[[START]]
[[h]]Launch
[[o]]do stuff
[[END]]',
			'status' => 'active',
			'created_at' => '2014-06-04 08:00:00',
		));

		Template::create(array(
			'name' => 'Responsive',
			'slug' => 'responsive',
			'type' => 'project',
			'items' => '[[START]]
[[h]]Design
[[o]]do stuff
[[END]]
[[START]]
[[h]]Coding
[[o]]do stuff
[[END]]
[[START]]
[[h]]Pre-Launch
[[o]]do stuff
[[END]]
[[START]]
[[h]]Launch
[[o]]do stuff
[[END]]',
			'status' => 'active',
			'created_at' => '2014-06-04 08:00:00',
		));

		Template::create(array(
			'name' => 'SEM Monthly',
			'slug' => 'sem-monthly',
			'type' => 'project',
			'items' => '[[START]]
[[h]]SEM
[[o]]do stuff
[[o]]do more stuff
[[o]]do additional stuff
[[o]]do stuff some more
[[END]]',
			'status' => 'active',
			'created_at' => '2014-06-05 08:00:00',
		));

		Template::create(array(
			'name' => 'Mobile Website',
			'slug' => 'mobile-website',
			'type' => 'project',
			'items' => '[[START]]
[[h]]Design
[[o]]do stuff
[[END]]
[[START]]
[[h]]Coding
[[o]]do stuff
[[END]]
[[START]]
[[h]]Pre-Launch
[[o]]do stuff
[[END]]
[[START]]
[[h]]Launch
[[o]]do stuff
[[END]]',
			'status' => 'active',
			'created_at' => '2014-06-05 08:00:00',
		));		
	}
}