<?php

class TemplatesTableSeeder extends Seeder {

	public function run()
	{
		Template::truncate();

		Template::create(array(
			'name' => 'New Website',
			'slug' => 'new-website',
			'type' => 'project',
			'status' => 'active',
			'created_at' => '2014-06-04 08:00:00',
		));

		Template::create(array(
			'name' => 'General Update',
			'slug' => 'general-update',
			'type' => 'billable',
			'status' => 'active',
			'created_at' => '2014-06-04 08:00:00',
		));

		Template::create(array(
			'name' => 'Responsive',
			'slug' => 'responsive',
			'type' => 'project',
			'status' => 'active',
			'created_at' => '2014-06-04 08:00:00',
		));

		Template::create(array(
			'name' => 'SEM Monthly',
			'slug' => 'sem-monthly',
			'type' => 'project',
			'status' => 'active',
			'created_at' => '2014-06-05 08:00:00',
		));

		Template::create(array(
			'name' => 'Mobile Website',
			'slug' => 'mobile-website',
			'type' => 'project',
			'status' => 'active',
			'created_at' => '2014-06-05 08:00:00',
		));

		Template::create(array(
			'name' => 'Close Out Services',
			'slug' => 'close-out-services',
			'type' => 'project',
			'status' => 'active',
			'created_at' => '2014-06-05 08:00:00',
		));

		Template::create(array(
			'name' => 'WordPress Conversion',
			'slug' => 'wordpress-conversion',
			'type' => 'project',
			'status' => 'inactive',
			'created_at' => '2014-06-04 08:00:00',
		));
	}
}