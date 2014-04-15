<?php

class ArticlesController extends \BaseController {

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
		$articles = Article::orderBy('created_at','DESC')->paginate(5);
		if(Request::ajax()) return View::make('news.partials.new');
		else return View::make('news.index', compact('articles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/admin/users/')->withInput()->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
 		$validator = Validator::make(Input::all(), array(
			'title' => 'required|max:60',
			'content' => 'required'
		));

		if($validator->fails()) {
			$messages = $validator->messages();
			$response = array(
				'errorMsg' => $messages->first()
			);
			return Response::json( $response );
		}
		else {
			$newArticle = new Article;
			$newArticle->title =  Input::get('title');
			$newArticle->content =  Input::get('content');
			$newArticle->link = e(str_replace(' ', '-', strtolower(Input::get('title'))));
			$newArticle->author_id = Auth::user()->id;



			try
			{
				$newArticle->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				$response = array(
					'errorMsg' => 'Oops, there might be an article with this title already. Try a different title.'
				);
				return Response::json( $response );
			}
			$response = array(
				'msg' => 'Article saved.'
			);
			return Response::json( $response );
		}
		$response = array(
			'errorMsg' => 'Something went wrong. :('
		);
		return Response::json( $response );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($article)
	{
		
		$article = convert_link_to_title($article);
		$article = Article::where('title', $article)->first();
		$userRead = current_user_path();
		if(empty($article)) return Redirect::route('news');
		else $oldRead = $article->been_read;
		if(strpos($oldRead,$userRead) !== false) {
			$article->been_read = $oldRead;
		}
		else {
			$article->been_read = $oldRead.' '.$userRead.' ';
			$article->save();
		}
		if($article) return View::make('news.single', compact('article'));
		else return Redirect::route('news');
	}

	/**
	 * Return search for author
	 *
	 * @param  int  $author
	 * @return Response
	 */
	public function authorFilter($author) {
		if(!empty($author)) {
			$userAuthor = find_user_from_path($author);
			if($userAuthor != null)	{
				$articles = Article::where('author_id','=',$userAuthor->id)->paginate(5);
				return View::make('news.filters.author', compact('articles','userAuthor'));
			}
			else return Redirect::route('news');
		}
		else return Redirect::route('news');
	}

	/**
	 * Return search for date
	 *
	 * @param  int  $date
	 * @return Response
	 */
	public function dateFilter($year, $month) {
		$date = new DateTime($year.'-'.$month.'-'.'01');
		$dateMax = new DateTime($year.'-'.$month.'-'.'01');
		$dateMax->modify('+1 month');		
		$articles = Article::where('created_at','>=', $date)
					->where('created_at','<', $dateMax)
					->paginate(5);
		$date = $date->format('F, Y');
		return View::make('news.filters.date', compact('articles','articlesOlder','date'));
	}

	/**
	 * Return search for date
	 *
	 * @param  int  $date
	 * @return Response
	 */
	public function unreadFilter() {
		$currentUser = current_user_path();
		$lastMonth = new DateTime('-1 month');
		$articles = Article::where('created_at','>=',$lastMonth)
					->where('been_read','not like','%'.$currentUser.'%')
					->paginate(5);
		return View::make('news.filters.unread', compact('articles'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}