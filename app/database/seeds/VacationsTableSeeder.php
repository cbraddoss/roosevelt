<?php

class VacationsTableSeeder extends Seeder {

	public function run()
	{
		Vacation::truncate();

		Vacation::create(array(
			'user_id' => '1',
			'start_date' => '2014-04-23 08:00:00',
			'end_date' => '2014-04-25 08:00:00',
			'total_hours' => '40',
		));

		Vacation::create(array(
			'user_id' => '2',
			'start_date' => '2014-03-28 08:00:00',
			'end_date' => '2014-04-04 08:00:00',
			'total_hours' => '40',
		));

		Vacation::create(array(
			'user_id' => '3',
			'start_date' => '2014-04-25 08:00:00',
			'end_date' => '2014-05-05 08:00:00',
			'total_hours' => '40',
		));

		Vacation::create(array(
			'user_id' => '1',
			'start_date' => '2014-04-21 08:00:00',
			'end_date' => '2014-04-21 08:00:00',
			'total_hours' => '40',
		));

		Vacation::create(array(
			'user_id' => '3',
			'start_date' => '2014-03-28 08:00:00',
			'end_date' => '2014-03-30 08:00:00',
			'total_hours' => '40',
		));

		Vacation::create(array(
			'user_id' => '4',
			'start_date' => '2014-05-02 08:00:00',
			'end_date' => '2014-05-05 08:00:00',
			'total_hours' => '40',
		));

	}
}