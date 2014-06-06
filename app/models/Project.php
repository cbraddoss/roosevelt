<?php

class Project extends Eloquent {

	protected $fillable = array('title','content','department','priority','stage','subscribed','assigned_id','template_id','account_id','due_date','attachment');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'projects';

	public function getOpenProjects() {
		$projects = Project::where('status','=','open')
					->orderBy('due_date','ASC')
					->paginate(20);

		return $projects;
	}

}