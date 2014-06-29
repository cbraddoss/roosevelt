<?php

class ProjectTasksTableSeeder extends Seeder {

	public function run()
	{
		ProjectTask::truncate();

		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Pre-Production',
			'content' => 'Project Manager email pre-productions questionnaire for needed info.',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));

		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Layout Proof',
			'content' => 'Project Manager email pre-productions questionnaire for needed info.',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Layout Proof',
			'content' => 'Website layout proof approved by client. Ping @shawn',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Layout Proof',
			'content' => 'Clean up PSD for coding and supply any additional instructions or details to coder',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));

		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Code Website',
			'content' => 'Import existing blog',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Code Website',
			'content' => 'Setup one-image slideshow to verify functionality and give image an appropriate alt tag.',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Code Website',
			'content' => 'Verify wide and narrow column appearances.',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Code Website',
			'content' => 'Verify Sitemap page.',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));

		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Pre-Launch',
			'content' => 'Update TTL to 5 minutes',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Pre-Launch',
			'content' => 'Migrate latest blog posts from current blog.',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));

		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Launch',
			'content' => 'Turn off privacy.',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Launch',
			'content' => 'In DNS, update A record for domain IP.',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));

		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Clean Up',
			'content' => 'Export previous site databases and files and delete from previous server (if IOS hosted).',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Clean Up',
			'content' => 'Save old website to Dropbox.',
			'checkbox' => 'open',
			'notes' => '',
			'created_at' => '2014-06-24 08:00:00',
		));
		
	}
}