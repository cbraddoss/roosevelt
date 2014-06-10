<?php

class ProjectsTableSeeder extends Seeder {

	public function run()
	{
		Project::truncate();

		Project::create(array(
			'title' => 'Sample Inn New Website',
			'slug' => 'sample-inn-new-website',
			'content' => 'Create new website per attached contract.',
			'department' => 'design',
			'priority' => 'normal',
			'stage' => 'launch',
			'type' => 'new-website',
			'status' => 'open',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '1',
			'template_id' => '2',
			'account_id' => '1',
			'due_date' => '2014-06-10 08:00:00',
			'period' => 'ending',
			'end_date' => '2014-06-30 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-06-01 08:00:00'
		));

		Project::create(array(
			'title' => 'Another B&B Responsive Upgrade',
			'slug' => 'another-b-b-responsive-upgrade',
			'content' => 'Upgrade current site to be responsive.',
			'department' => 'design',
			'priority' => 'high',
			'stage' => 'coding',
			'type' => 'responsive',
			'status' => 'open',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '2',
			'template_id' => '4',
			'account_id' => '2',
			'due_date' => '2014-06-06 08:00:00',
			'period' => 'ending',
			'end_date' => '2014-06-30 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-06-01 08:00:00'
		));

		Project::create(array(
			'title' => 'The Best BnB New Website',
			'slug' => 'the-best-bnb-new-website',
			'content' => 'Create new website!',
			'department' => 'design',
			'priority' => 'normal',
			'stage' => 'pre-launch',
			'type' => 'new-website',
			'status' => 'open',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '3',
			'template_id' => '2',
			'account_id' => '3',
			'due_date' => '2014-06-03 08:00:00',
			'period' => 'ending',
			'end_date' => '2014-06-30 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-06-01 08:00:00'
		));

		Project::create(array(
			'title' => 'Sample Inn SEM',
			'slug' => 'sample-inn-sem',
			'content' => 'SEM monthly.',
			'department' => 'sem',
			'priority' => 'low',
			'stage' => 'coding',
			'type' => 'sem-monthly',
			'status' => 'open',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '1',
			'template_id' => '5',
			'account_id' => '1',
			'due_date' => '2014-06-14 08:00:00',
			'period' => 'recurring',
			'start_date' => '2014-06-14 08:00:00',
			'end_date' => '2014-05-14 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-06-01 08:00:00'
		));

		Project::create(array(
			'title' => 'The Best BnB Mobile Website',
			'slug' => 'the-best-bnb-mobile-website',
			'content' => 'Mobile website for The Best BnB.',
			'department' => 'design',
			'priority' => 'normal',
			'stage' => 'coding',
			'type' => 'mobile-website',
			'status' => 'open',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '3',
			'template_id' => '6',
			'account_id' => '3',
			'due_date' => '2014-06-15 08:00:00',
			'period' => 'ending',
			'end_date' => '2014-06-30 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-06-01 08:00:00'
		));

		Project::create(array(
			'title' => 'Sample Inn Mobile Website',
			'slug' => 'sample-inn-mobile-website',
			'content' => 'Create a beautiful mobile website.',
			'department' => 'design',
			'priority' => 'normal',
			'stage' => 'completed',
			'type' => 'mobile-website',
			'status' => 'closed',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '2',
			'template_id' => '6',
			'account_id' => '1',
			'due_date' => '2014-05-30 08:00:00',
			'period' => 'ending',
			'end_date' => '2014-06-30 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-05-01 08:00:00'
		));
	}
}