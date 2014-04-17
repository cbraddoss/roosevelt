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
			'status' => 'active',
			'user_path' => 'brad-doss'
		));

		User::create(array(
			'email' => 'jack@insideout.com',
			'password' => Hash::make('1234'),
			'userrole' => 'admin',
			'first_name' => 'Jack',
			'last_name' => 'Waknitz',
			'extension' => '308',
			'status' => 'active',
			'user_path' => 'jack-waknitz'
		));

		User::create(array(
			'email' => 'taylor@insideout.com',
			'password' => Hash::make('1234'),
			'userrole' => 'admin',
			'first_name' => 'Taylor',
			'last_name' => 'Hasenpflug',
			'extension' => '313,315',
			'status' => 'active',
			'user_path' => 'taylor-hasenpflug'
		));

		User::create(array(
			'email' => 'devteam@insideout.com',
			'password' => Hash::make('1234'),
			'userrole' => 'standard',
			'first_name' => 'User',
			'last_name' => 'One',
			'status' => 'active',
			'user_path' => 'user-one'
		));

		User::create(array(
			'email' => 'sysadmin@insideout.com',
			'password' => Hash::make('1234'),
			'userrole' => 'standard',
			'first_name' => 'User',
			'last_name' => 'Two',
			'status' => 'inactive',
			'user_path' => 'user-two'
		));



		User::create(array(
			'email' => 'servers@insideout.com',
			'password' => Hash::make('1234'),
			'userrole' => 'non-standard',
			'first_name' => 'User',
			'last_name' => 'Three',
			'status' => 'active',
			'user_path' => 'user-three'
		));
	}
}