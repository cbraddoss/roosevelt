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
	$title = htmlspecialchars(strip_tags(trim(strtolower($title))),ENT_QUOTES);
	$title = str_replace(" ","-",$title);
	return $title;
}

// function convert_title_to_link($base_url, $title, $class = null) {
// 	$link = str_replace(" ","-",$title);
// 	$link = str_replace("'","",$link);
// 	$link = strtolower($link);
// 	return '<a href="'.$base_url.'/'.$link.'" alt="'.$title.'" class="'.$class.'">'.$title.'</a>';
// }

function clean_article_title($title) {
	$title = strip_tags(trim($title));
	return $title;
}

function clean_article_content($content) {
	return $content;
}

function display_content($content) {
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