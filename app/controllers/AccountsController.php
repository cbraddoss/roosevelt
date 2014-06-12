<?php

use \Account;

class AccountsController extends \BaseController {

	/**
     * Instantiate a new AccountsController instance.
     */
	public function __construct(Account $account)
	{
		$this->beforeFilter('auth');

		$this->beforeFilter('csrf', array('on' => 'post'));

        $this->account = $account;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('accounts.index')->withAccounts(Account::all());
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function search($title) {
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/projects')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
		$accounts = $this->account->getAccountsSearch($title);
		$accountsSearched = '';
		foreach($accounts as $account) {
			$accountsSearched .= '<span value="'.$account->id.'">' . $account->name . '</span>';
		}
		if($accountsSearched != '') {
			$response = array(
				'accounts' => $accountsSearched,
				'msg' => 'found some'
			);
			return Response::json( $response );
		}
		else {
			$response = array(
				'msg' => 'none'
			);
			return Response::json($response);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('accounts.new');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($accountname)
	{
        $a = Account::where('link', '=', $accountname)->get()->first();
		return View::make('accounts.profile')->withAccount($a);
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