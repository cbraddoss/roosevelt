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

function display_calendar() {
	$daysThisMonth = Carbon::now()->daysInMonth;
	$daysLastMonth = Carbon::now()->addMonth(-1)->daysInMonth;
	$calendar = '';
	$monthFirstDay = Carbon::parse('first day of this month this year')->format('w');
	$p = $daysLastMonth;
	for($m=1; $m<=$monthFirstDay; $m++) {
		$calendar .= '<span class="day last-month"><small>' . Carbon::parse('last month this year')->format('F') . '</small>' . Carbon::parse('first day of this month this year')->addDays($m-$p)->format('d') . '</span>';
	}
	for($i=1; $i<=$daysThisMonth; $i++) {

		$calendar .= '<span class="day this-month">' . $i . '</span>';
	}
	$monthLastWeek = Carbon::parse('last day of this month this year')->format('w');
	$n=0;
	for($w=6; $w>$monthLastWeek; $w--) {
		$calendar .= '<span class="day last-month"><small>' . Carbon::parse('next month this year')->format('F') . '</small>' . Carbon::parse('first day of next month this year')->addDays($n++)->format('d') . '</span>';
	}
	return $calendar;
}

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