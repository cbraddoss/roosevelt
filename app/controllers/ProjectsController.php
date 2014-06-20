<?php

use \Mailer;
use \Project;
use \ProjectComment;
use \Template;
use \Account;

class ProjectsController extends \BaseController {

	protected $mailer;
	/**
     * Instantiate a new ProjectsController instance.
     */
    public function __construct(Mailer $mailer, Project $project, ProjectComment $projectComment, Template $template, Account $account)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

        $this->mailer = $mailer;

        $this->project = $project;

        $this->projectComment = $projectComment;

        $this->template = $template;

        $this->account = $account;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$projects = $this->project->getOpenProjects();
		if(Request::ajax()) return View::make('projects.partials.new');
		else return View::make('projects.index', compact('projects'));
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
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/projects')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
 		$validator = Validator::make(Input::all(), array(
			'title' => 'required|max:120',
			'content' => 'required',
			'subscribed' => 'required',
			'account_id' => 'required|integer',
			'template_id' => 'required|integer',
			'template_name' => 'required',
			'priority' => 'required|in:low,normal,high',
			'period' => 'in:ending,recurring',
			'launch_date' => 'size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
			'end_date' => 'size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
			'start_date' => 'required|size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
			'attachment' => 'mimes:jpg,jpeg,png,gif,pdf',
		));

		if($validator->fails()) {
			$messages = $validator->messages();
			$response = array(
				'errorMsg' => $messages->first()
			);
			return Response::json( $response );
		}
		else {
			$newProject = new Project;
			$newProject->title = clean_title(Input::get('title'));
			$newProject->content =  clean_content(Input::get('content'));
			$newProject->slug = convert_title_to_path(Input::get('title'));
			$newProject->author_id = Auth::user()->id;
			$newProject->edit_id = Auth::user()->id;
			$newProject->priority = Input::get('priority');
			$newProject->status = 'open';
			$newProject->subscribed = Input::get('subscribed');
			$newProject->assigned_id = Auth::user()->id;
			$newProject->template_id = Input::get('template_id');
			$newProject->account_id = Input::get('account_id');
			$newProjectTemplate = Template::find(Input::get('template_id'));
			if($newProjectTemplate->name == Input::get('template_name')) $newProject->type = $newProjectTemplate->slug;
			else {
				$response = array(
					'errorMsg' => 'Oops, something went wrong. Please contact the DevTeam.'
				);
				return Response::json( $response );
			}
			$newProject->stage = 'coding';
			$newProject->period = Input::get('period'); 
			
			if(Input::get('period') == 'ending' && Input::get('launch_date') == '') {
				$response = array(
					'errorMsg' => 'The Launch Date field is required.'
				);
				return Response::json( $response );
			}
			elseif(Input::get('period') == 'ending') {
				$newProject->due_date = Carbon::createFromFormat('m/d/Y', Input::get('start_date'));
				$newProject->end_date = Carbon::createFromFormat('m/d/Y', Input::get('launch_date'));
			}
			if(Input::get('period') == 'recurring' && Input::get('end_date') == '') {
				$response = array(
					'errorMsg' => 'The End Date field is required.'
				);
				return Response::json( $response );
			}
			elseif(Input::get('period') == 'recurring') {
				$newProject->end_date = Carbon::createFromFormat('m/d/Y', Input::get('end_date'));
				$newProject->due_date = Carbon::createFromFormat('m/d/Y', Input::get('end_date'));
			}
			$newProject->start_date = Carbon::createFromFormat('m/d/Y', Input::get('start_date'));
			if(Input::hasFile('attachment')) {
				$attachment = Input::file('attachment');
				$fileNames = array();
				foreach($attachment as $attach) {
					$fileName = $attach->getClientOriginalName();
					$fileExtension = $attach->getClientOriginalExtension();
					$currentTime = Carbon::now()->timestamp;
					$attach = $attach->move(upload_path(), $currentTime.'-'.$fileName);
					if($fileExtension != 'pdf') $attachThumbnail = Image::make($attach)->resize(300, null, true)->crop(200,200,0,0)->save(upload_path().'thumbnail-'.$currentTime.'-'.$fileName);
					$fileNames[] = '/uploads/'.Carbon::now()->format('Y').'/'.Carbon::now()->format('m').'/'.$currentTime.'-'.$fileName;
				}
				$newProject->attachment = serialize($fileNames);
			}
			try
			{
				$newProject->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				$response = array(
					'errorMsg' => 'Oops, there might be an article with this title already. Try a different title.'
				);
				return Response::json( $response );
			}

			//if(!empty($newProject->mentions)) $this->mailer->articlePingEmail($newProject);
			
			$response = array(
				'slug' => $newProject->slug,
				'msg' => 'Project created successfully!'
			);
			return Response::json( $response );
		}
		$response = array(
			'errorMsg' => 'Something went wrong. :('
		);
		return Response::json( $response );
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$project = Project::where('slug', '=', $slug)->first();

		if(empty($project)) return Redirect::route('projects');
		
		//$tasks = $this->projectTasks->getTasks($project->id);
		//$tasks = Template::where('slug','=',$project->type)->first();
		$subscribed = $project->subscribed;
		$subscribed = explode(' ',$subscribed);
		$tasks = $this->template->displayChecklist($project->type, $project->id);
		$comments = $this->projectComment->getComments($project->id);
		$subComments = $this->projectComment->getSubComments($project->id);
		if($project) return View::make('projects.single', compact('project','comments','subComments','tasks','subscribed'));
		else return Redirect::route('projects');
	}

	/**
	 * Return search for assigned to user
	 *
	 * @param  int  $author
	 * @return Response
	 */
	public function assignedTo($userpath) {
		if(!empty($userpath)) {
			$user = find_user_from_path($userpath);
			if($user != null) {
				$projects = Project::where('assigned_id','=',$user->id)
							->where('status','=','open')
							->orderBy('due_date','ASC')
							->paginate(10);
				return View::make('projects.filters.user', compact('projects','user'));
			}
			else return Redirect::route('projects');
		}
		else return Redirect::route('projects');		
	}

	/**
	 * Return search for date
	 *
	 * @param  int  $date
	 * @return Response
	 */
	public function dateFilter($year, $month) {
		$date = new DateTime($year.'-'.$month.'-'.'01');
		$dateMax = new DateTime($year.'-'.$month.'-'.'01');
		$dateMax->modify('+1 month');		
		$projects = Project::where('due_date','>=', $date)
					->where('status','=','open')
					->where('due_date','<', $dateMax)
					->orderBy('due_date','ASC')
					->paginate(10);
		$date = $date->format('F, Y');
		return View::make('projects.filters.date', compact('projects','date'));
	}

	/**
	 * Return search for project stages
	 *
	 * @return Response
	 */
	public function stageFilter($stage) {
		if($stage != '0') {
			$projects = Project::where('stage','=',$stage)
					->where('status','=','open')
					->orderBy('due_date','ASC')
					->paginate(10);
			return View::make('projects.filters.stage', compact('projects','stage'));
		}
		else return Redirect::route('projects');
	}

	/**
	 * Return search for project priority
	 *
	 * @return Response
	 */
	public function priorityFilter($priority) {
		$low = '';
		$normal = '';
		$high = '';
		if($priority == 'low' || $priority == 'normal' || $priority == 'high') {
			$projects = Project::where('priority','=',$priority)
					->where('status','=','open')
					->orderBy('due_date','ASC')
					->paginate(10);
			if($projects != null) {
				if($priority == 'low') $low = $priority;
				if($priority == 'normal') $normal = $priority;
				if($priority == 'high') $high = $priority;
				return View::make('projects.filters.priority', compact('projects','low','normal','high','priority'));
			}
			else return Redirect::route('projects');
		}
		else return Redirect::route('projects');
	}

	/**
	 * Return search for project status
	 *
	 * @return Response
	 */
	public function statusFilter($status) {
		$open = '';
		$closed = '';
		$archived = '';
		if($status == 'open' || $status == 'closed' || $status == 'archived') {
			if($status == 'open') {
				$projects = Project::where('status','=',$status)
						->orderBy('due_date','ASC')
						->paginate(10);
			}
			else {
				$projects = Project::where('status','=',$status)
						->orderBy('created_at','DESC')
						->paginate(10);
			}
			if($projects != null) {
				if($status == 'open') $open = $status;
				if($status == 'closed') $closed = $status;
				if($status == 'archived') $archived = $status;
				return View::make('projects.filters.status', compact('projects','open','closed','archived','status'));
			}
			else return Redirect::route('projects');
		}
		else return Redirect::route('projects');
	}

	/**
	 * Return search for project type
	 *
	 * @return Response
	 */
	public function typeFilter($type) {
		$templates = Template::where('slug','=',$type)->first();
		if($templates != null) {
			if($templates->status == 'inactive') $tStatus = ' (inactive)';
			else $tStatus = '';
			if($type != '0') {
				$projects = Project::where('type','=',$type)
						->where('status','=','open')
						->orderBy('due_date','ASC')
						->paginate(10);
				if($projects != null) {
					return View::make('projects.filters.type', compact('projects','tStatus','type'));
				}
				else return Redirect::route('projects');
			}
			else return Redirect::route('projects');
		}
		else return Redirect::route('projects');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($project)
	{
		$project = Project::where('slug', $project)->first();
		if(Auth::user()->id == $project->author_id || Auth::user()->userrole == 'admin') {
			if(empty($project)) return Redirect::route('projects');
			else return View::make('projects.partials.edit', compact('project'));
		}
		else return Redirect::to('/projects/post/'.$project->slug);
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
	 * Update the project on list view pages.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateOnListView($id, $value)
	{
		if(Request::ajax()) {
			if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/projects')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
			$project = Project::where('id','=',$id)->first();
			if(empty($project)) return Redirect::to('/project');
			else $oldValue = $project->$value;
			// dd(Input::get('value'));
			if(Input::has('date') == 'youbetcha') {
				$date = Input::get('value');
				$date = Carbon::createFromFormat('Y-m-d', $date);
				$project->$value = $date;
				$dateSave = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('F j');
				if(Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) $classchange = 'due-now';
				elseif(Carbon::createFromFormat('Y-m-d H:i:s', $date)->subWeek()->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) $classchange = 'due-soon';
				else $classchange = '';

				if($dateSave == Carbon::now()->format('F j')) $dateSave = 'Today';

				$response = array(
					'msg' => 'Saved!',
					'pid' => $project->id,
					'date' => $dateSave,
					'thispage' => Input::get('thisPage'),
					'changeclass' => $classchange
				);
			}
			if(Input::has('user') == 'userchange') {
				$userChange = Input::get('value');
				$userFind = User::where('user_path','=',$userChange)->first();
				$userName = $userFind->first_name;
				$oldUser = $project->$value;
				$oldSubscribed = $project->subscribed;
				if(strpos($oldSubscribed,$userFind->user_path) !== false ) $project->subscribed = $oldSubscribed;
				else $project->subscribed = $oldSubscribed.' '.$userFind->user_path;
				$project->$value = $userFind->id;
				//if($oldUser != $userFind->id) $this->mailer->projectPingEmail($project,$oldSubscribed);

				$response = array(
					'msg' => 'Saved!',
					'pid' => $project->id,
					'user' => $userChange,
					'thispage' => Input::get('thisPage')
				);
			}
			if(Input::has('stage') == 'stagechange') {
				$stageChange = Input::get('value');
				$project->$value = $stageChange;

				$response = array(
					'msg' => 'Saved!',
					'pid' => $project->id,
					'thispage' => Input::get('thisPage')
				);
			}
			
			$project->save();
			
			return Response::json( $response );
		}
		else return Redirect::route('projects');
	}

	/**
	 * Update the project on single view pages.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateOnSingleView($id, $value)
	{
		if(Request::ajax()) {
			if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/projects')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
			$project = Project::where('id','=',$id)->first();
			if(empty($project)) return Redirect::to('/project');
			else $oldValue = $project->$value;
			// dd(Input::get('value'));
			if(Input::has('subRemove') == 'subremove') {
				$userRemove = Input::get('value');
				$oldSubscribed = $project->subscribed;
				$newSubscribed = str_replace($userRemove, '', $oldSubscribed);
				$project->$value = $newSubscribed;

				$response = array(
					'msg' => 'Saved!',
					'pid' => $project->id,
					'sub' => $userRemove,
					'thispage' => Input::get('thisPage')
				);
			}
			if(Input::has('subAdd') == 'subadd') {
				$userAdd = Input::get('value');
				$userFind = User::where('user_path','=',$userAdd)->first();
				
				$oldSubscribed = $project->subscribed;
				if(strpos($oldSubscribed,$userFind->user_path) !== false ) {
					$project->subscribed = $oldSubscribed;
					$userName = '';
					$userRemove = '';
				}
				else {
					$project->subscribed = $oldSubscribed.' '.$userFind->user_path;
					$userName = $userFind->first_name. ' ' . $userFind->last_name;
					$userRemove = $userFind->user_path;
				}

				$response = array(
					'msg' => 'Saved!',
					'pid' => $project->id,
					'sub' => $userRemove,
					'subName' => $userName,
					'thispage' => Input::get('thisPage')
				);
			}
			
			$project->save();			
			
			return Response::json( $response );
		}
		else return Redirect::route('projects');
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
