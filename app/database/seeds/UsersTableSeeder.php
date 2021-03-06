<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		User::truncate();

		User::create(array(
			'email' => 'brad@insideout.com',
			'password' => Hash::make('12345678'),
			'userrole' => 'admin',
			'first_name' => 'Brad',
			'last_name' => 'Doss',
			'anniversary' => '2009-10-09 00:00:00',
			'extension' => '312',
			'cell_phone' => '360-808-2877',
			'status' => 'active',
			'can_manage' => 'yes',
			'user_path' => 'brad-doss'
		));

		User::create(array(
			'email' => 'jack@insideout.com',
			'password' => Hash::make('12345678'),
			'userrole' => 'admin',
			'first_name' => 'Jack',
			'last_name' => 'Waknitz',
			'anniversary' => '2006-09-05 00:00:00',
			'extension' => '308',
			'status' => 'active',
			'can_manage' => 'yes',
			'user_path' => 'jack-waknitz'
		));

		User::create(array(
			'email' => 'taylor@insideout.com',
			'password' => Hash::make('12345678'),
			'userrole' => 'admin',
			'first_name' => 'Taylor',
			'last_name' => 'Hasenpflug',
			'anniversary' => '0000-00-00 00:00:00',
			'extension' => '313,315',
			'status' => 'active',
			'can_manage' => 'yes',
			'user_path' => 'taylor-hasenpflug'
		));

		User::create(array(
			'email' => 'josh@insideout.com',
			'password' => Hash::make('12345678'),
			'userrole' => 'standard',
			'first_name' => 'Josh',
			'last_name' => 'Wise',
			'anniversary' => '2014-08-01 00:00:00',
			'extension' => '311',
			'status' => 'active',
			'can_manage' => 'no',
			'user_path' => 'josh-wise'
		));

		User::create(array(
			'email' => 'shawn@insideout.com',
			'password' => Hash::make('12345678'),
			'userrole' => 'admin',
			'first_name' => 'Shawn',
			'last_name' => 'Kerr',
			'anniversary' => '2008-10-13 00:00:00',
			'extension' => '307',
			'status' => 'active',
			'can_manage' => 'no',
			'user_path' => 'shawn-kerr'
		));

		User::create(array(
			'email' => 'corey@insideout.com',
			'password' => Hash::make('12345678'),
			'userrole' => 'standard',
			'first_name' => 'Corey',
			'last_name' => 'Edwards',
			'anniversary' => '2014-05-21 00:00:00',
			'extension' => '316',
			'status' => 'active',
			'can_manage' => 'no',
			'user_path' => 'corey-edwards'
		));

		User::create(array(
			'email' => 'devteam@insideout.com',
			'password' => Hash::make('12345678'),
			'userrole' => 'standard',
			'first_name' => 'User',
			'last_name' => 'One',
			'anniversary' => '2013-04-15 00:00:00',
			'status' => 'active',
			'can_manage' => 'yes',
			'user_path' => 'user-one'
		));

		User::create(array(
			'email' => 'sysadmin@insideout.com',
			'password' => Hash::make('12345678'),
			'userrole' => 'standard',
			'first_name' => 'User',
			'last_name' => 'Two',
			'anniversary' => '2013-05-01 00:00:00',
			'status' => 'inactive',
			'user_path' => 'user-two'
		));



		User::create(array(
			'email' => 'servers@insideout.com',
			'password' => Hash::make('12345678'),
			'userrole' => 'non-standard',
			'first_name' => 'User',
			'last_name' => 'Three',
			'anniversary' => '2013-05-15 00:00:00',
			'status' => 'active',
			'user_path' => 'user-three'
		));
	}
}