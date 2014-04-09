<?php

class UsersController extends \BaseController {

	/**
     * Instantiate a new UsersController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//if(Request::ajax()) return View::make('profile.partials.profile-update-form');
		//else return View::make('profile.index');
		//if(Auth::guest()) return View::make('sessions.login');
		return View::make('profile.index');
	}

	public function postIndex($id = null, $token = null) {
		if (is_null($token)) 'You can\'t do that.';//App::abort(404);

		$user = Input::only(
			'first_name','last_name', 'extension', 'cell_phone', 'password', 'password_again', 'token'
		);
		dd(User::find($id));
		if( ! $user->save() ) return 'oops';
		else return 'yay';

		// $response = Password::reset($credentials, function($user, $password)
		// {
		// 	$user->password = Hash::make($password);

		// 	$user->save();
		// });

		// switch ($response)
		// {
		// 	case Password::INVALID_PASSWORD:
		// 	case Password::INVALID_TOKEN:
		// 	case Password::INVALID_USER:
		// 		return Redirect::back()->with('error', Lang::get($response));

		// 	case Password::PASSWORD_RESET:
		// 		return Redirect::to('/');
		// }

		return View::make('profile.index');
	}

	public function postUpdate() {
		
		// $credentials = Input::only(
		// 	'email', 'password', 'password_confirmation', 'token'
		// );

		// $response = Password::reset($credentials, function($user, $password)
		// {
		// 	$user->password = Hash::make($password);

		// 	$user->save();
		// });

		// switch ($response)
		// {
		// 	case Password::INVALID_PASSWORD:
		// 	case Password::INVALID_TOKEN:
		// 	case Password::INVALID_USER:
		// 		return Redirect::back()->with('error', Lang::get($response));

		// 	case Password::PASSWORD_RESET:
		// 		return Redirect::to('/');
		// }

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
		// PUT request to /profile
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//	GET /profile/user
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		
		return View::make('profile.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		// PUT/PATCH /profile/user
        if(Input::get('confirm-profile-update') == 'yes') {
			
			$validator = Validator::make(Input::all(), array(
				'id' => 'same:id',
				'password' => 'between:8,30',
				'password_again' => 'required_with:password|same:password',
				'first_name' => 'required|max:40|alpha',
				'last_name' => 'required|max:40|alpha',
				'extension' => 'between:3,12|regex:/^([0-9,])+$/i',
				'cell_phone' => 'size:12|regex:/^([0-9-])+$/i',
			));
			
			if($validator->fails()) {
				$messages = $validator->messages();
				$response = array(
					'errorMsg' => $messages->first()
				);
			} else {
				$userToUpdate = User::find(Input::get('id'));
				$userToUpdate->first_name =  Input::get('first_name');
				$userToUpdate->last_name =  Input::get('last_name');
				if(Input::get('password') != '') $userToUpdate->password =  Hash::make(Input::get('password'));
				$userToUpdate->extension =  Input::get('extension');
				$userToUpdate->cell_phone =  Input::get('cell_phone');
				$userToUpdate->save();
				
				$response = array(
					'id' => Input::get('id'),
					'first_name' => Input::get('first_name'),
					'last_name' => Input::get('last_name'),
					'extension' => Input::get('extension'),
					'cell_phone' => Input::get('cell_phone'),
		            'msg' => 'successfully updated.',
		        );
			}
		}
        else {
			$response = array(
				'errorMsg' => 'Something went wrong. Please contact a devteam member.'
			);
		}
 
        return Response::json( $response );
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