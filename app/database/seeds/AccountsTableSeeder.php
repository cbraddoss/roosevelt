<?php

class AccountsTableSeeder extends Seeder {

	public function run()
	{
		Account::truncate();

		Account::create(array(
			'name' => 'Sample Inn',
			'status' => 'active',
			'slug' => 'sample-inn',
			'email' => 'sample@sampleinn.com',
			'website' => 'sampleinn.com',
			'author_id' => '3',
			'past_due' => 'no',
			'address' => '123 Sample Lane',
			'city' => 'Sample',
			'state' => 'WA',
			'zip' => '12345',
			'phone_number' => '123-456-7890',
			'client_type' => 'hosting',
			'site_designed' => 'yes',
			'hosting_type' => 'Standard Yearly ($400 yr)',
			'hosting_addons' => 'WordPress',
		));

		Account::create(array(
			'name' => 'Another B&B',
			'status' => 'active',
			'slug' => 'another-b-b',
			'email' => 'another@anotherbb.com',
			'website' => 'anotherbb.com',
			'author_id' => '2',
			'past_due' => 'no',
			'address' => '123 Another Street',
			'city' => 'Another',
			'state' => 'WA',
			'zip' => '45234',
			'phone_number' => '123-456-7890',
			'client_type' => 'hosting, promo',
			'site_designed' => 'no',
			'hosting_type' => 'Standard Monthly ($40 yr)',
			'hosting_addons' => 'Easyedit',
		));

		Account::create(array(
			'name' => 'The Best BnB',
			'status' => 'active',
			'slug' => 'the-best-bnb',
			'email' => 'thebest@thebestbb.com',
			'website' => 'thebestbb.com',
			'author_id' => '1',
			'past_due' => 'no',
			'address' => '123 Best Drive',
			'city' => 'Best',
			'state' => 'AR',
			'zip' => '77889',
			'phone_number' => '555-456-1231',
			'client_type' => 'hosting',
			'site_designed' => 'yes',
			'hosting_type' => 'Elite ($375 mo)',
			'hosting_addons' => 'WordPress',
		));

		Account::create(array(
			'name' => 'The Worst Inn',
			'status' => 'inactive',
			'slug' => 'the-worst-inn',
			'email' => 'worst@worstinn.com',
			'website' => 'worstinn.com',
			'author_id' => '4',
			'past_due' => 'yes',
			'address' => '123 Worst Circle',
			'city' => 'Worst',
			'state' => 'TX',
			'zip' => '34234',
			'phone_number' => '123-456-7890',
			'client_type' => 'hosting',
			'site_designed' => 'no',
			'hosting_type' => 'Legacy Yearly ($300 yr)',
			'hosting_addons' => 'None',
		));
	}
}