<?php

class TemplateTasksTableSeeder extends Seeder {

	public function run()
	{
		TemplateTask::truncate();

		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Pre-Production',
			'content' => 'Project Manager email pre-productions questionnaire for needed info.',
			'created_at' => '2014-06-24 08:00:00',
		));

		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Layout Proof',
			'content' => 'Project Manager email pre-productions questionnaire for needed info.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Layout Proof',
			'content' => 'Website layout proof approved by client. Ping @shawn',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Layout Proof',
			'content' => 'Clean up PSD for coding and supply any additional instructions or details to coder',
			'created_at' => '2014-06-24 08:00:00',
		));

		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Code Website',
			'content' => 'Import existing blog',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Code Website',
			'content' => 'Setup one-image slideshow to verify functionality and give image an appropriate alt tag.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Code Website',
			'content' => 'Verify wide and narrow column appearances.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Code Website',
			'content' => 'Verify Sitemap page.',
			'created_at' => '2014-06-24 08:00:00',
		));

		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Pre-Launch',
			'content' => 'Update TTL to 5 minutes',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Pre-Launch',
			'content' => 'Migrate latest blog posts from current blog.',
			'created_at' => '2014-06-24 08:00:00',
		));

		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Launch',
			'content' => 'Turn off privacy.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Launch',
			'content' => 'In DNS, update A record for domain IP.',
			'created_at' => '2014-06-24 08:00:00',
		));

		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Clean Up',
			'content' => 'Export previous site databases and files and delete from previous server (if IOS hosted).',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '1',
			'section' => 'Clean Up',
			'content' => 'Save old website to Dropbox.',
			'created_at' => '2014-06-24 08:00:00',
		));
	}
}