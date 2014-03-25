<?php

class SessionsController extends \BaseController {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//check if user is not logged in, redirect back to login page
		if(Auth::guest()) return View::make('sessions.login');
		
		// Redirect to Dashboard.
		//Todo: redirect to intended() url
		else return Redirect::route('dashboard');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$email = Input::get('email');
		$password = Input::get('password');

		$authorize = Auth::attempt( array('email' => $email, 'password' => $password, 'status' => 'active') );
		if( $authorize )
		{
			return Redirect::route('dashboard');
		}
		else
		{
			return Redirect::back()->withInput()->with('flash_message','Password incorrect or email not registered.');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();

		return Redirect::route('login');
	}

}