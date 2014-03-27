<?php

class AdminController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Auth::user();
		if($user->userrole == 'admin') {
			$users = User::all();
			if(Request::ajax()) return View::make('admin.partials.user-list-form', compact('user','users'));
			else return View::make('admin.index', compact('user','users'));
		}
		else return Redirect::route('dashboard');
	}

	public function userToUpdate() {
		if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
                'msg' => 'Request not valid.'
            ) );
        }
        if(Input::get('confirm-update') == 'yes') {
			
			$userToUpdate = User::find(Input::get('id'));
			$userToUpdate->first_name =  Input::get('first_name');
			$userToUpdate->last_name =  Input::get('last_name');
			$userToUpdate->email =  Input::get('email');
			if(Input::get('password') != '') $userToUpdate->password =  Hash::make(Input::get('password'));
			$userToUpdate->userrole =  Input::get('userrole');
			$userToUpdate->extension =  Input::get('extension');
			$userToUpdate->cell_phone =  Input::get('cell_phone');
			$userToUpdate->status =  Input::get('status');
			$userToUpdate->save();
			
			$response = array(
				'id' => Input::get('id'),
				'first_name' => Input::get('first_name'),
				'last_name' => Input::get('last_name'),
				'email' => Input::get('email'),
				'userrole' => Input::get('userrole'),
				'extension' => Input::get('extension'),
				'cell_phone' => Input::get('cell_phone'),
				'status' => Input::get('status'),
	            'msg' => 'successfully updated.',
	        );
		}
		elseif(Input::get('confirm-delete') == 'yes') {

			$response = array(
				'first_name' => Input::get('first_name'),
				'last_name' => Input::get('last_name'),
				'msg' => 'successfully deleted.'
			);

			$userToDelete = User::find(Input::get('id'));
			$userToDelete->delete();
		}
		elseif(Input::get('confirm-add') == 'yes') {
			$findUserMaybe = User::where('email', '=', Input::get('email'))->first();
			$newUserEmail = Input::get('email');
			$newUserPassword = Input::get('password');
			$newUserFirst = Input::get('first_name');
			$newUserLast = Input::get('last_name');
			
			if(empty($newUserFirst) || empty($newUserLast)) {
				$response = array(
					'errorMsg' => 'Name fields are required. Please try again.'
				);
			}
			elseif($newUserEmail == '') {
				$response = array(
					'errorMsg' => 'Email address required. Please try again.'
				);
			}
			elseif(!empty($findUserMaybe->email)) {
				
				$response = array(
					'errorMsg' => 'Email address exists. Please use another email address.'
				);
			}
			elseif(empty($newUserPassword)) {
				
				$response = array(
					'errorMsg' => 'User must have a password.'
				);
			}
			else {
				$newUser = new User;
				
				$newUser->first_name = Input::get('first_name');
				$newUser->last_name = Input::get('last_name');
				$newUser->email = Input::get('email');
				$newUser->password = Hash::make(Input::get('password'));
				$newUser->userrole = Input::get('userrole');
				$newUser->extension = Input::get('extension');
				$newUser->status = 'active';

				$newUser->save();

				$newUserSend = User::where('email', '=', Input::get('email'))->first();


				$response = array(
					'id' => $newUserSend->id,
					'first_name' => $newUserSend->first_name,
					'last_name' => $newUserSend->last_name,
					'email' => $newUserSend->email,
					'userrole' => $newUserSend->userrole,
					'extension' => $newUserSend->extension,
					'cell_phone' => $newUserSend->cell_phone,
					'status' => $newUserSend->status,
					'msg' => 'successfully added.'
				);
			}
		}
		else {
			$response = array(
				'msg' => 'why am i here?'
			);
		}
 
        return Response::json( $response );
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