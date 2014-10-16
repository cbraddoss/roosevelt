<?php

class DashboardController extends \BaseController {

	/**
     * Instantiate a new AdminController instance.
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
		$articles = Article::where('status','=','published')
					->orderBy('created_at','DESC')
					->take(5)
					->get();
		$currentUser = current_user_path();
		$lastMonth = new DateTime('-1 month');
		$articlesCount = Article::where('created_at','>=',$lastMonth)
						 ->where('been_read','not like','%'.$currentUser.'%')
						 ->where('status','!=','draft')
						 ->count();
		$projects = Project::where('assigned_id','=', Auth::user()->id)
					->where('status','=','open')
					->orderBy('due_date','ASC')
					->take(5)
					->get();
		$projectsCount = Project::where('assigned_id', '=', Auth::user()->id)
						 ->where('status','=','open')
						 ->count();
		$launches = Project::where('status', '=', 'open')
					->where('period','=','ending')
					->orderBy('end_date','ASC')
					->take(5)
					->get();
		$launchesCount = Project::where('status', '=', 'open')
						 ->where('period','=','ending')
						 ->orderBy('end_date','ASC')
						 ->count();
		return View::make('dashboard.index', compact('articles','projects','launches','launchesCount','articlesCount','projectsCount'));
	}

}