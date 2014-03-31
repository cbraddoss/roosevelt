<?php

function gravatar_url($email,$size = '40') {
	return 'http://www.gravatar.com/avatar/' . md5($email) . '?s=' . $size;
}

function user_path() {
	return lcfirst(Auth::user()->first_name) . '-' . lcfirst(Auth::user()->last_name);
}

function convert_title_to_link($base_url, $title) {
	$link = str_replace(' ','-',$title);
	$link = strtolower($link);
	return '<a href="/'.$base_url.'/'.$link.'" alt="'.$title.'">'.$title.'</a>';
}

function convert_link_to_title($link) {
	$title = str_replace('-',' ',$link);
	$title = ucwords($title);
	return $title;
}
// Save for later
// function link_to_task(Task $task) {
// 	return link_to_route('user.tasks.show', $task->title, [$task->user->username, $task->id]);
// }