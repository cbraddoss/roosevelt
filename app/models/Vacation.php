<?php

class Vacation extends Eloquent {

	protected $fillable = array('start_date','end_date');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'vacations';
	
	public function get_upcoming($user) {
		$vacations = Vacation::where('user_id', '=', $user)
					 ->where('start_date', '>=', Carbon::now())
					 ->get();
		return $vacations;
	}

	public function get_previous($user) {
		$vacations = Vacation::where('user_id', '=', $user)
					 ->where('start_date', '<', Carbon::now())
					 ->get();
		return $vacations;
	}
}