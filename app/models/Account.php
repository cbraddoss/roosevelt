<?php

class Account extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'accounts';

	public function getAccountsSearch($search) {
		$accounts = Account::where('name','like','%'.$search.'%')
				   ->where('status','=','active')
				   ->orderBy('name','ASC')
				   ->get();

		return $accounts;
	}
}