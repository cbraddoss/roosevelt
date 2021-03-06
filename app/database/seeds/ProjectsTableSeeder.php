<?php

class ProjectsTableSeeder extends Seeder {

	public function run()
	{
		Project::truncate();

		Project::create(array(
			'title' => 'Sample Inn - New Website',
			'slug' => 'sample-inn-new-website',
			'content' => 'Create new website per attached contract.',
			'priority' => 'normal',
			'stage' => 'Pre-Production',
			'type' => 'new-website',
			'status' => 'open',
			'manager_id' => '1',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '1',
			'template_id' => '2',
			'account_id' => '1',
			'due_date' => '2014-09-12 08:00:00',
			'period' => 'ending',
			'start_date' => '2014-09-01 08:00:00',
			'end_date' => '2014-09-30 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-09-01 08:00:00'
		));

		Project::create(array(
			'title' => 'Another B&B - Responsive Upgrade',
			'slug' => 'another-b-b-responsive-upgrade',
			'content' => 'Upgrade current site to be responsive.',
			'priority' => 'high',
			'stage' => 'Pre-Production',
			'type' => 'responsive',
			'status' => 'open',
			'manager_id' => '1',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '2',
			'template_id' => '4',
			'account_id' => '2',
			'due_date' => '2014-09-20 08:00:00',
			'period' => 'ending',
			'start_date' => '2014-09-01 08:00:00',
			'end_date' => '2014-09-30 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-09-01 08:00:00'
		));

		Project::create(array(
			'title' => 'The Best BnB - New Website',
			'slug' => 'the-best-bnb-new-website',
			'content' => 'Create new website!',
			'priority' => 'normal',
			'stage' => 'Pre-Production',
			'type' => 'new-website',
			'status' => 'open',
			'manager_id' => '1',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '3',
			'template_id' => '2',
			'account_id' => '3',
			'due_date' => '2014-09-23 08:00:00',
			'period' => 'ending',
			'start_date' => '2014-09-01 08:00:00',
			'end_date' => '2014-09-30 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-09-01 08:00:00'
		));

		Project::create(array(
			'title' => 'Sample Inn - SEM',
			'slug' => 'sample-inn-sem',
			'content' => 'SEM monthly.',
			'priority' => 'low',
			'stage' => 'Tune-Up',
			'type' => 'sem-monthly',
			'status' => 'open',
			'manager_id' => '1',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '1',
			'template_id' => '5',
			'account_id' => '1',
			'due_date' => '2014-09-30 08:00:00',
			'period' => 'recurring',
			'recur_cycle' => 'monthly',
			'start_date' => '2014-09-01 08:00:00',
			'end_date' => '2014-09-30 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-09-01 08:00:00'
		));

		Project::create(array(
			'title' => 'The Best BnB - Mobile Website',
			'slug' => 'the-best-bnb-mobile-website',
			'content' => 'Mobile website for The Best BnB.',
			'priority' => 'normal',
			'stage' => 'Contract',
			'type' => 'mobile-website',
			'status' => 'open',
			'manager_id' => '1',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '3',
			'template_id' => '6',
			'account_id' => '3',
			'due_date' => '2014-09-18 08:00:00',
			'period' => 'ending',
			'start_date' => '2014-09-01 08:00:00',
			'end_date' => '2014-09-30 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-09-01 08:00:00'
		));

		Project::create(array(
			'title' => 'Sample Inn - Mobile Website',
			'slug' => 'sample-inn-mobile-website',
			'content' => 'Create a beautiful mobile website.',
			'priority' => 'normal',
			'stage' => 'Completed',
			'type' => 'mobile-website',
			'status' => 'closed',
			'manager_id' => '1',
			'author_id' => '1',
			'subscribed' => 'brad-doss',
			'assigned_id' => '2',
			'template_id' => '6',
			'account_id' => '1',
			'due_date' => '2014-05-30 08:00:00',
			'period' => 'ending',
			'start_date' => '2014-06-01 08:00:00',
			'end_date' => '2014-06-30 08:00:00',
			'edit_id' => '1',
			'created_at' => '2014-05-01 08:00:00'
		));
	}
}