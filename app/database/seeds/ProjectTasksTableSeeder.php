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
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Layout Proof',
			'content' => 'Project Manager email pre-productions questionnaire for needed info.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Layout Proof',
			'content' => 'Website layout proof approved by client. Ping @shawn',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Layout Proof',
			'content' => 'Clean up PSD for coding and supply any additional instructions or details to coder',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Code Website',
			'content' => 'Import existing blog',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Code Website',
			'content' => 'Setup one-image slideshow to verify functionality and give image an appropriate alt tag.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Code Website',
			'content' => 'Verify wide and narrow column appearances.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Code Website',
			'content' => 'Verify Sitemap page.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Pre-Launch',
			'content' => 'Update TTL to 5 minutes',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Pre-Launch',
			'content' => 'Migrate latest blog posts from current blog.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Launch',
			'content' => 'Turn off privacy.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Launch',
			'content' => 'In DNS, update A record for domain IP.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Clean Up',
			'content' => 'Export previous site databases and files and delete from previous server (if IOS hosted).',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '1',
			'section' => 'Clean Up',
			'content' => 'Save old website to Dropbox.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));

		ProjectTask::create(array(
			'project_id' => '2',
			'section' => 'Pre-Production',
			'content' => 'Attach contract or agreement to project.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '2',
			'section' => 'Setup',
			'content' => 'Setup temporary site for new responsive website.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '2',
			'section' => 'Setup',
			'content' => 'Verify default WP plugins installed for new responsive website.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '2',
			'section' => 'Setup',
			'content' => 'Update TTL for A record in preparation of launch.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '2',
			'section' => 'Code Website',
			'content' => 'Convert website to responsive.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '2',
			'section' => 'Code Website',
			'content' => 'Check website in all sizes and all browsers.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '2',
			'section' => 'Code Website',
			'content' => 'Run website thru appropriate pagespeed and error checking services.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '2',
			'section' => 'Pre-Launch',
			'content' => 'Do pre-launch stuff.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '2',
			'section' => 'Pre-Launch',
			'content' => 'Do more pre-launch stuff.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '2',
			'section' => 'Launch',
			'content' => 'Launch website.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '2',
			'section' => 'Clean Up',
			'content' => 'Do clean up stuff.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));


		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Pre-Production',
			'content' => 'Project Manager email pre-productions questionnaire for needed info.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Layout Proof',
			'content' => 'Project Manager email pre-productions questionnaire for needed info.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Layout Proof',
			'content' => 'Website layout proof approved by client. Ping @shawn',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Layout Proof',
			'content' => 'Clean up PSD for coding and supply any additional instructions or details to coder',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Code Website',
			'content' => 'Import existing blog',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Code Website',
			'content' => 'Setup one-image slideshow to verify functionality and give image an appropriate alt tag.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Code Website',
			'content' => 'Verify wide and narrow column appearances.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Code Website',
			'content' => 'Verify Sitemap page.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Pre-Launch',
			'content' => 'Update TTL to 5 minutes',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Pre-Launch',
			'content' => 'Migrate latest blog posts from current blog.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Launch',
			'content' => 'Turn off privacy.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Launch',
			'content' => 'In DNS, update A record for domain IP.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Clean Up',
			'content' => 'Export previous site databases and files and delete from previous server (if IOS hosted).',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '3',
			'section' => 'Clean Up',
			'content' => 'Save old website to Dropbox.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		

		ProjectTask::create(array(
			'project_id' => '4',
			'section' => 'Tune-Up',
			'content' => 'Welcome & questionnaire.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '4',
			'section' => 'Tune-Up',
			'content' => 'sitemap.xml: create or optimize.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '4',
			'section' => 'Tune-Up',
			'content' => 'robots.txt: add sitemap URL and disallow any content that shouldn\'t be indexed.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '4',
			'section' => 'Tune-Up',
			'content' => 'favicon.ico: add if not already present.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '4',
			'section' => 'Tune-Up',
			'content' => 'sitemap.xml: create or optimize.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));


		ProjectTask::create(array(
			'project_id' => '5',
			'section' => 'Contract',
			'content' => 'Contract Returned and signed.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '5',
			'section' => 'Contract',
			'content' => 'Deposit received.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '5',
			'section' => 'Domain Setup',
			'content' => 'Set up "m." A record.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '5',
			'section' => 'Domain Setup',
			'content' => 'Set up "m." alias.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '5',
			'section' => 'Domain Setup',
			'content' => 'Pass to Brad so he can verify site is setup correctly.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '5',
			'section' => 'Design',
			'content' => 'Verify mobile theme is add to theme directory.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '5',
			'section' => 'Design',
			'content' => 'Activate mobile plugin.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '5',
			'section' => 'Design',
			'content' => 'Setup mobile specific options.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '5',
			'section' => 'Testing',
			'content' => 'Test site on appropriate mobile sites.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '5',
			'section' => 'Post-Launch',
			'content' => 'Optimize mobile site for client.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '5',
			'section' => 'Post-Launch',
			'content' => 'Send client email with finished mobile website.',
			'checkbox' => 'open',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));

		
		ProjectTask::create(array(
			'project_id' => '6',
			'section' => 'Contract',
			'content' => 'Contract Returned and signed.',
			'checkbox' => 'closed',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '6',
			'section' => 'Contract',
			'content' => 'Deposit received.',
			'checkbox' => 'closed',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '6',
			'section' => 'Domain Setup',
			'content' => 'Set up "m." A record.',
			'checkbox' => 'closed',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '6',
			'section' => 'Domain Setup',
			'content' => 'Set up "m." alias.',
			'checkbox' => 'closed',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '6',
			'section' => 'Domain Setup',
			'content' => 'Pass to Brad so he can verify site is setup correctly.',
			'checkbox' => 'closed',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '6',
			'section' => 'Design',
			'content' => 'Verify mobile theme is add to theme directory.',
			'checkbox' => 'closed',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '6',
			'section' => 'Design',
			'content' => 'Activate mobile plugin.',
			'checkbox' => 'closed',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '6',
			'section' => 'Design',
			'content' => 'Setup mobile specific options.',
			'checkbox' => 'closed',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '6',
			'section' => 'Testing',
			'content' => 'Test site on appropriate mobile sites.',
			'checkbox' => 'closed',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '6',
			'section' => 'Post-Launch',
			'content' => 'Optimize mobile site for client.',
			'checkbox' => 'closed',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
		ProjectTask::create(array(
			'project_id' => '6',
			'section' => 'Post-Launch',
			'content' => 'Send client email with finished mobile website.',
			'checkbox' => 'closed',
			'notes' => 'active-task',
			'created_at' => '2014-06-24 08:00:00',
		));
	}
}