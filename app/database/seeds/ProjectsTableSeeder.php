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
			'stage' => 'launch',
			'type' => 'new-website',
			'status' => 'open',
			'subscribed' => 'brad_doss insideout',
			'assigned_id' => '1',
			'template_id' => '2',
			'account_id' => '1',
			'due_date' => '2014-06-10 08:00:00',
			'created_at' => '2014-06-01 08:00:00'
		));

		Project::create(array(
			'title' => 'Another B&B Responsive Upgrade',
			'content' => 'Upgrade current site to be responsive.',
			'department' => 'design',
			'priority' => 'high',
			'stage' => 'coding',
			'type' => 'responsive',
			'status' => 'open',
			'subscribed' => 'brad_doss insideout',
			'assigned_id' => '2',
			'template_id' => '4',
			'account_id' => '2',
			'due_date' => '2014-06-06 08:00:00',
			'created_at' => '2014-06-01 08:00:00'
		));

		Project::create(array(
			'title' => 'The Best BnB New Website',
			'content' => 'Create new website!',
			'department' => 'design',
			'priority' => 'low',
			'stage' => 'waiting-on-materials',
			'type' => 'new-website',
			'status' => 'open',
			'subscribed' => 'brad_doss insideout',
			'assigned_id' => '3',
			'template_id' => '2',
			'account_id' => '3',
			'due_date' => '2014-06-03 08:00:00',
			'created_at' => '2014-06-01 08:00:00'
		));

		Project::create(array(
			'title' => 'Sample Inn SEM',
			'content' => 'SEM monthly.',
			'department' => 'sem',
			'priority' => 'normal',
			'stage' => 'coding',
			'type' => 'sem-monthly',
			'status' => 'open',
			'subscribed' => 'brad_doss insideout',
			'assigned_id' => '1',
			'template_id' => '5',
			'account_id' => '1',
			'due_date' => '2014-06-30 08:00:00',
			'created_at' => '2014-06-01 08:00:00'
		));

		Project::create(array(
			'title' => 'Sample Inn Mobile Website',
			'content' => 'Create a beautiful mobile website.',
			'department' => 'design',
			'priority' => 'normal',
			'stage' => 'completed',
			'type' => 'mobile-website',
			'status' => 'closed',
			'subscribed' => 'brad_doss insideout',
			'assigned_id' => '2',
			'template_id' => '6',
			'account_id' => '1',
			'due_date' => '2014-05-30 08:00:00',
			'created_at' => '2014-05-01 08:00:00'
		));
	}
}