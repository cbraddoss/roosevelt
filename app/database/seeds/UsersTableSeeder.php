<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		User::truncate();

		User::create(array(
			'email' => 'brad@insideout.com',
			'password' => Hash::make('1234'),
			'userrole' => 'admin',
			'first_name' => 'Brad',
			'last_name' => 'Doss',
			'extension' => '312',
			'cell_phone' => '360-808-2877',
			'active' => 1
		));

		User::create(array(
			'email' => 'jack@insideout.com',
			'password' => Hash::make('1234'),
			'userrole' => 'admin',
			'first_name' => 'Jack',
			'last_name' => 'Waknitz',
			'extension' => '308',
			'active' => 1
		));

		User::create(array(
			'email' => 'taylor@insideout.com',
			'password' => Hash::make('1234'),
			'userrole' => 'admin',
			'first_name' => 'Taylor',
			'last_name' => 'Hasenpflug',
			'extension' => '313,315',
			'active' => 1
		));

		User::create(array(
			'email' => 'devteam@insideout.com',
			'password' => Hash::make('1234'),
			'userrole' => 'standard',
			'first_name' => 'TestAccount',
			'last_name' => 'Active',
			'active' => 1
		));

		User::create(array(
			'email' => 'sysadmin@insideout.com',
			'password' => Hash::make('1234'),
			'userrole' => 'standard',
			'first_name' => 'TestAccount',
			'last_name' => 'NotActive',
			'active' => 0
		));
	}
}