<?php

use \Mailer;
use \Article;

class ArticlesController extends \BaseController {

	/**
     * Instantiate a new UsersController instance.
     */
    public function __construct(Mailer $mailer, Article $article)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

        $this->mailer = $mailer;

        $this->article = $article;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$articles = $this->article->getOnlyPublished();
		$sticky = $this->article->getOnlySticky();
		if(Request::ajax()) return View::make('news.partials.new');
		else return View::make('news.index', compact('sticky','articles'));
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
 		
 		$validator = Validator::make(Input::only('title','content','show_on_calendar','status', 'attachment'), array(
			'title' => 'required|max:120',
			'content' => 'required',
			'show_on_calendar' => 'size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
			'status' => 'required|in:published,sticky,draft',
			'attachment' => 'mimes:jpg,jpeg,png,gif,pdf',
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
			$newArticle->slug = convert_title_to_path(Input::get('title'));
			$newArticle->author_id = Auth::user()->id;
			$newArticle->status = Input::get('status');
			$newArticle->mentions = find_mentions(Input::get('content'));
			$newArticle->edit_id = Auth::user()->id;
			if(Input::has('show_on_calendar')) $newArticle->show_on_calendar = Carbon::createFromFormat('m/d/Y', Input::get('show_on_calendar'));
			if(Input::hasFile('attachment')) {
				$attachment = Input::file('attachment');
				$fileNames = array();
				foreach($attachment as $attach) {
					$fileName = $attach->getClientOriginalName();
					$fileExtension = $attach->getClientOriginalExtension();
					$currentTime = Carbon::now()->timestamp;
					$attach = $attach->move(upload_path(), $currentTime.'-'.$fileName);
					if($fileExtension != 'pdf') $attachThumbnail = Image::make($attach)->resize(300, null, true)->crop(200,200,0,0)->save(upload_path().'thumbnail-'.$currentTime.'-'.$fileName);
					$fileNames[] = '/uploads/'.Carbon::now()->format('Y').'/'.Carbon::now()->format('m').'/'.$currentTime.'-'.$fileName;
				}
				$newArticle->attachment = serialize($fileNames);
			}
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

			article_ping_email($newArticle);

			$response = array(
				'slug' => $newArticle->slug,
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
							->where('status','!=','draft')
							->orderBy('created_at','DESC')
							->paginate(10);
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
					->where('status','!=','draft')
					->where('created_at','<', $dateMax)
					->orderBy('created_at','DESC')
					->paginate(10);
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
					->where('status','!=','draft')
					->orderBy('created_at','DESC')
					->paginate(10);
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
				->where('status','!=','draft')
				->orderBy('created_at','DESC')
				->paginate(10);
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
					->where('status','!=','draft')
					->orderBy('created_at','DESC')
					->paginate(10);
		return View::make('news.filters.mentions', compact('articles'));
	}

	/**
	 * Return search for scheduled articles
	 *
	 * @return Response
	 */
	public function draftsFilter() {
		$currentUser = Auth::user();
		if($currentUser->userrole == 'admin') {
			$articles = Article::where('status','=','draft')
						->orderBy('created_at','DESC')
						->paginate(10);
			return View::make('news.filters.drafts', compact('articles'));
		}
		else {
			$articles = Article::where('status','=','draft')
						->where('author_id', '=', $currentUser->id)
						->orderBy('created_at','DESC')
						->paginate(10);
			return View::make('news.filters.drafts', compact('articles'));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($article)
	{
		
		$currentUser = Auth::user();
		$article = Article::where('slug', $article)->first();

		if(empty($article)) return Redirect::route('news');
		
		if($article->status == 'draft') {
			if($currentUser->userrole == 'admin' || $article->author_id == $currentUser->id) $testing = ''; 
			else return Redirect::route('news');
		}
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

	public function articleComment($article) {
		$article = Article::where('slug', $article)->first();
		if(empty($article)) return Redirect::route('news');
		
		if($article->status == 'draft') {
			if($currentUser->userrole == 'admin' || $article->author_id == $currentUser->id) $testing = ''; 
			else return Redirect::route('news');
		}
		
		if(Request::ajax()) return View::make('news.partials.comment-form', compact('article'));		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($article)
	{
		$article = Article::where('slug', $article)->first();
		if(Auth::user()->id == $article->author_id || Auth::user()->userrole == 'admin') {
			if(empty($article)) return Redirect::route('news');
			else return View::make('news.partials.edit', compact('article'));
		}
		else return Redirect::to('/news/article/'.$article->slug);
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
			'content' => 'required',
			'show_on_calendar' => 'size:10|regex:/^(\\d{2})(\\/)(\\d{2})(\\/)(\\d{4})/i',
			'status' => 'required|in:published,sticky,draft',
			'attachment' => 'mimes:jpg,jpeg,png,gif,pdf',
		));
		
		if($validator->fails()) {
			$messages = $validator->messages();
			return Redirect::to('/news/article/'.$article.'/edit')->withInput()->withErrors($messages->first());
		}
		else {
			$article = Article::find(Input::get('id'));
			
			$article->title =  clean_title(Input::get('title'));
			$article->content =  clean_content(Input::get('content'));
			$article->slug = convert_title_to_path(Input::get('title'));
			$previousMentions = $article->mentions;
			$article->mentions = find_mentions(Input::get('content'));
			$newMentions = $article->mentions;
			$article->edit_id = Auth::user()->id;
			$article->status = Input::get('status');
			if(Input::has('show_on_calendar')) $article->show_on_calendar = Carbon::createFromFormat('m/d/Y', Input::get('show_on_calendar'));
			if(Input::hasFile('attachment')) {
				$attachment = Input::file('attachment');
				$attachments = array();
				$fileNames = array();
				
				foreach($attachment as $attach) {
					$fileName = $attach->getClientOriginalName();
					$fileExtension = $attach->getClientOriginalExtension();
					$currentTime = Carbon::now()->timestamp;
					// dd($fileExtension);
					$attach = $attach->move(upload_path(), $currentTime.'-'.$fileName);
					if($fileExtension != 'pdf') $attachThumbnail = Image::make($attach)->resize(300, null, true)->crop(200,200,0,0)->save(upload_path().'thumbnail-'.$currentTime.'-'.$fileName);
					$fileNames[] = '/uploads/'.Carbon::now()->format('Y').'/'.Carbon::now()->format('m').'/'.$currentTime.'-'.$fileName;
				}
				// return array(
				// 	'path' => $file->getRealPath(),
				// 	'size' => $file->getClientSize(),
				// 	'mime' => $file->getMimeType(),
				// 	'name' => $file->getClientOriginalName(),
				// 	'extension' => $file->getClientOriginalExtension()
				// 	);
				if(!empty($article->attachment)) {
					$extractAttachment = unserialize($article->attachment);
					$allFiles = array_merge($extractAttachment, $fileNames);
					//dd($allFiles);
					$article->attachment = serialize($allFiles);
				}
				else $article->attachment = serialize($fileNames);
			}

			try
			{
				$article->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				return Redirect::to('/news/article/'.$article->slug.'/edit')->withInput()->with('flash_message_error','Oops, something went wrong. Please try again.');
			}

			if($previousMentions != $newMentions) article_ping_email($article,$previousMentions);

			return Redirect::to('/news/article/'.$article->slug)->with('flash_message_success', '<i>' . $article->title . '</i> successfully updated!');
		}

		return Redirect::to('/news/article/'.$article->slug.'/edit')->with('flash_message_error','Something went wrong. :(');
	}

	public function removeImage($id,$imageName) {
		if(Request::ajax()) {
			if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/news')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
			$article = Article::find($id);
			$attachments = $article->attachment;
			$attachments = unserialize($attachments);
			$imagePath = Input::get('imagePath');
			$imageName = $imagePath;
			$name = array_search($imageName, $attachments);
			if($name !== false) unset($attachments[$name]);
			if(empty($attachments)) $article->attachment = '';
			else $article->attachment = serialize($attachments);
			try
				{
					$article->save();
				} catch(Illuminate\Database\QueryException $e)
				{
					$response = array(
						'errorMsg' => 'Oops, something went wrong. Please try again.',
					);
					return Response::json( $response );
				}

			$response = array(
				'image' => $imageName.' deleted.',
				'path' => '/news/article/'.$article->slug.'/edit',
			);
				
			return Response::json( $response );
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$article = Article::find($id);
		if(Auth::user()->userrole == 'admin' || Auth::user()->id == $article->author_id) {
			$articleTitle = $article->title;
			$article->delete();
			return Redirect::to('/news/')->with('flash_message_error', '<i>' . $articleTitle . '</i> successfully deleted');
		}
	}

}