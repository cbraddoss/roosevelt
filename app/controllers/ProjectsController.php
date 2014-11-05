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
    public function __construct(Mailer $mailer, Project $project, ProjectComment $projectComment, Template $template, Account $account, Tag $tag, TagRelationship $tagRelationship)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

        $this->mailer = $mailer;

        $this->project = $project;

        $this->projectComment = $projectComment;

        $this->template = $template;

        $this->account = $account;

		$this->tag = $tag;

		$this->tagRelationship = $tagRelationship;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$projects = $this->project->getOpenProjects();
		$projectTypes = $this->project->getTypeSelectList();
		$projectsCount = $projects->count();
		// if(Request::ajax()) return View::make('projects.partials.new', compact('templates'));
		// else
		return View::make('projects.index', compact('projects','projectTypes','projectsCount'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$templates = $this->template->getActiveTemplates();
		if(Request::ajax()) return View::make('projects.partials.new', compact('templates'));
		else return Redirect::to('/projects');
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
			'attachment[]' => 'mimes:jpg,jpeg,png,gif,pdf',
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
			$newProject->manager_id = Auth::user()->id;
			$newProject->template_id = Input::get('template_id');
			$newProject->account_id = Input::get('account_id');
			$newProjectTemplate = Template::find(Input::get('template_id'));
			if($newProjectTemplate->name == Input::get('template_name')) $newProject->type = $newProjectTemplate->slug;
			else {
				$response = array(
					'actionType' => 'project-add',
					'errorMsg' => 'Oops, something went wrong. Please contact the DevTeam.'
				);
				return Response::json( $response );
			}
			$templateTaskFirst = TemplateTask::where('template_id','=',Input::get('template_id'))->first();
			$newProject->stage = $templateTaskFirst->section;
			$newProject->period = Input::get('period'); 
			
			if(Input::get('period') == 'ending' && Input::get('launch_date') == '') {
				$response = array(
					'actionType' => 'project-add',
					'errorMsg' => 'The Launch Date field is required.'
				);
				return Response::json( $response );
			}
			elseif(Input::get('period') == 'ending') {
				$newProject->due_date = Carbon::createFromFormat('m/d/Y', Input::get('start_date'));
				$newProject->end_date = Carbon::createFromFormat('m/d/Y', Input::get('launch_date'));
			}
			if(Input::get('period') == 'recurring' && Input::get('recur_cycle') == '') {
				$response = array(
					'actionType' => 'project-add',
					'errorMsg' => 'The Recur Cycle field is required.'
				);
				return Response::json( $response );
			}
			elseif(Input::get('period') == 'recurring') {
				$newProject->recur_cycle = Input::get('recur_cycle');
				if($newProject->recur_cycle == 'monthly') {
					$newProject->end_date = Carbon::createFromFormat('m/d/Y', Input::get('start_date'))->addMonth();
				}
				elseif($newProject->recur_cycle == 'biweekly') {
					$newProject->end_date = Carbon::createFromFormat('m/d/Y', Input::get('start_date'))->addWeeks(2);
				}
				elseif($newProject->recur_cycle == 'weekly') {
					$newProject->end_date = Carbon::createFromFormat('m/d/Y', Input::get('start_date'))->addWeek();
				}
				elseif($newProject->recur_cycle == 'daily') {
					$newProject->end_date = Carbon::createFromFormat('m/d/Y', Input::get('start_date'))->addDay();
				}
				else {
					$response = array(
						'actionType' => 'project-add',
						'errorMsg' => 'The Recur Cycle field is required.'
					);
					return Response::json( $response );
				}
				$newProject->due_date = $newProject->end_date;
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
					'actionType' => 'project-add',
					'errorMsg' => 'Oops, there might be an article with this title already. Try a different title.'
				);
				return Response::json( $response );
			}

			$templateTasks = TemplateTask::where('template_id','=',Input::get('template_id'))->get();
			if(!$templateTasks->isEmpty()) {
				foreach ($templateTasks as $tempTask) {
					$projectTask = new ProjectTask;
					$projectTask->project_id = $newProject->id;
					$projectTask->section = $tempTask->section;
					$projectTask->content = $tempTask->content;
					$projectTask->checkbox = 'open';
					try
					{
						$projectTask->save();
					} catch(Illuminate\Database\QueryException $e)
					{
						$response = array(
							'actionType' => 'project-add',
							'errorMsg' => 'Oops, something went wrong. Please contact the DevTeam.'
						);
						return Response::json( $response );
					}
				}
				$firstStage = ProjectTask::where('project_id','=',$newProject->id)->first();
				$newProject->stage = $firstStage->section;
				$newProject->save();
			}
			$newTagFail = '';
			if(Input::has('tag_id')) {
				$parseTags = Input::get('tag_id');
				$parseTags = explode(',', $parseTags);
				$parseTags = array_unique($parseTags);
				foreach($parseTags as $parseTag) {
					if(is_numeric($parseTag)) {
						$newTagRelationship = $this->tagRelationship->newRelationship($parseTag, 'project', $newProject->id);
						if($newTagRelationship == 'fail') {
							$newTagFail = '(Note: Tag Error. Please try again.)';
						}
					}
					else {
						$newTagFail = '(Note: Tag Error. Please try again.)';
					}
				}
			}

			if(!empty($newProject->subscribed)) $this->mailer->projectNewSubEmail($newProject);
			
			if($newProject->period == 'ending') {
				$hcMessage = '';
				$hcMessage .= '<br />New Project started!<br />';
				$hcMessage .= 'Project: <a href="' . URL::to( '/projects/post/' . $newProject->slug ) . '">' . $newProject->title . '</a><br />';
				$hcMessage .= 'Account: <b>' . Account::find($newProject->account_id)->name . '</b>.<br />';
				$hcMessage .= 'Launch Date: <b>'.Carbon::createFromFormat('Y-m-d H:i:s', $newProject->end_date)->format('F j').'</b>.<br />';
				$hcMessage .= 'Current Stage: <b>'.$newProject->stage.'</b><br />';
				$hcMessage .= 'Assigned to: <b>'.User::find($newProject->assigned_id)->first_name.' ' . User::find($newProject->assigned_id)->last_name . '</b><br />';
				$hcMessage .= 'Due Date: <b>'.Carbon::createFromFormat('Y-m-d H:i:s', $newProject->due_date)->format('F j').'</b>.';
				$hcMessageSend = hipchat_message($hcMessage);
				if($hcMessageSend != 'messageSent') {
					$response = array(
						'actionType' => 'project-add',
						'windowAction' => '/projects/post/'.$newProject->slug,
						'slug' => $newProject->slug,
						'msg' => 'Project created successfully! (Note: '.$hcMessageSend.' - '.$newTagFail.')'
					);
					return Response::json( $response );
				}
			}

			$response = array(
				'actionType' => 'project-add',
				'windowAction' => '/projects/post/'.$newProject->slug,
				'slug' => $newProject->slug,
				'msg' => 'Project created successfully! '.$newTagFail
			);
			return Response::json( $response );
		}
		$response = array(
			'actionType' => 'project-add',
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
		$tasks = $this->project->displayChecklist($project->id);
		$progress = $this->project->displayProgress($project->id);
		$comments = $this->projectComment->getComments($project->id);
		$subComments = $this->projectComment->getSubComments($project->id);
		if($project) return View::make('projects.single', compact('project','comments','subComments','tasks','subscribed','progress'));
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
							->paginate(20);
				$projectsCount = $projects->count();
				return View::make('projects.filters.user', compact('projects','user','projectsCount'));
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
					->paginate(20);
		$projectsCount = $projects->count();
		$date = $date->format('F, Y');
		return View::make('projects.filters.date', compact('projects','date','projectsCount'));
	}

	/**
	 * Return search for project stages
	 *
	 * @return Response
	 */
	public function stageFilter($type, $stage) {
		$projectTypes = $this->project->getTypeSelectList($type);
		$projectStages = $this->project->getTypeStagesSelectList($type, $stage);
		if($stage != '0') {
			$projects = Project::where('stage','=',convert_path_to_stage($stage))
					->where('type','=', $type)
					->where('status','=','open')
					->orderBy('due_date','ASC')
					->paginate(20);
			$projectsCount = $projects->count();
			return View::make('projects.filters.stage', compact('projects','stage','projectStages','type','projectTypes','projectsCount'));
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
					->paginate(20);
			$projectsCount = $projects->count();
			if($projects != null) {
				if($priority == 'low') $low = $priority;
				if($priority == 'normal') $normal = $priority;
				if($priority == 'high') $high = $priority;
				return View::make('projects.filters.priority', compact('projects','low','normal','high','priority','projectsCount'));
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
				// $projects = Project::where('status','=',$status)
				// 		->orderBy('due_date','ASC')
				// 		->paginate(10);
				return Redirect::route('projects');
			}
			else {
				$projects = Project::where('status','=',$status)
						->orderBy('created_at','DESC')
						->paginate(20);
				$projectsCount = $projects->count();
			}
			if($projects != null) {
				if($status == 'open') $open = $status;
				if($status == 'closed') $closed = $status;
				if($status == 'archived') $archived = $status;
				return View::make('projects.filters.status', compact('projects','open','closed','archived','status','projectsCount'));
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
		if($type != '0') {
			$template = Template::where('slug','=',$type)->first();
			$projectTypes = $this->project->getTypeSelectList($template->slug);
			$projectStages = $this->project->getTypeStagesSelectList($template->slug);
			if($template != null) {
				if($template->status == 'inactive') $tStatus = ' (inactive)';
				else $tStatus = '';
				if($type != '0') {
					$projects = Project::where('type','=',$type)
							->where('status','=','open')
							->orderBy('due_date','ASC')
							->paginate(20);
					$projectsCount = $projects->count();
					if($projects != null) {
						return View::make('projects.filters.type', compact('projects','tStatus','type','projectTypes','projectStages','projectsCount'));
					}
					else return Redirect::route('projects');
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
			else return View::make('projects.edit', compact('project'));
		}
		else return Redirect::to('/projects/post/'.$project->slug);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($project)
	{
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/projects/post/'.$project)->withInput()->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
 		$validator = Validator::make(Input::all(), array(
			'title' => 'required|max:120',
			'content' => 'required',
			'subscribed' => 'required',
			'account_id' => 'required|integer',
			'priority' => 'required|in:low,normal,high',
			'status' => 'required|in:open,closed,archived',
			'launch_date' => 'size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
			'due_date' => 'size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
			'end_date' => 'size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
			'attachment[]' => 'mimes:jpg,jpeg,png,gif,pdf',
		));

		if($validator->fails()) {
			$messages = $validator->messages();
			return Redirect::to('/projects/post/'.$project.'/edit')->withInput()->withErrors($messages->first());
		}
		else {
			$editProject = Project::find(Input::get('id'));

			$editProject->title = clean_title(Input::get('title'));
			$editProject->content =  clean_content(Input::get('content'));
			$editProject->slug = convert_title_to_path(Input::get('title'));
			$editProject->edit_id = Auth::user()->id;
			$editProject->priority = Input::get('priority');
			$editProject->status = Input::get('status');
			$editProject->subscribed = Input::get('subscribed');
			$editProjectAssigned = User::where('user_path','=',Input::get('project-assigned-user'))->first();
			$editProject->assigned_id = $editProjectAssigned->id;
			$editProject->account_id = Input::get('account_id');

			
			if($editProject->period == 'ending' && Input::get('launch_date') == '') {
				return Redirect::to('/projects/post/'.$project.'/edit')->withInput()->with('flash_message_error','The Launch Date field is required.');
			}
			elseif($editProject->period == 'ending' && Input::get('due_date') == '') {
				return Redirect::to('/projects/post/'.$project.'/edit')->withInput()->with('flash_message_error','The Due Date field is required.');
			}
			elseif($editProject->period == 'ending') {
				$editProject->due_date = Carbon::createFromFormat('m/d/Y', Input::get('due_date'));
				$editProject->end_date = Carbon::createFromFormat('m/d/Y', Input::get('launch_date'));
			}
			if($editProject->period == 'recurring' && Input::get('end_date') == '') {
				return Redirect::to('/projects/post/'.$project.'/edit')->withInput()->with('flash_message_error','The End Date field is required.');
			}
			elseif($editProject->period == 'recurring' && Input::get('due_date') == '') {
				return Redirect::to('/projects/post/'.$project.'/edit')->withInput()->with('flash_message_error','The Due Date field is required.');
			}
			elseif($editProject->period == 'recurring') {
				$editProject->end_date = Carbon::createFromFormat('m/d/Y', Input::get('end_date'));
				$editProject->due_date = Carbon::createFromFormat('m/d/Y', Input::get('due_date'));
			}
			$editProject->start_date = Carbon::createFromFormat('m/d/Y', Input::get('start_date'));
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
				if(!empty($editProject->attachment)) {
					$extractAttachment = unserialize($editProject->attachment);
					$allFiles = array_merge($extractAttachment, $fileNames);
					//dd($allFiles);
					$editProject->attachment = serialize($allFiles);
				}
				else $editProject->attachment = serialize($fileNames);
				// $editProject->attachment = serialize($fileNames);
			}
			try
			{
				$editProject->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				return Redirect::to('/projects/post/'.$project.'/edit')->withInput()->with('flash_message_error','Oops, there might be an article with this title already. Try a different title.');
			}

			//if(!empty($editProject->mentions)) $this->mailer->articlePingEmail($editProject);
			
			return Redirect::to('/projects/post/'.$editProject->slug)->withInput()->with('flash_message_success','Project updated successfully!');
		}
		
		return Redirect::to('/projects/post/'.$project.'/edit')->withInput()->with('flash_message_error','Something went wrong. :(');
	}

	public function removeImage($id,$imageName) {
		if(Request::ajax()) {
			if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/projects')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
			$project = Project::find($id);
			$attachments = $project->attachment;
			$attachments = unserialize($attachments);
			$imagePath = Input::get('imagePath');
			$imageName = $imagePath;
			$name = array_search($imageName, $attachments);
			if($name !== false) unset($attachments[$name]);
			if(empty($attachments)) $project->attachment = '';
			else $project->attachment = serialize($attachments);
			try
				{
					$project->save();
				} catch(Illuminate\Database\QueryException $e)
				{
					$response = array(
						'actionType' => 'attachment-delete',
						'errorMsg' => 'Oops, something went wrong. Please try again.',
					);
					return Response::json( $response );
				}

			$response = array(
				'actionType' => 'attachment-delete',
				'msg' => 'Attachment removed.',
				//'windowAction' => '/projects/post/'.$project->slug.'/edit',
				'image' => $imageName,
			);
				
			return Response::json( $response );
		}
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
				$validator = Validator::make(Input::only('value'), array(
					'value' => 'required|size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
				));

				if($validator->fails()) {
					$response = array(
						'errorMsg' => 'An error occurred. Please try again or contact the DevTeam.'
					);
					return Response::json( $response );
				}
				else {
					$date = Input::get('value');
					$date = Carbon::createFromFormat('m/d/Y', $date);
					$project->$value = $date;
					$dateSave = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('F j');
					if(Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) $classchange = 'due-now';
					elseif(Carbon::createFromFormat('Y-m-d H:i:s', $date)->subWeek()->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) $classchange = 'due-soon';
					else $classchange = '';

					//if($dateSave == Carbon::now()->format('F j')) $dateSave = 'Today';

					$project->save();
					
					//if(!empty($newProject->subscribed)) $this->mailer->projectListDateChangeEmail($newProject);

					$response = array(
						'msg' => 'Saved!',
						'pid' => $project->id,
						'date' => $dateSave,
						'thispage' => Input::get('thisPage'),
						'changeclass' => $classchange
					);
				}
			}
			if(Input::has('subscribeTo') == 'updatesub') {
				$validator = Validator::make(Input::only('value'), array(
					'value' => 'required',
				));
				if($validator->fails()) {
					$response = array(
						'errorMsg' => 'An error occurred. Please try again or contact the DevTeam.'
					);
					return Response::json( $response );
				}
				else {
					$oldSubscribed = $project->subscribed;
					$currentUserToSub = Auth::user()->user_path;
					if(strpos($oldSubscribed, $currentUserToSub) !== false ) $project->subscribed = $oldSubscribed;
					else $project->subscribed = $oldSubscribed.' '.$currentUserToSub;
					$project->save();
					$response = array(
						'msg' => 'Saved!',
						'pid' => $project->id,
						'subd' => 'success',
						'thispage' => Input::get('thisPage')
					);
				}
			}
			if(Input::has('user') == 'userchange') {
				$validator = Validator::make(Input::only('value'), array(
					'value' => 'required',
				));

				if($validator->fails()) {
					$response = array(
						'errorMsg' => 'An error occurred. Please try again or contact the DevTeam.'
					);
					return Response::json( $response );
				}
				else {
					$userChange = Input::get('value');
					$userFind = User::where('user_path','=',$userChange)->first();
					$userName = $userFind->first_name;
					$oldUser = $project->$value;
					$oldSubscribed = $project->subscribed;
					if(strpos($oldSubscribed,$userFind->user_path) !== false ) $project->subscribed = $oldSubscribed;
					else $project->subscribed = $oldSubscribed.' '.$userFind->user_path;
					$project->$value = $userFind->id;
					$currentUser = Auth::user()->id;
					
					$project->save();
					
					if(!empty($project->assigned_id)) $this->mailer->projectListUserChangeEmail($project, $currentUser);

					$response = array(
						'msg' => 'Saved!',
						'pid' => $project->id,
						'user' => $userChange,
						'thispage' => Input::get('thisPage')
					);
				}
			}
			if(Input::has('stage') == 'stagechange') {
				$projectTasks = ProjectTask::where('project_id','=',$project->id)->get();
				$projectSections = array();
				foreach($projectTasks as $projectTask) {
					$projectSections[] = $projectTask->section;
				}
				$validator = Validator::make(Input::only('value'), array(
					'value' => 'required',
				));

				if($validator->fails()) {
					$response = array(
						'errorMsg' => 'An error occurred. Please try again or contact the DevTeam.'
					);
					return Response::json( $response );
				}
				elseif(!in_array(Input::get('value'),$projectSections)) {
					$response = array(
						'errorMsg' => 'An error occurred. Please try again or contact the DevTeam.'
					);
					return Response::json( $response );
				}
				else {
					$stageChange = Input::get('value');
					$project->$value = $stageChange;

					$project->save();

					//if(!empty($newProject->subscribed)) $this->mailer->projectListStageChangeEmail($newProject);

					$response = array(
						'msg' => 'Saved!',
						'pid' => $project->id,
						'thispage' => Input::get('thisPage')
					);
				}
			}
			
			
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
			if(Input::has('date') == 'launchdate') {
				$validator = Validator::make(Input::only('value'), array(
					'value' => 'required|size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
				));

				if($validator->fails()) {
					$response = array(
						'errorMsg' => 'An error occurred. Please try again or contact the DevTeam.'
					);
					return Response::json( $response );
				}
				else {
					$date = Input::get('value');
					$date = Carbon::createFromFormat('m/d/Y', $date);
					$project->$value = $date;
					$dateSave = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('F j');

					//if($dateSave == Carbon::now()->format('F j')) $dateSave = 'Today';

					$project->save();
					
					//if(!empty($newProject->subscribed)) $this->mailer->projectListDateChangeEmail($newProject);

					$response = array(
						'msg' => 'Saved!',
						'pid' => $project->id,
						'date' => $dateSave,
						'thispage' => Input::get('thisPage')
					);
				}
			}
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

			$project->save();
			
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

			$project->save();
			
			}
			if(Input::has('updatecheckbox') == 'updatecheckbox') {
				$checkboxUpdate = Input::get('value');
				$projectTaskFind = ProjectTask::find($checkboxUpdate);
				if(Input::has('addskipnote') == 'addskipnote') {
					$projectTaskFind->notes = 'skipped-task';
					$skippedTask = 'skippedtask';
				}
				else {
					$projectTaskFind->notes = 'active-task';
					$skippedTask = 'activetask';
				}
				if(Input::get('checkboxValue') == 'closed')	{
					$projectTaskFind->checkbox = 'closed';
					if($projectTaskFind->user_finished_id != 0) {
						$response = array(
							'msg' => 'pageneedsreloading'
						);
						return Response::json( $response );
					}
					$projectTaskFind->user_finished_id = Input::get('user_finished_id');
				}
				if(Input::get('checkboxValue') == 'open') {
					$projectTaskFind->checkbox = 'open';
					if($projectTaskFind->user_finished_id == 0) {
						$response = array(
							'msg' => 'pageneedsreloading'
						);
						return Response::json( $response );
					}
					$projectTaskFind->user_finished_id = 0;
				}

				$projectTaskFind->save();
				if(Input::get('nextProjectStage') != '') {
					$project->stage = Input::get('nextProjectStage');
					$project->save();
				}
				$response = array(
					'msg' => $skippedTask,
					'projecttaskid' => $projectTaskFind->id
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

				$project->save();
			}
			if(Input::has('priority') == 'prioritychange') {
				$priorityChange = Input::get('value');
				$oldPriority = $project->$value;
				$project->$value = $priorityChange;
				
				$response = array(
					'msg' => 'Saved!',
					'pid' => $project->id,
					'user' => $priorityChange,
					'thispage' => Input::get('thisPage')
				);

				$project->save();
			}
			if(Input::has('user') == 'managerchange') {
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

				$project->save();
			}

			if(Input::has('attachnewtag') == 'attachtag') {

		 		$validator = Validator::make(Input::all(), array(
					'tag_id' => 'required|integer',
					'type_id' => 'required|integer'
				));

				if($validator->fails()) {
					$messages = $validator->messages();
					$response = array(
						'actionType' => 'project-update',
						'errorMsg' => $messages->first()
					);
					return Response::json( $response );
				}

				$projectId = Input::get('type_id');
				$parseTags = Input::get('tag_id');
				$parseTags = explode(',', $parseTags);
				$parseTags = array_unique($parseTags);
				foreach($parseTags as $parseTag) {
					if(is_numeric($parseTag)) {
						$newTagRelationship = $this->tagRelationship->newRelationship($parseTag, 'project', $projectId);
						if($newTagRelationship == 'fail') {
							$response = array(
								'actionType' => 'project-update',
								'errorMsg' => 'Oops, there was a problem attaching the tag(s). Please try again.'
							);
							return Response::json( $response );
						}
					}
					else {
						$response = array(
							'actionType' => 'project-update',
							'errorMsg' => 'Oops, there was a problem attaching the tag(s). Please try again.'
						);
						return Response::json( $response );
					}
				}

				$response = array(
					'actionType' => 'project-update',
					'tagsText' => Input::get('tagsText'),
					'msg' => 'Tag added successfully!'
				);
				return Response::json( $response );

			}
			
			
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
		$project = Project::find($id);
		if(Auth::user()->userrole == 'admin') {
			$projectTitle = $project->title;
			$project->delete();
			return Redirect::to('/projects/')->with('flash_message_error', '<i>' . $projectTitle . '</i> successfully deleted');
		}
		else return Redirect::route('projects');
	}


}
