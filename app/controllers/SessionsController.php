<?php

class SessionsController extends \BaseController {

	/**
     * Instantiate a new AdminController instance.
     */
	public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function index()
    {
    	return Redirect::route('login');
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//check if user is not logged in, redirect back to login page
		if(Auth::guest()) {
			$ipAddress = $_SERVER['REMOTE_ADDR'];
			$loginLimit = LoginLimit::where('ip_address','=', $ipAddress)->first();
			if( !empty($loginLimit) && ($loginLimit->attempts >= 5) && (Carbon::createFromFormat('Y-m-d H:i:s', $loginLimit->failed_at) > Carbon::now()->subMinutes(30)) ) return View::make('sessions.timeout');
			
			return View::make('sessions.login');
		}
		// Redirect to Dashboard.
		else return Redirect::intended('/');
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
		$flashMessage = '<span>Username or Password incorrect.</span>';
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$authorize = Auth::attempt( array('email' => $email, 'password' => $password, 'status' => 'active') );
		if( $authorize ) {
			$user = Auth::user();
			$user->last_login = new \DateTime;
			$user->ip_address = $ipAddress;
			$user->save();
			$loginLimit = LoginLimit::where('ip_address','=', $ipAddress)->first();
			if(!empty($loginLimit)) {
				$loginLimit->attempts = 0;
				$loginLimit->save();
			}
			return Redirect::intended('/');
		}
		else {
			$loginFailed = LoginLimit::where('ip_address','=', $ipAddress)->first();
			if(!empty($loginFailed)) {
				if(!strpos($email, 'insideout.com')) {
					$loginFailed->attempts = 5;
					$loginFailed->failed_at = new \DateTime;
					$loginFailed->save();					
					return View::make('sessions.timeout');
				}
				if(Carbon::createFromFormat('Y-m-d H:i:s', $loginFailed->failed_at) < Carbon::now()->subMinutes(30)) {
					$loginFailed->attempts = 0;
					$loginFailed->save();
				}
				$loginFailed->attempts = $loginFailed->attempts + 1;
				$loginFailed->failed_at = new \DateTime;
				$loginFailed->save();
				$attemptsRemaining = 5 - $loginFailed->attempts;
				if($attemptsRemaining <= 3) $flashMessage = $flashMessage.'<br /><span>Attempts remaining: '.$attemptsRemaining.'</span>';
				return Redirect::back()->withInput()->with('flash_message',$flashMessage);
			}
			else {
				$loginLimit = new LoginLimit;
				$loginLimit->attempts = 1;
				$loginLimit->ip_address = $ipAddress;
				$loginLimit->failed_at = new \DateTime;
				$loginLimit->save();
				if(!strpos($email, 'insideout.com')) {
					$loginLimit->attempts = 5;
					$loginLimit->failed_at = new \DateTime;
					$loginLimit->save();					
					return View::make('sessions.timeout');
				}
			}
		}
		return Redirect::back()->withInput()->with('flash_message',$flashMessage);
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