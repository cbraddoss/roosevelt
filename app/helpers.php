<?php

function gravatar_url($email,$size = '40') {
	return 'http://www.gravatar.com/avatar/' . md5($email) . '?s=' . $size;
}

function user_path() {
	return lcfirst(Auth::user()->first_name) . '-' . lcfirst(Auth::user()->last_name);
}

function convert_title_to_link($base_url, $title, $class = null) {
	$link = str_replace(' ','-',$title);
	$link = strtolower($link);
	return '<a href="/'.$base_url.'/'.$link.'" alt="'.$title.'" class="'.$class.'">'.$title.'</a>';
}

function convert_link_to_title($link) {
	$title = str_replace('-',' ',$link);
	$title = ucwords($title);
	return $title;
}

function find_unread_count($resource) {
	$currentUser = user_path();
	$count = '';
	if($resource == 'articles') {
		$articles = Article::where('been_read','not like','%'.$currentUser.'%')->get()->count();
		if($articles != 0) return '<span class="ss-chat"></span><span class="linked-to">'.$articles.'</span>';
	}
	elseif($resource == 'projects') {
		$projects = '2';
		return '<span class="ss-chat"></span><span class="linked-to">'.$projects.'</span>';
	}
	elseif($resource == 'billables') {
		$billables = '5';
		return '<span class="ss-chat"></span><span class="linked-to">'.$billables.'</span>';
	}
	elseif($resource == 'calendar') {
		$calendar = '10';
		return '<span class="ss-chat"></span><span class="linked-to">'.$calendar.'</span>';
	}
	elseif($resource == 'help') {
		$help = '8';
		return '<span class="ss-chat"></span><span class="linked-to">'.$help.'</span>';
	}
	else return;
}
// Save for later
// function link_to_task(Task $task) {
// 	return link_to_route('user.tasks.show', $task->title, [$task->user->username, $task->id]);
// }