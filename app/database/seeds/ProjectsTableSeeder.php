<?php

class ProjectsTableSeeder extends Seeder {

	public function run()
	{
		Project::truncate();

		Project::create(array(
			'title' => 'Sample Inn New Website',
			'content' => 'Create new website per attached contract.',
			'department' => 'design',
			'priority' => 'normal',
			'subscribed' => 'brad_doss insideout',
			'assigned_id' => '1',
			'template_id' => '1',
			'account_id' => '1',
			'due_date' => '2014-06-31 08:00:00',
			'created_at' => '2014-06-01 08:00:00'
		));		
	}
}