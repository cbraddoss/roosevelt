<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($usersname)
	{
		$name = lcfirst(Auth::user()->first_name) . '-' . lcfirst(Auth::user()->last_name);
		if(Request::ajax()) return View::make('profile.partials.profile-update-form');
		elseif($name == $usersname)	return View::make('profile.index');
		else return Redirect::route('dashboard');
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
	public function update()
	{
		if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
                'errorMsg' => 'Request not valid.'
            ) );
        }
        if(Input::get('confirm-profile-update') == 'yes') {
			
			$validator = Validator::make(Input::all(), array(
				'id' => 'same:id',
				'password' => 'between:8,30',
				'password_again' => 'required_with:password|same:password',
				'first_name' => 'required|max:40',
				'last_name' => 'required|max:40',
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