<?php
function body_class() {
	$currentPage = $_SERVER['REQUEST_URI'];
	$page = '';
	$currentPage = strtok($currentPage, '?');
	$currentPageArray = explode('/', $currentPage);
	foreach($currentPageArray as $cPage) {
		$page .= '-'.$cPage;
	}
	if(count($currentPageArray) > 2) {
		$mainPage = 'page-'.$currentPageArray[1];
		$mainPage = str_replace('--', '-', $mainPage);
	}
	else $mainPage = '';
	$page = 'page'.$page;
	$page = str_replace('--', '-', $page);
	$bodyClass = $page . ' ' . $mainPage;
	return $bodyClass;
}

function current_page() {
	$currentPage = $_SERVER['REQUEST_URI'];
	return $currentPage;
}

function gravatar_url($email,$size = '40') {
	return 'http://www.gravatar.com/avatar/' . md5($email) . '?s=' . $size . '&d=http%3A%2F%2Fassets.insideout.com%2Fimages%2Fuser-image.png';
}

function current_user_path() {
	return Auth::user()->user_path;
}

function any_user_path($id) {
	$user = User::find($id);
	return $user->user_path;
}

function find_user_from_path($userpath) {
	$user = User::where('user_path','=', $userpath)
			->first();
	return $user;
}

function get_user_list_select($selected = null) {
	$users = User::all();
	$options = '';
	foreach($users as $user) {
		if($selected == $user->first_name.' '.$user->last_name) $options .= '<option value="'.any_user_path($user->id).'" selected>'.$user->first_name.' '.$user->last_name.'</option>';
		else $options .= '<option value="'.any_user_path($user->id).'">'.$user->first_name.' '.$user->last_name.'</option>';
	}
	return $options;
}

function get_active_user_list_select($selected = null) {
	$users = User::where('status','=','active')->get();
	$options = '';
	foreach($users as $user) {
		if($selected == $user->first_name.' '.$user->last_name) $options .= '<option value="'.any_user_path($user->id).'" selected>'.$user->first_name.' '.$user->last_name.'</option>';
		else $options .= '<option value="'.any_user_path($user->id).'">'.$user->first_name.' '.$user->last_name.'</option>';
	}
	return $options;
}

function get_active_account_list($selected = null) {
	$accounts = Account::where('status','=','active')->get();
	$options = '';
	foreach($accounts as $account) {
		if($selected == $account->name) $options .= '<option value="'.$account->id.'" selected>'.$account->name.'</option>';
		else $options .= '<option value="'.$account->id.'">'.$account->name.'</option>';
	}
	return $options;
}

function get_project_type_select($selected = null) {
	$projectTypes = Template::where('type','=','project')->get();
	if($projectTypes != null) {
		$options = '';
		$optionsLast = '';
		foreach($projectTypes as $type) {
			if($type->status == 'inactive') {
				if($selected == $type->name) $optionsLast .= '<option value="'.$type->slug.'" selected>' . $type->name.' (i)' . '</option>';
				else $optionsLast .= '<option value="'.$type->slug.'">' . $type->name.' (i)' . '</option>';
			}
			else {
				if($selected == $type->name) $options .= '<option value="'.$type->slug.'" selected>'.($type->status == 'inactive' ? $type->name.' (i)' : $type->name).'</option>';
				else $options .= '<option value="'.$type->slug.'">'.($type->status == 'inactive' ? $type->name.' (i)' : $type->name).'</option>';			
			}
		}
		$options = $options.$optionsLast;
		return $options;
	}
	else return;
}

function get_template_list_select($selected = null) {
	$projectTemplates = Template::where('type','=','project')->get();
	if($projectTemplates != null) {
		$options = '';
		$optionsLast = '';
		foreach($projectTemplates as $type) {
			if($type->status == 'inactive') {
				$options .= '';
			}
			else {
				if($selected == $type->name) $options .= '<option value="'.$type->id.'" selected>'. $type->name .'</option>';
				else $options .= '<option value="'.$type->id.'">'. $type->name .'</option>';			
			}
		}
		return $options;
	}
	else return;
}

function get_project_stage_select($selected = null, $pType = null, $pID = null) {
	//$projectStages = Project::where('status','=','open')->get();
	if($pType == null) {
		$templateStages = Template::where('status','=','active')
						  ->where('type','=','project')
						  ->get();
	}
	else {
		$templateStages = Template::where('status','=','active')
						  ->where('slug','=',$pType)
						  ->where('type','=','project')
						  ->get();
	}
	// if($pID != null) {
	// 	$checklist = ProjectTask::where('project_id','=', $pID)
	// 				 ->get();
	// }
	if($templateStages != null) {
		$checklist = array();
		foreach($templateStages as $template) {
			$newItems = explode("\n",$template->items);
			foreach($newItems as $item) {
				$item = trim($item);
				$newItemsH = strpos($item, '[[h]]');
				if($newItemsH !== false) {
					$checklistParse = str_replace('[[h]]','', $item);
					$checklistParse = $checklistParse;
					$checklist[] = $checklistParse;
				}
			}
		}
	}
	$options = '';
	$stages = array();
	if($checklist != null) {
		foreach($checklist as $stage) {
			if(in_array($stage, $stages) != true) {
				$stages[] = $stage;
				if($selected == convert_title_to_path($stage)) $options .= '<option value="'.convert_title_to_path($stage).'" selected>'.$stage.'</option>';
				else $options .= '<option value="'.convert_title_to_path($stage).'">'.$stage.'</option>';
			}
		}
		return $options;
	}
	else return;
}
function convert_title_to_path($title) {
	$title = trim($title);
	$title = str_replace(" ","-",$title);
	$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
	$title = strip_tags($title);
	$title = strtolower($title);
	return $title;
}

function clean_title($title) {
	$title = htmlspecialchars(strip_tags(trim($title)));
	return ucwords($title);
}

function clean_content($content) {
	// convert script and php tags to pre tags
	
	$content = preg_replace('/<script(.*?)>/i', '<pre class="script">',$content);
	//$content = str_replace('<script>', '<pre class="script">', $content);
	$content = str_replace('</script>', '</pre>', $content);
	$content = str_replace('<?php', '<pre class="php">', $content);
	$content = str_replace('?>', '</pre>', $content);
	return htmlentities($content);
}

function display_content($content, $length = null) {
	if($length != null && strlen($content) >= 100 ) return nl2br(substr(strip_tags(html_entity_decode($content)),0,$length)) . '......';
	// $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	// if(preg_match_all($reg_exUrl, $content, $url)) {
	// 	//dd($url);
	// 	foreach($url[0] as $href) {
	// 		$replacement = "<a href=".$href.">{$href}</a>";
 //            $content = str_replace($href,$replacement,$content);
	// 	}
	// }
	return nl2br(html_entity_decode($content));
}

function upload_path() {
	$attachYear = Carbon::now()->format('Y');
	$yearPath = storage_path().'/uploads/'.$attachYear;
	File::isDirectory($yearPath) or File::makeDirectory($yearPath);

	$attachMonth = Carbon::now()->format('m');
	$monthPath = storage_path().'/uploads/'.$attachYear.'/'.$attachMonth;
	File::isDirectory($monthPath) or File::makeDirectory($monthPath);

	$uploadPath = storage_path().'/uploads/'.$attachYear.'/'.$attachMonth.'/';

	return $uploadPath;
}

function find_mentions($content) {
	$mention = '';
	if(strpos($content, '@insideout') !== false) $mention .= 'insideout ';

	$mentionSearch = "/(@)((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))/is";
	if(preg_match_all($mentionSearch, $content, $mentionFound)) {
		$mentionFound = array_unique($mentionFound[0]);
		foreach($mentionFound as $mentionAdd) {
			$mentionAdd = str_replace('@', '', $mentionAdd);
			$mention .= $mentionAdd . ' ';
		}
	}
	
	return $mention;
}

function display_pingable() {
	$users = User::where('status','!=', 'inactive')->get();
	$pingable = '';
	$pingable .= '<span class="textarea-button ping" id="@insideout ">InsideOut</span>';
	foreach($users as $user) {
		$pingable .= '<span class="textarea-button ping" id="@' . $user->user_path . ' ">' . $user->first_name . ' ' . $user->last_name . '</span>';
	}
	return $pingable;
}

function display_subscribable($selected = null) {
	$users = User::where('status','!=', 'inactive')->get();
	$subscribable = '';
	// $subscribable .= '<span class="subscribe-button subscribe" id="insideout ">InsideOut</span>';
	foreach($users as $user) {
		if($selected == $user->user_path) $subscribable .= '<span class="subscribe-button subscribe subscribe-selected" id="' . $user->user_path . ' ">' . $user->first_name . ' ' . $user->last_name . '</span>';
		else $subscribable .= '<span class="subscribe-button subscribe" id="' . $user->user_path . ' ">' . $user->first_name . ' ' . $user->last_name . '</span>';
	}
	return $subscribable;
}


function find_unread_count($resource) {
	$currentUser = current_user_path();
	$lastMonth = new DateTime('-1 month');
	if($resource == 'articles') {
		$articles = Article::where('created_at','>=',$lastMonth)
					->where('been_read','not like','%'.$currentUser.'%')
					->where('status','!=','draft')
					->get()->count();
		if($articles != 0) return '<span id="linked-to-news" class="linked-to" value="'.$articles.'"><a href="/news/unread/">'.$articles.'</a></span>';
	}
	else return;
}

function find_assigned_count($resource) {
	$currentUser = current_user_path();
	// display projects assigned or part of per user not completed yet
	if($resource == 'projects') {
		$projects = Project::where('assigned_id', '=', Auth::user()->id)
					->where('status','=','open')
					->count();
		if($projects !=0 ) return '<span id="linked-to-projects" class="linked-to" value="'.$projects.'"><a href="/projects/assigned-to/'.Auth::user()->user_path.'">'.$projects.'</a></span>';
	}
	// display billables assigned per user not completed yet
	elseif($resource == 'billables') {
		$billables = '0';
		return '<span id="linked-to-billables" class="linked-to" value="'.$billables.'"><a href="/billables/assigned-to/'.Auth::user()->user_path.'">'.$billables.'</a></span>';
	}
	// display upcoming due dates per user for projects and tasks
	elseif($resource == 'calendar') {
		$calendarP = Project::where('assigned_id', '=', Auth::user()->id)
					->where('end_date', '>=', Carbon::parse('first day of this month this year')->subWeeks(1))
					->where('end_date', '<=', Carbon::parse('last day of this month this year')->addWeeks(1))
					->where('period','=','ending')
					->where('status','=','open')
					->count();
		$calendarB = 0;
		$calendarH = 0;
		$calendar = $calendarP + $calendarB + $calendarH;
		return '<span id="linked-to-calendar" class="linked-to" value="'.$calendar.'"><a href="/calendar/">'.$calendar.'</a></span>';
	}
	// display help assigned per user not completed yet
	elseif($resource == 'help') {
		$help = '0';
		return '<span id="linked-to-help" class="linked-to" value="'.$help.'"><a href="/help/assigned-to/'.Auth::user()->user_path.'">'.$help.'</a></span>';
	}
	// display taks assigned per user not completed yet
	// elseif($resource == 'tasks') {
	// 	$tasks = '0';
	// 	return '<span class="linked-to" value="'.$tasks.'">'.$tasks.'</span>';
	// }
	else return;
}

// function get_projects_list_sidebar() {
// 	$projectsSide = Project::where('status','=','open')
// 					->where('assigned_id','=',Auth::user()->id)
// 					->orderBy('due_date','ASC')
// 					->take(3)
// 					->get();
// 	$pside = '';
// 	foreach($projectsSide as $projectSide) {
// 		$pside .= '<li><a href="/projects/post/'.$projectSide->slug .'" class="projects-item">'. $projectSide->title .'</a> <span>'. Carbon::createFromFormat('Y-m-d H:i:s',$projectSide->due_date)->format('F j') .'</span></li>';
// 	}
// 	return $pside;
// }

function user_last_login($login) {
	//$login = new DateTime($login);
	if(!empty($login)) {
		$login = Carbon::createFromFormat('Y-m-d H:i:s', $login)->format('F j, Y');
		return 'Last Login:<br/> '.$login;
	}
	else return 'Login: null';
}
// Save for later
// function link_to_task(Task $task) {
// 	return link_to_route('user.tasks.show', $task->title, [$task->user->username, $task->id]);
// }