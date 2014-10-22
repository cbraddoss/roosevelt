<?php

use \Vaults;

class VaultController extends \BaseController {

	/**
     * Instantiate a new ProjectsController instance.
     */
    public function __construct(Vault $vault)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

		$this->vault = $vault;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$vaults = $this->vault->getAllVaults();
		$vaultsCount = $vaults->count();
		if(Request::ajax()) return View::make('assets.partials.new-vault-asset');
		else return View::make('assets.vault',compact('vaults','vaultsCount'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//$encrypted = Crypt::encrypt('secret');
		//$decrypted = Crypt::decrypt($encryptedValue);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
