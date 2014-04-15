<?php

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

function find_user_from_path($user) {
	$user = explode('-',$user);
	$user = User::where('first_name','=', ucwords($user[0]))
			->where('last_name','=', ucwords($user[1]))
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

function convert_title_to_link($base_url, $title, $class = null) {
	$link = str_replace(' ','-',$title);
	$link = strtolower($link);
	return '<a href="'.$base_url.'/'.$link.'" alt="'.$title.'" class="'.$class.'">'.$title.'</a>';
}

function convert_link_to_title($link) {
	$title = str_replace('-',' ',$link);
	$title = ucwords($title);
	return $title;
}

function display_content($content) {
	$content =  nl2br($content);
	return $content;
}

function find_unread_count($resource) {
	$currentUser = current_user_path();
	$lastMonth = new DateTime('-1 month');
	if($resource == 'articles') {
		$articles = Article::where('created_at','>=',$lastMonth)
					->where('been_read','not like','%'.$currentUser.'%')->get()->count();
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