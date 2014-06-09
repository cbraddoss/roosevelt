<?php

class TodoController extends \BaseController {

	/**
     * Instantiate a new UsersController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$projects = Project::where('status','=','open')
					->where('assigned_id','=',Auth::user()->id)
					->orderBy('due_date','ASC')
					->paginate(100);
		$billables = '';
		$helps = '';
		return View::make('todo.index',compact('projects','billables','helps'));
	}

}