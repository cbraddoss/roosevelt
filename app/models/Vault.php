<?php

class Vault extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'vaults';

	/**
	 * Get all vaults from the system
	 *
	 * @return object
	 */
	public function getAllVaults()
	{
		$vaults = Vault::all();

		return $vaults;
	}
}