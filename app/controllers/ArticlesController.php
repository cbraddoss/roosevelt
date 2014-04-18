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
		$articles = Article::orderBy('created_at','DESC')
					->where('status','=','published')
					->paginate(5);
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
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/news')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
 		$validator = Validator::make(Input::all(), array(
			'title' => 'required|max:120',
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
			$newArticle->title = clean_title(Input::get('title'));
			$newArticle->content =  clean_content(Input::get('content'));
			$newArticle->link = convert_title_to_path(Input::get('title'));
			$newArticle->author_id = Auth::user()->id;
			$newArticle->status = 'published';
			$newArticle->mentions = find_mentions(Input::get('content'));

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

			send_ping_email($newArticle);

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
	 * Return search for author
	 *
	 * @param  int  $author
	 * @return Response
	 */
	public function authorFilter($author) {
		if(!empty($author)) {
			$userAuthor = find_user_from_path($author);
			if($userAuthor != null)	{
				$articles = Article::where('author_id','=',$userAuthor->id)
							->where('status','=','published')
							->orderBy('created_at','DESC')
							->paginate(5);
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
					->where('status','=','published')
					->where('created_at','<', $dateMax)
					->orderBy('created_at','DESC')
					->paginate(5);
		$date = $date->format('F, Y');
		return View::make('news.filters.date', compact('articles','articlesOlder','date'));
	}

	/**
	 * Return search for unread articles
	 *
	 * @return Response
	 */
	public function unreadFilter() {
		$currentUser = current_user_path();
		$lastMonth = new DateTime('-1 month');
		$articles = Article::where('created_at','>=',$lastMonth)
					->where('been_read','not like','%'.$currentUser.'%')
					->where('status','=','published')
					->orderBy('created_at','DESC')
					->paginate(5);
		return View::make('news.filters.unread', compact('articles'));
	}
	
	/**
	 * Return search for favorite articles
	 *
	 * @return Response
	 */
	public function favoritesFilter() {
		$currentUser = current_user_path();
		$articles = Article::where('favorited','like','%'.$currentUser.'%')
				->where('status','=','published')
				->orderBy('created_at','DESC')
				->paginate(5);
		return View::make('news.filters.favorites', compact('articles'));
	}

	/**
	 * Return search for favorite articles
	 *
	 * @return Response
	 */
	public function favoriteArticle($id) {
		if(Request::ajax()) {
			if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/news')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
			$article = Article::where('id','=',$id)->first();
			if(empty($article)) return Redirect::to('/news');
			else $oldFavorite = $article->favorited;
			if(strpos($oldFavorite, current_user_path() ) !== false) {
				$removeFavorite = str_replace(current_user_path(), '', $oldFavorite);
				$article->favorited = $removeFavorite;
				$article->save();
				$response = array(
					'nofav' => 'Favorite removed!'
				);
			}
			else {
				$article->favorited = $oldFavorite.' '.current_user_path().' ';
				$article->save();
				$response = array(
					'fav' => 'Favorited!'
				);
			}
			
			return Response::json( $response );
		}
	}

	/**
	 * Return search for mentioned articles
	 *
	 * @return Response
	 */
	public function mentionsFilter() {
		$currentUser = current_user_path();
		$articles = Article::where('mentions','like','%'.$currentUser.'%')
					->where('status','=','published')
					->orderBy('created_at','DESC')
					->paginate(5);
		return View::make('news.filters.mentions', compact('articles'));
	}

	/**
	 * Return search for scheduled articles
	 *
	 * @return Response
	 */
	public function draftsFilter() {
		$currentUser = current_user_path();
		$articles = Article::where('status','=','draft')
					->orderBy('created_at','DESC')
					->paginate(5);
		return View::make('news.filters.drafts', compact('articles'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($article)
	{
		$article = Article::where('link', $article)->first();
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($article)
	{
		$article = Article::where('link', $article)->first();
		if(Auth::user()->id == $article->author_id || Auth::user()->userrole == 'admin') {
			if(empty($article)) return Redirect::route('news');
			return View::make('news.partials.edit', compact('article'));
		}
		else return Redirect::to('/news/article/'.$article->link);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($article)
	{
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/news/article/'.$article)->withInput()->with('flash_message_error','Form submission error. Please don\'t do that.');
        
		$validator = Validator::make(Input::all(), array(
			'title' => 'required|max:120',
			'content' => 'required'
		));
		
		if($validator->fails()) {
			$messages = $validator->messages();
			return Redirect::to('/news/article/'.$article)->withInput()->withErrors($messages->first());
		}
		else {
			$article = Article::find(Input::get('id'));
			$article->title =  clean_title(Input::get('title'));
			$article->content =  clean_content(Input::get('content'));
			$article->link = convert_title_to_path(Input::get('title'));
			$article->mentions = find_mentions(Input::get('content'));

			try
			{
				$article->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				return Redirect::to('/news/article/'.$article->link)->withInput()->with('flash_message_error','Oops, something went wrong. Please try again.');
			}
			return Redirect::to('/news/article/'.$article->link)->with('flash_message_success', '<i>' . $article->title . '</i> successfully updated!');
		}

		return Redirect::to('/news/article/'.$article->link)->with('flash_message_error','Something went wrong. :(');
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