<?php

class ProfilesController extends \BaseController {

	/**
     * Instantiate a new UsersController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('auth');

        //$this->beforeFilter('csrf', array('on' => 'post'));
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		return View::make('profile.partials.details');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		return View::make('profile.partials.form');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/profile/edit')->withInput()->with('flash_message_error','Form submission error. Please don\'t do that.');
        
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
			return Redirect::to('/profile/edit')->withInput()->withErrors($messages);
		}
		else {
			$user = User::find(Input::get('id'));
			$user->first_name =  ucwords(Input::get('first_name'));
			$user->last_name =  ucwords(Input::get('last_name'));
			if(Input::get('password') != '') $user->password =  Hash::make(Input::get('password'));
			$user->user_path = lcfirst(Input::get('first_name')) . '-' . lcfirst(Input::get('last_name'));
			$user->extension =  Input::get('extension');
			$user->cell_phone =  Input::get('cell_phone');
			//if($user->save()) return Redirect::to('/profile')->with('flash_message_success','Profile successfully updated!');
			try
			{
				$user->save();
			} catch(Illuminate\Database\QueryException $e)
			{
					return Redirect::to('/profile/edit')->withInput()->with('flash_message_error','Oops, something went wrong. Please try again.');
			}
			return Redirect::to('/profile')->with('flash_message_success','Profile successfully updated!');
		}

		return Redirect::to('/profile')->with('flash_message_error','Something went wrong. :(');
	}

}