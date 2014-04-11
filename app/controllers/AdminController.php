<?php

class AdminController extends \BaseController {

	/**
     * Instantiate a new AdminController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('admin');

        $this->beforeFilter('csrf', array('on' => 'post'));
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function users()
	{
		$users = User::all();
		if(Request::ajax()) return View::make('admin.partials.user-add-new');
		else return View::make('admin.partials.users-list', compact('users'));
	}

	public function userEdit($userpath) {
		$user = User::where('user_path', $userpath)->first();
		return View::make('admin.partials.user-form', compact('user'));
	}

	public function userUpdate($userpath) {
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/admin/users/'.$userpath)->withInput()->with('flash_message_error','Form submission error. Please don\'t do that.');
        
		$validator = Validator::make(Input::all(), array(
			'id' => 'same:id',
			'first_name' => 'required|max:40|alpha',
			'last_name' => 'required|max:40|alpha',
			'extension' => 'between:3,12|regex:/^([0-9,])+$/i',
			'cell_phone' => 'size:12|regex:/^([0-9-])+$/i',
			'password' => 'between:8,30',
			'password_again' => 'required_with:password|same:password',
		));
		
		if($validator->fails()) {
			$messages = $validator->messages();
			return Redirect::to('/admin/users/'.$userpath)->withInput()->withErrors($messages);
		}
		else {
			$user = User::find(Input::get('id'));
			$user->first_name =  ucwords(Input::get('first_name'));
			$user->last_name =  ucwords(Input::get('last_name'));
			if(Input::get('password') != '') $user->password =  Hash::make(Input::get('password'));
			$user->user_path = lcfirst(Input::get('first_name')) . '-' . lcfirst(Input::get('last_name'));
			$user->extension =  Input::get('extension');
			$user->cell_phone =  Input::get('cell_phone');
			$user->status =  Input::get('status');
			$user->userrole =  Input::get('userrole');
			try
			{
				$user->save();
			} catch(Illuminate\Database\QueryException $e)
			{
					return Redirect::to('/admin/users/'.$user->user_path)->withInput()->with('flash_message_error','Oops, something went wrong. Please try again.');
			}
			return Redirect::to('/admin/users/')->with('flash_message_success',$user->first_name . ' ' . $user->last_name .' successfully updated!');
		}

		return Redirect::to('/admin/users/'.$user->user_path)->with('flash_message_error','Something went wrong. :(');
	}

	// public function userNew() {
	// 	if ( Session::token() !== Input::get( '_token' ) ) {
 //            return Response::json( array(
 //                'msg' => 'Request not valid.'
 //            ) );
 //        }
 //        $validator = Validator::make(Input::all(), array(
	// 			'first_name' => 'required|max:40|alpha',
	// 			'last_name' => 'required|max:40|alpha',
	// 			'email' => array('unique:users', 'required', 'max:40', 'email', 'regex:/^(.*?)+(@)+(insideout.com)/i'),
	// 			'password' => 'required|between:8,30',
	// 			'extension' => 'between:3,12|regex:/^([0-9,])+$/i'
	// 		));
	// }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function templates()
	{
		$users = User::all();
		if(Request::ajax()) return View::make('admin.partials.templates-form', compact('users'));
		else return View::make('admin.templates', compact('users'));
	}

	// public function userToUpdate() {
	// 	if ( Session::token() !== Input::get( '_token' ) ) {
 //            return Response::json( array(
 //                'msg' => 'Request not valid.'
 //            ) );
 //        }
 //        if(Input::get('confirm-update') == 'yes') {
			
	// 		$validator = Validator::make(Input::all(), array(
	// 			'id' => 'same:id',
	// 			'password' => 'between:8,30',
	// 			'email' => array('required', 'max:40', 'email', 'regex:/^(.*?)+(@)+(insideout.com)/i'),
	// 			'first_name' => 'required|max:40|alpha',
	// 			'last_name' => 'required|max:40|alpha',
	// 			'extension' => 'between:3,12|regex:/^([0-9,])+$/i',
	// 			'cell_phone' => 'size:12|regex:/^([0-9-])+$/i',
	// 		));
			
	// 		if($validator->fails()) {
	// 			$messages = $validator->messages();
	// 			$response = array(
	// 				'errorMsg' => $messages->first()
	// 			);
	// 		} 
	// 		else {
	// 			$userPath = lcfirst(Input::get('first_name')) . '-' . lcfirst(Input::get('last_name'));
	// 			$usersCheck = User::where('user_path','like','%'.$userPath.'%')->get();
	// 			$error = '';
	// 			if(!$usersCheck->isEmpty()) {
	// 				foreach($usersCheck as $userCheck) {
	// 					$pathCheck[] = $userCheck->user_path;
	// 				}
	// 				rsort($pathCheck);
	// 				//dd($pathCheck);
	// 				$pathCheck = $pathCheck[0];

	// 				if(preg_match('/(?<fName>\w+)-(?<lName>\w+)-(?<digit>\d+)/', $pathCheck, $pathMatch)) {
	// 					if($pathMatch['digit'] >= 9) {
	// 						$error = 'Too many users with that name. Please use another name.';
	// 						$pathBump = '';
	// 					}
	// 					else {
	// 						$newPathNum = $pathMatch['digit']+1;
	// 						$pathBump = '-'.$newPathNum;
	// 					}
	// 				}
	// 				else $pathBump = '-2';
					
	// 				$userPath = lcfirst(Input::get('first_name')) . '-' . lcfirst(Input::get('last_name')) . $pathBump;
	// 			}
	// 			if($error) {
	// 				$response = array(
	// 	                'errorMsg' => $error
	// 	            );
	// 			}
	// 			else {
	// 				$userToUpdate = User::find(Input::get('id'));
	// 				$userToUpdate->first_name =  ucwords(Input::get('first_name'));
	// 				$userToUpdate->last_name =  ucwords(Input::get('last_name'));
	// 				$userToUpdate->user_path = $userPath;
	// 				$userToUpdate->email =  Input::get('email');
	// 				if(Input::get('password') != '') $userToUpdate->password =  Hash::make(Input::get('password'));
	// 				$userToUpdate->userrole =  Input::get('userrole');
	// 				$userToUpdate->extension =  Input::get('extension');
	// 				$userToUpdate->cell_phone =  Input::get('cell_phone');
	// 				$userToUpdate->status =  Input::get('status');
					
	// 				$userToUpdate->save();		
					
	// 				$response = array(
	// 					'id' => Input::get('id'),
	// 					'first_name' => ucwords(Input::get('first_name')),
	// 					'last_name' => ucwords(Input::get('last_name')),
	// 					'email' => Input::get('email'),
	// 					'userrole' => Input::get('userrole'),
	// 					'extension' => Input::get('extension'),
	// 					'cell_phone' => Input::get('cell_phone'),
	// 					'status' => Input::get('status'),
	// 		            'msg' => 'successfully updated.',
	// 		        );
	// 			}
	// 		}
	// 	}
	// 	elseif(Input::get('confirm-delete') == 'yes') {

	// 		$response = array(
	// 			'first_name' => Input::get('first_name'),
	// 			'last_name' => Input::get('last_name'),
	// 			'msg' => 'successfully deleted.'
	// 		);

	// 		$userToDelete = User::find(Input::get('id'));
	// 		$userToDelete->delete();
	// 	}
	// 	elseif(Input::get('confirm-add') == 'yes') {
	// 		$validator = Validator::make(Input::all(), array(
	// 			'first_name' => 'required|max:40|alpha',
	// 			'last_name' => 'required|max:40|alpha',
	// 			'email' => array('unique:users', 'required', 'max:40', 'email', 'regex:/^(.*?)+(@)+(insideout.com)/i'),
	// 			'password' => 'required|between:8,30',
	// 			'extension' => 'between:3,12|regex:/^([0-9,])+$/i'
	// 		));
			
	// 		if($validator->fails()) {
	// 			$messages = $validator->messages();
	// 			$response = array(
	// 				'errorMsg' => $messages->first()
	// 			);
	// 		}
	// 		else {
	// 			$userPath = lcfirst(Input::get('first_name')) . '-' . lcfirst(Input::get('last_name'));
	// 			$usersCheck = User::where('user_path','like','%'.$userPath.'%')->get();
	// 			$error = '';
	// 			if(!$usersCheck->isEmpty()) {
	// 				foreach($usersCheck as $userCheck) {
	// 					$pathCheck[] = $userCheck->user_path;
	// 				}
	// 				rsort($pathCheck);
	// 				$pathCheck = $pathCheck[0];

	// 				if(preg_match('/(?<fName>\w+)-(?<lName>\w+)-(?<digit>\d+)/', $pathCheck, $pathMatch)) {
	// 					if($pathMatch['digit'] >= 9) {
	// 						$error = 'Too many users with that name. Please use another name.';
	// 						$pathBump = '';
	// 					}
	// 					else {
	// 						$newPathNum = $pathMatch['digit']+1;
	// 						$pathBump = '-'.$newPathNum;
	// 					}
	// 				}
	// 				else $pathBump = '-2';
					
	// 				$userPath = lcfirst(Input::get('first_name')) . '-' . lcfirst(Input::get('last_name')) . $pathBump;
	// 			}
	// 			if($error) {
	// 				$response = array(
	// 	                'errorMsg' => $error
	// 	            );
	// 			}
	// 			else {

	// 				$newUser = new User;
					
	// 				$newUser->first_name = ucwords(Input::get('first_name'));
	// 				$newUser->last_name = ucwords(Input::get('last_name'));
	// 				$newUser->email = Input::get('email');
	// 				$newUser->user_path = $userPath;
	// 				$newUser->password = Hash::make(Input::get('password'));
	// 				$newUser->userrole = Input::get('userrole');
	// 				$newUser->extension = Input::get('extension');
	// 				$newUser->status = 'active';

	// 				$newUser->save();

	// 				$newUserSend = User::where('email', '=', Input::get('email'))->first();


	// 				$response = array(
	// 					'id' => $newUserSend->id,
	// 					'first_name' => $newUserSend->first_name,
	// 					'last_name' => $newUserSend->last_name,
	// 					'email' => $newUserSend->email,
	// 					'userrole' => $newUserSend->userrole,
	// 					'extension' => $newUserSend->extension,
	// 					'cell_phone' => $newUserSend->cell_phone,
	// 					'status' => $newUserSend->status,
	// 					'msg' => 'successfully added.'
	// 				);
	// 			}
	// 		}
	// 	}
	// 	else {
	// 		$response = array(
	// 			'errorMsg' => 'Something went wrong. Please contact a devteam member.'
	// 		);
	// 	}
 
 //        return Response::json( $response );
	// }

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
	public function show()
	{
		$users = User::all();
		if(Request::ajax()) return View::make('admin.partials.user-list', compact('users'));
		else return Redirect::to('/admin');
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