<?php

Use \Template;

class AdminController extends \BaseController {

	protected $template;
	/**
     * Instantiate a new AdminController instance.
     */
    public function __construct(Template $template)
    {
        $this->beforeFilter('admin');

        $this->template = $template;

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
			'userrole' => 'required|in:standard,admin,non-standard',
			'status' => 'required|in:active,inactive',
			'can_manage' => 'required|in:yes,no',
			'anniversary' => 'size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
			'extension' => 'between:3,12|regex:/^([0-9,])+$/i',
			'cell_phone' => 'size:12|regex:/^([0-9-])+$/i',
			'password' => 'between:8,30',
			'password_again' => 'required_with:password|same:password',
		));
		
		if($validator->fails()) {
			$messages = $validator->messages();
			return Redirect::to('/admin/users/'.$userpath)->withInput()->withErrors($messages->first());
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
			$user->can_manage = Input::get('can_manage');
			if(Input::get('anniversary') != '') $user->anniversary = Carbon::createFromFormat('m/d/Y', Input::get('anniversary'));
			try
			{
				$user->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				return Redirect::to('/admin/users/'.$user->user_path)->withInput()->with('flash_message_error','Oops, something went wrong. Please try again.');
			}
			return Redirect::to('/admin/users/')->with('flash_message_success', '<i>' . $user->first_name . ' ' . $user->last_name . '</i> successfully updated!');
		}

		return Redirect::to('/admin/users/'.$user->user_path)->with('flash_message_error','Something went wrong. :(');
	}

	public function userNew() {
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/admin/users/')->withInput()->with('flash_message_error','Form submission error. Please don\'t do that.');
 
        $validator = Validator::make(Input::all(), array(
			'first_name' => 'required|max:40|alpha',
			'last_name' => 'required|max:40|alpha',
			'email' => array('unique:users', 'required', 'max:40', 'email', 'regex:/^(.*?)+(@)+(insideout.com)/i'),
			'password' => 'required|between:8,30',
			'userrole' => 'required|in:standard,admin,non-standard',
		));

		if($validator->fails()) {
			$messages = $validator->messages();
			$response = array(
				'errorMsg' => $messages->first()
			);
			return Response::json( $response );
		}
		else {
			$newUser = new User;
			$newUser->first_name =  ucwords(Input::get('first_name'));
			$newUser->last_name =  ucwords(Input::get('last_name'));
			$newUser->email = Input::get('email');
			$newUser->password =  Hash::make(Input::get('password'));
			$newUser->user_path = lcfirst(Input::get('first_name')) . '-' . lcfirst(Input::get('last_name'));
			$newUser->status =  'active';
			$newUser->userrole =  Input::get('userrole');

			try
			{
				$newUser->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				$response = array(
					'errorMsg' => 'Oops, something went wrong (possible name match exception).'
				);
				return Response::json( $response );
				//return Redirect::to('/admin/users/')->withInput()->with('flash_message_error','Oops, something went wrong (possible name match exception).');
			}
			$response = array(
				'msg' => 'User saved.'
			);
			return Response::json( $response );
			//return Redirect::to('/admin/users/')->with('flash_message_success','<i>' . $newUser->first_name . ' ' . $newUser->last_name .'</i> successfully updated!');
		}
		$response = array(
			'errorMsg' => 'Something went wrong. :('
		);
		return Response::json( $response );
	}

	public function userDelete() {
		$userToDelete = User::find(Input::get('id'));
		$userToDelete->delete();
		return Redirect::to('/admin/users/')->with('flash_message_success','User deleted successfully.');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function templates()
	{
		$templatesActive = Template::where('status','=','active')->get();
		$templatesInactive = Template::where('status','=','inactive')->get();
		if(Request::ajax()) return View::make('admin.partials.templates-add-new', compact('templates'));
		else return View::make('admin.partials.templates-list', compact('templatesActive','templatesInactive'));
	}

	/**
	 * Add new resource.
	 *
	 * @return Response
	 */
	public function templateNew()
	{
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/admin/templates/')->withInput()->with('flash_message_error','Form submission error. Please don\'t do that.');
 
        $validator = Validator::make(Input::only('name','type','section','content'), array(
			'name' => 'required|max:120',
			'type' => 'required|in:project,help,billable,invoice',
			'section' => 'required|array',
			'content' => 'required|array'
		));

		if($validator->fails()) {
			$messages = $validator->messages();
			$response = array(
				'errorMsg' => $messages->first()
			);
			return Response::json( $response );
		}
		else {
			$newTemplate = new Template;
			$newTemplate->name =  ucwords(Input::get('name'));
			$newTemplate->type =  Input::get('type');
			$newTemplate->status =  'active';
			$newTemplate->slug = convert_title_to_path(Input::get('name'));
			// dd(Input::get('content'));
			try
			{
				$newTemplate->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				$response = array(
					'errorMsg' => 'Oops, something went wrong (possible name match exception).'
				);
				return Response::json( $response );
			}

			$sections = Input::get('section');
			$contents = Input::get('content');
			$taskCount = 0;
			// dd(count($sections));
			foreach($sections as $section) {
				$newTask = new TemplateTask;
				$newTask->template_id = $newTemplate->id;
				$newTask->section = $sections[$taskCount];
				$newTask->content = $contents[$taskCount];
				try
				{
					$newTask->save();
				} catch(Illuminate\Database\QueryException $e)
				{
					$response = array(
						'errorMsg' => 'Oops, something went wrong. Please contact the DevTeam.'
					);
					return Response::json( $response );
				}
				$taskCount++;
			}

			$response = array(
				'msg' => 'Template saved.'
			);
			return Response::json( $response );
		}
		$response = array(
			'errorMsg' => 'Something went wrong. :('
		);
		return Response::json( $response );
	}

	/**
	 * Display single view of the resource.
	 *
	 * @return Response
	 */
	public function templateEdit($template)
	{
		$template = Template::where('slug','=',$template)->first();
		$templateTasks = $this->template->displayChecklist($template->id);
		return View::make('admin.partials.template-form', compact('template','templateTasks'));
	}

	public function templateUpdate($templateSlug)
	{
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/admin/templates/')->withInput()->with('flash_message_error','Form submission error. Please don\'t do that.');
 
        $validator = Validator::make(Input::only('name','type','items','status'), array(
        	'id' => 'same:id',
			'name' => 'required|max:120',
			'type' => 'required|in:project,help,billable,invoice',
			'items' => 'required',
			'status' => 'required|in:active,inactive'
		));

		if($validator->fails()) {
			$messages = $validator->messages();
			return Redirect::to('/admin/templates/'.$templateSlug.'/edit')->withInput()->withErrors($messages->first());
		}
		else {
			$template = Template::find(Input::get('id'));
			
			$template->name =  ucwords(Input::get('name'));
			$template->type =  Input::get('type');
			$template->status =  Input::get('status');
			$template->items = clean_content(Input::get('items'));
			$template->slug = convert_title_to_path(Input::get('name'));

			try
			{
				$template->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				return Redirect::to('/admin/templates/'.$template->slug.'/edit')->withInput()->with('flash_message_error','Oops, something went wrong. Please try again.');
			}
			return Redirect::to('/admin/templates/')->with('flash_message_success', '<i>' . $template->name . '</i> successfully updated!');
		}
		return Redirect::to('/admin/templates/'.$template->slug.'/edit')->with('flash_message_error','Something went wrong. :(');
	}
	public function templateAddtask() {
		return View::make('admin.partials.template-tasks');
	}
}