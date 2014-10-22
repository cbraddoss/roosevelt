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
		$articlesCount = $articles->count();

		$currentUser = current_user_path();
		$lastMonth = new DateTime('-1 month');

		$projects = Project::where('assigned_id','=', Auth::user()->id)
					->where('status','=','open')
					->orderBy('due_date','ASC')
					->take(5)
					->get();
		$projectsCount = $projects->count();

		$launches = Project::where('status', '=', 'open')
					->where('period','=','ending')
					->orderBy('end_date','ASC')
					->take(5)
					->get();
		$launchesCount = $launches->count();

		return View::make('dashboard.index', compact('articles','projects','launches','launchesCount','articlesCount','projectsCount'));
	}

}