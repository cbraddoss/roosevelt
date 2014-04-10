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
		$articles = Article::orderBy('created_at','DESC')->take(3)->get();
		return View::make('dashboard.index', compact('articles'));
	}

}