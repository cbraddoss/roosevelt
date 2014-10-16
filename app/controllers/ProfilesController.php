<?php

use \Vacation;

class ProfilesController extends \BaseController {

	protected $vacations;

	/**
     * Instantiate a new UsersController instance.
     */
    public function __construct(Vacation $vacations)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

        $this->vacations = $vacations;
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		$user = Auth::user()->id;
		$homerQuotes = array(
			'"To Start Press Any Key". Where\'s the ANY key?',
			'I’ve gone back in time to when dinosaurs weren’t just confined to zoos.',
			'Bart, with $10,000, we’d be millionaires! We could buy all kinds of useful things like…love!',
			'All my life I\'ve had one dream, to achieve my many goals.',
			'No TV and no beer makes Homer something something.',
			'Being popular is the most important thing in the world!',
			'Aw, people can come up with statistics to prove anything, Kent. 14 percent of all people know that.',
			'Facts are meaningless. You could use facts to prove anything that\'s even remotely true.',
			'If something\'s hard to do, then it\'s not worth doing.',
			'D\'oh!'
			);
		$getHomerQuote = $homerQuotes[rand(1,10)-1];
		$vacationsUpcoming = $this->vacations->get_upcoming($user);
		$vacationsPrevious = $this->vacations->get_previous($user);
		return View::make('profile.index', compact('vacationsUpcoming','vacationsPrevious','getHomerQuote'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		//return View::make('profile.partials.form');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/profile')->withInput()->with('flash_message_error','Form submission error. Please don\'t do that.');
        
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
			$messages = $validator->messages()->first();
			return Redirect::to('/profile')->withInput()->withErrors($messages);
		}
		else {
			$user = User::find(Input::get('id'));
			$user->first_name =  ucwords(Input::get('first_name'));
			$user->last_name =  ucwords(Input::get('last_name'));
			if(Input::get('password') != '') $user->password =  Hash::make(Input::get('password'));
			$user->user_path = lcfirst(Input::get('first_name')) . '-' . lcfirst(Input::get('last_name'));
			$user->extension =  Input::get('extension');
			$user->cell_phone =  Input::get('cell_phone');
			$user->hipchat_mention = hipchat_mention_name($user->email);
			//if($user->save()) return Redirect::to('/profile')->with('flash_message_success','Profile successfully updated!');
			try
			{
				$user->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				return Redirect::to('/profile')->withInput()->with('flash_message_error','Oops, something went wrong. Please try again.');
			}
			return Redirect::to('/profile')->with('flash_message_success','Profile successfully updated!');
		}

		return Redirect::to('/profile')->with('flash_message_error','Something went wrong. :(');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function vacation()
	{
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/profile')->withInput()->with('flash_message_error','Form submission error. Please don\'t do that.');
        
        if(Input::get('delete-vacation') == 'yes') {
        	$removeVacation = Vacation::find(Input::get('id'));
        	try
			{
				$removeVacation->delete();
			} catch(Illuminate\Database\QueryException $e)
			{
				return Redirect::to('/profile#vacations')->withInput()->with('flash_message_error','Oops, something went wrong. Please try again.');
			}
			return Redirect::to('/profile#vacations')->with('flash_message_success','Vacation successfully deleted.');
        }
        else {
			$validator = Validator::make(Input::all(), array(
				'user_id' => 'same:user_id',
				'period' => 'required',
				'start_date' => 'required|size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
				'end_date' => 'required|size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
			));
			
			if($validator->fails()) {
				$messages = $validator->messages()->first();
				return Redirect::to('/profile')->withInput()->withErrors($messages);
			}
			else {
				$newVacation = new Vacation;
				$newVacation->user_id =  Input::get('user_id');
				$newVacation->period = Input::get('period');
				// $newVacation->total_hours = Input::get('total_hours');
				$newVacation->start_date = Carbon::createFromFormat('m/d/Y', Input::get('start_date'));
				$newVacation->end_date = Carbon::createFromFormat('m/d/Y', Input::get('end_date'));

				try
				{
					$newVacation->save();
				} catch(Illuminate\Database\QueryException $e)
				{
					return Redirect::to('/profile#vacations')->withInput()->with('flash_message_error','Oops, something went wrong. Please try again.');
				}
				return Redirect::to('/profile#vacations')->with('flash_message_success','Vacation successfully added!');
			}
		}
		return Redirect::to('/profile#vacations')->with('flash_message_error','Something went wrong. :(');
	}

}