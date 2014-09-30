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
		$projects = Project::where('assigned_id','=', Auth::user()->id)
					->where('status','=','open')
					->orderBy('due_date','ASC')
					->take(5)
					->get();
		$launches = Project::where('status', '=', 'open')
					->where('period','=','ending')
					->orderBy('end_date','ASC')
					->take(5)
					->get();
		//$token = 'af008533a3040e34fcea88cea6336d';
		//$hc = new HipChat\HipChat($token);
		//$hc->message_room('Developer Talk', 'Remote Office', ' <img src="https://dujrsrsgsd3nh.cloudfront.net/img/emoticons/156684/hipbot-1408733978.png" width="30" height="30">: Testing the bot.');
		return View::make('dashboard.index', compact('articles','projects','launches'));
	}

}