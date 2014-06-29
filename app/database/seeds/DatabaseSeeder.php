<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UsersTableSeeder');
		$this->call('ArticlesTableSeeder');
		$this->call('AccountsTableSeeder');
		$this->call('VacationsTableSeeder');
		$this->call('ProjectsTableSeeder');
		$this->call('ProjectTasksTableSeeder');
		$this->call('TemplatesTableSeeder');
		$this->call('TemplateTasksTableSeeder');
	}

}