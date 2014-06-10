<?php

class ProjectTask extends Eloquent {

	protected $fillable = array('notes');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'project_tasks';

	public function getTasks($id) {
		$tasks = ProjectTask::where('project_id','=',$id)
					->orderBy('id','ASC')
					->get();
		return $tasks;
	}

}