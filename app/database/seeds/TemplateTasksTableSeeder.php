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

		TemplateTask::create(array(
			'template_id' => '2',
			'section' => 'Received',
			'content' => 'Verify account associated with update is the correct account.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '2',
			'section' => 'In Progress',
			'content' => 'Complete requested update.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '2',
			'section' => 'In Progress',
			'content' => 'Fill in time required to finished update.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '2',
			'section' => 'Post-Update',
			'content' => 'Create invoice for this update.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '2',
			'section' => 'Post-Update',
			'content' => 'Contact client.',
			'created_at' => '2014-06-24 08:00:00',
		));


		TemplateTask::create(array(
			'template_id' => '3',
			'section' => 'Pre-Production',
			'content' => 'Attach contract or agreement to project.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '3',
			'section' => 'Setup',
			'content' => 'Setup temporary site for new responsive website.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '3',
			'section' => 'Setup',
			'content' => 'Verify default WP plugins installed for new responsive website.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '3',
			'section' => 'Setup',
			'content' => 'Update TTL for A record in preparation of launch.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '3',
			'section' => 'Code Website',
			'content' => 'Convert website to responsive.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '3',
			'section' => 'Code Website',
			'content' => 'Check website in all sizes and all browsers.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '3',
			'section' => 'Code Website',
			'content' => 'Run website thru appropriate pagespeed and error checking services.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '3',
			'section' => 'Pre-Launch',
			'content' => 'Do pre-launch stuff.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '3',
			'section' => 'Pre-Launch',
			'content' => 'Do more pre-launch stuff.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '3',
			'section' => 'Launch',
			'content' => 'Launch website.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '3',
			'section' => 'Clean Up',
			'content' => 'Do clean up stuff.',
			'created_at' => '2014-06-24 08:00:00',
		));


		TemplateTask::create(array(
			'template_id' => '4',
			'section' => 'Tune-Up',
			'content' => 'Welcome & questionnaire.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '4',
			'section' => 'Tune-Up',
			'content' => 'sitemap.xml: create or optimize.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '4',
			'section' => 'Tune-Up',
			'content' => 'robots.txt: add sitemap URL and disallow any content that shouldn\'t be indexed.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '4',
			'section' => 'Tune-Up',
			'content' => 'favicon.ico: add if not already present.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '4',
			'section' => 'Tune-Up',
			'content' => 'sitemap.xml: create or optimize.',
			'created_at' => '2014-06-24 08:00:00',
		));


		TemplateTask::create(array(
			'template_id' => '5',
			'section' => 'Contract',
			'content' => 'Contract Returned and signed.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '5',
			'section' => 'Contract',
			'content' => 'Deposit received.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '5',
			'section' => 'Domain Setup',
			'content' => 'Set up "m." A record.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '5',
			'section' => 'Domain Setup',
			'content' => 'Set up "m." alias.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '5',
			'section' => 'Domain Setup',
			'content' => 'Pass to Brad so he can verify site is setup correctly.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '5',
			'section' => 'Design',
			'content' => 'Verify mobile theme is add to theme directory.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '5',
			'section' => 'Design',
			'content' => 'Activate mobile plugin.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '5',
			'section' => 'Design',
			'content' => 'Setup mobile specific options.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '5',
			'section' => 'Testing',
			'content' => 'Test site on appropriate mobile sites.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '5',
			'section' => 'Post-Launch',
			'content' => 'Optimize mobile site for client.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '5',
			'section' => 'Post-Launch',
			'content' => 'Send client email with finished mobile website.',
			'created_at' => '2014-06-24 08:00:00',
		));

		
		TemplateTask::create(array(
			'template_id' => '6',
			'section' => 'Production',
			'content' => 'Delete domain in Email Control Panel.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '6',
			'section' => 'Production',
			'content' => 'Update P2 & Highrise Accounts & Contracts.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '6',
			'section' => 'Server',
			'content' => 'Back up web files.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '6',
			'section' => 'Server',
			'content' => 'Back up database(s).',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '6',
			'section' => 'Server',
			'content' => 'Copy web files and database(s) to fileshare server.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '6',
			'section' => 'Server',
			'content' => 'Move website to archive folder.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '6',
			'section' => 'Server',
			'content' => 'Delete DNS entry.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '6',
			'section' => 'Server',
			'content' => 'Delete domain from Virtualmin.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '6',
			'section' => 'Server',
			'content' => 'Delete domain from WebTools.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '6',
			'section' => 'Server',
			'content' => 'Delete entry from 1Password.',
			'created_at' => '2014-06-24 08:00:00',
		));

		TemplateTask::create(array(
			'template_id' => '7',
			'section' => 'Section1',
			'content' => 'Inactive.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '7',
			'section' => 'Section2',
			'content' => 'Inactive.',
			'created_at' => '2014-06-24 08:00:00',
		));
		TemplateTask::create(array(
			'template_id' => '7',
			'section' => 'Section3',
			'content' => 'Inactive.',
			'created_at' => '2014-06-24 08:00:00',
		));

	}
}