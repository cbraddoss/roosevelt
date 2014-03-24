<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		User::truncate();

		User::create([
			'username' => 'brad',
			'password' => Hash::make('1234'),
			'userrole' => 'admin',
			'email' => 'brad@insideout.com',
			'first_name' => 'Brad',
			'last_name' => 'Doss',
			'extension' => '312',
			'cell_phone' => '360-808-2877',
			'active' => '1'
		]);

		User::create([
			'username' => 'jack',
			'password' => Hash::make('1234'),
			'userrole' => 'admin',
			'email' => 'jack@insideout.com',
			'first_name' => 'Jack',
			'last_name' => 'Waknitz',
			'extension' => '308',
			'active' => '1'
		]);

		User::create([
			'username' => 'taylor',
			'password' => Hash::make('1234'),
			'userrole' => 'admin',
			'email' => 'taylor@insideout.com',
			'first_name' => 'Taylor',
			'last_name' => 'Hasenpflug',
			'extension' => '313,315',
			'active' => '1'
		]);

		User::create([
			'username' => 'standard',
			'password' => Hash::make('1234'),
			'userrole' => 'standard',
			'email' => 'sysadmin@insideout.com',
			'first_name' => 'TestAccount',
			'last_name' => 'Active',
			'active' => '1'
		]);

		User::create([
			'username' => 'standardna',
			'password' => Hash::make('1234'),
			'userrole' => 'standard',
			'email' => 'servers@insideout.com',
			'first_name' => 'TestAccount',
			'last_name' => 'NotActive',
			'active' => '0'
		]);
	}
}