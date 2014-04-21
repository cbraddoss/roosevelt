<?php
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
	//$user = explode('-',$user);
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
	return htmlentities($content);
}

function display_content($content, $length = null) {
	if($length != null && strlen($content) >= 100 ) return nl2br(substr(strip_tags(html_entity_decode($content)),0,$length)) . '......';
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	if(preg_match_all($reg_exUrl, $content, $url)) {
		//dd($url);
		foreach($url[0] as $href) {
			$replacement = "<a href=".$href." target='_blank'>{$href}</a>";
            $content = str_replace($href,$replacement,$content);
		}
	}
	return nl2br(html_entity_decode($content));
}

function find_mentions($content) {
	$mentionSearch = "/(@)((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))/is";
	$mention = '';
	if(preg_match_all($mentionSearch, $content, $mentionFound)) {
		foreach($mentionFound[0] as $mentionAdd) {
			$mentionAdd = str_replace('@', '', $mentionAdd);
			$mention .= $mentionAdd . ' ';
		}
	}
	return $mention;
}

function send_ping_email($newArticle) {
	$parseUsers = $newArticle->mentions;
	$parseUsers = explode(' ',$parseUsers);
	$users = array();
	foreach($parseUsers as $user) {
		if($user == '') unset($user);
		else {
			$users[] = $user;
		}
	}
	foreach($users as $user) {
		$userSend = User::where('user_path','=',$user)->first();
		//dd($userSend);
		$author = User::where('id', '=', $newArticle->author_id)->first();
		$pingDetails = array('title' => $newArticle->title, 'link' => 'http://roosevelt.insideout.com/news/article/'.$newArticle->link, 'author' => $author->first_name . ' ' . $author->last_name, 'created_at' => $newArticle->created_at);
		Mail::send('emails.ping', $pingDetails, function($message) use($userSend) {
			$message->from('office@insideout.com', 'InsideOut Employee Remote Office');
			$message->to($userSend->email, $userSend->first_name . ' ' . $userSend->last_name)->subject('You have been pinged!');
		});
	}
}

function display_pingable() {
	$users = User::all();
	$pingable = array();
	foreach($users as $user) {
		echo '<span class="textarea-button ping" id="@' . $user->user_path . '">' . $user->first_name . ' ' . $user->last_name . '</span>';
	}
}

// function display_calendar() {
// 	// Start a clean calendar variable
// 	$calendar = '';
	
// 	// Get last days of previous month to start calendar view (if needed)
// 	// get number of days in previous month
// 	$daysLastMonth = Carbon::now()->addMonth(-1)->daysInMonth;
// 	// get Sunday-Saturday numeric value of first day in this month
// 	$monthFirstDay = Carbon::parse('first day of this month this year')->format('w');
// 	$p = $daysLastMonth;
// 	for($m=1; $m<=$monthFirstDay; $m++) {
// 		$calendar .= '<span class="day last-month"><small>' . Carbon::parse('last month this year')->format('F') . '</small><span class="day-num">' . Carbon::parse('last day of last month this year')->addDays($m-2)->format('j') . '</span></span>';
// 	}
	
// 	// Populate current month calendar view
// 	// get number of days in current month
// 	$daysThisMonth = Carbon::now()->daysInMonth;
// 	// get Articles with show_on_calendar
// 	$articleShow = Article::where('show_on_calendar', '!=', '0000-00-00 00:00:00')
// 					->where('status','published')
// 					->get();
// 	//dd($articleShow);
// 	$articleThisMonth = array();
// 	$articleNextMonth = array();
// 	foreach($articleShow as $aShow) {
// 		$aNum = Carbon::createFromFormat('Y-m-d H:i:s', $aShow->show_on_calendar)->format('j');
// 		$aMonth = Carbon::createFromFormat('Y-m-d H:i:s', $aShow->show_on_calendar)->format('m');
// 		//dd($aMonth);
// 		$aShow->title = ( (strlen($aShow->title) >= '15') ? $aShow->title = substr($aShow->title, 0, 15).'...' : $aShow->title);
// 		if($aMonth == Carbon::now()->format('m')) {
// 			if(array_key_exists($aNum, $articleThisMonth)) $articleThisMonth[$aNum] .= '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
// 			else $articleThisMonth[$aNum] = '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
// 			//$articleTitleThisMonth[$aNum] = $aShow->title;
// 			//$articleLinkThisMonth[$aNum] = $aShow->link;
// 		}
// 		if($aMonth == Carbon::now()->addMonth(1)->format('m')) {
// 			if(array_key_exists($aNum, $articleNextMonth)) $articleNextMonth[$aNum] .= '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
// 			else $articleNextMonth[$aNum] = '<a href="/news/article/' . $aShow->link . '" class="calendar-post-title news-article-link">' . $aShow->title . '</a>';
// 			// $articleTitleNextMonth[$aNum] = $aShow->title;
// 			// $articleLinkNextMonth[$aNum] = $aShow->link;
// 		}
// 	}
// 	//dd($articleTitle);
// 	for($i=1; $i<=$daysThisMonth; $i++) {
// 		$today = ( (Carbon::today()->format('j') == $i) ? $today = 'today' : $today = '');
// 		if(!empty($articleThisMonth[$i])) $calendar .= '<span class="day ' . $today . ' this-month">' . $articleThisMonth[$i] . '<span class="day-num">' . $i . '</span></span>';
// 		else $calendar .= '<span class="day ' . $today . ' this-month"><span class="day-num">' . $i . '</span></span>';
	
// 	}
	
// 	// Get first days of next month to fill out calendar view (if needed)
// 	// get Sunday-Saturday numeric value of last day in this month
// 	$monthLastWeek = Carbon::parse('last day of this month this year')->format('w');
// 	$n=0;
// 	for($w=6; $w>$monthLastWeek; $w--) {
// 		if(!empty($articleNextMonth[$n+1])) $calendar .= '<span class="day next-month">' . $articleNextMonth[$n+1] . '<span class="day-num">' . Carbon::parse('first day of next month this year')->addDays($n++)->format('j') . '</span></span>';
// 		else $calendar .= '<span class="day next-month"><small>' . Carbon::parse('next month this year')->format('F') . '</small><span class="day-num">' . Carbon::parse('first day of next month this year')->addDays($n++)->format('j') . '</span></span>';
// 		//else $calendar .= '<span class="day next-month">' . Carbon::parse('first day of next month this year')->addDays($n++)->format('j') . '</span>';
// 	}
	
// 	return $calendar;
// }

function find_unread_count($resource) {
	$currentUser = current_user_path();
	$lastMonth = new DateTime('-1 month');
	if($resource == 'articles') {
		$articles = Article::where('created_at','>=',$lastMonth)
					->where('been_read','not like','%'.$currentUser.'%')
					->where('status','=','published')
					->get()->count();
		if($articles != 0) return '<span class="linked-to">'.$articles.'</span>';
	}
	else return;
}

function find_assigned_count($resource) {
	$currentUser = current_user_path();
	if($resource == 'projects') {
		$projects = '2';
		return '<span class="linked-to">'.$projects.'</span>';
	}
	elseif($resource == 'billables') {
		$billables = '5';
		return '<span class="linked-to">'.$billables.'</span>';
	}
	elseif($resource == 'calendar') {
		$calendar = '10';
		return '<span class="linked-to">'.$calendar.'</span>';
	}
	elseif($resource == 'help') {
		$help = '8';
		return '<span class="linked-to">'.$help.'</span>';
	}
	else return;
}

function user_last_login($login) {
	$login = new DateTime($login);
	$login = $login->format('F j, Y');
	if($login != 'November 30, -0001') return 'Last Login:<br/> '.$login;
	else return 'Login: null';
}
// Save for later
// function link_to_task(Task $task) {
// 	return link_to_route('user.tasks.show', $task->title, [$task->user->username, $task->id]);
// }