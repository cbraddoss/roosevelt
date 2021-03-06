<?php

use \Mailer;
use \Article;
use \ArticleComment;

class ArticlesController extends \BaseController {

	protected $mailer;
	/**
     * Instantiate a new ArticlesController instance.
     */
    public function __construct(Mailer $mailer, Article $article, ArticleComment $articleComment, Tag $tag, TagRelationship $tagRelationship)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

        $this->mailer = $mailer;

        $this->article = $article;

        $this->articleComment = $articleComment;

		$this->tag = $tag;

		$this->tagRelationship = $tagRelationship;
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
		$articleTagsSelect = $this->article->getSelectListTags();
		$articlesCount = Article::where('status','=','published')->count();
		$stickyCount = Article::where('status','=','sticky')->count();
		$articlesCount = $articlesCount + $stickyCount;
		return View::make('news.index', compact('sticky','articles','articleTagsSelect','articlesCount'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Request::ajax()) return View::make('news.partials.new');
		else return Redirect::to('/news');
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
			'attachment[]' => 'mimes:jpg,jpeg,png,gif,pdf',
		));

		if($validator->fails()) {
			$messages = $validator->messages();
			$response = array(
				'actionType' => 'article-add',
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
					'actionType' => 'article-add',
					'errorMsg' => 'Oops, there might be an article with this title already. Try a different title.'
				);
				return Response::json( $response );
			}

			$newTagFail = '';
			if(Input::has('tag_id')) {
				$parseTags = Input::get('tag_id');
				$parseTags = explode(',', $parseTags);
				$parseTags = array_unique($parseTags);
				foreach($parseTags as $parseTag) {
					if(is_numeric($parseTag)) {
						$newTagRelationship = $this->tagRelationship->newRelationship($parseTag, 'article', $newArticle->id);
						if($newTagRelationship == 'fail') {
							$newTagFail = '(Note: Tag Error. Please try again.)';
						}
					}
					else {
						$newTagFail = '(Note: Tag Error. Please try again.)';
					}
				}
			}

			if(!empty($newArticle->mentions)) $this->mailer->articlePingEmail($newArticle);
			
			$hcMessage = '';
			$hcMessage .= User::find($newArticle->author_id)->first_name.' '.User::find($newArticle->author_id)->last_name.' has posted a News article:<br />';
			$hcMessage .= '<a href="/news/article/'.$newArticle->slug.'">'. $newArticle->title.'</a>';
			$hcMessageSend = hipchat_message($hcMessage);
			if($hcMessageSend != 'messageSent') {
				$response = array(
					'actionType' => 'article-add',
					'windowAction' => '/news/article/'.$newArticle->slug,
					'msg' => 'Article created successfully! (Note: '.$hcMessageSend.')'
				);
				return Response::json( $response );
			}

			$response = array(
				'actionType' => 'article-add',
				'windowAction' => '/news/article/'.$newArticle->slug,
				'msg' => 'Article created successfully! '.$newTagFail
			);
			return Response::json( $response );
		}
		$response = array(
			'actionType' => 'article-add',
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
		$articleTagsSelect = $this->article->getSelectListTags();
		if(!empty($author)) {
			$userAuthor = find_user_from_path($author);
			if($userAuthor != null)	{
				$articles = Article::where('author_id','=',$userAuthor->id)
							->where('status','!=','draft')
							->orderBy('created_at','DESC')
							->paginate(10);
				$articlesCount = Article::where('author_id','=',$userAuthor->id)
								 ->where('status','!=','draft')
								 ->count();
				return View::make('news.filters.author', compact('articles','userAuthor','articleTagsSelect','articlesCount'));
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
		$articleTagsSelect = $this->article->getSelectListTags();
		$date = new DateTime($year.'-'.$month.'-'.'01');
		$dateMax = new DateTime($year.'-'.$month.'-'.'01');
		$dateMax->modify('+1 month');		
		$articles = Article::where('created_at','>=', $date)
					->where('status','!=','draft')
					->where('created_at','<', $dateMax)
					->orderBy('created_at','DESC')
					->paginate(10);
		$articlesCount = Article::where('created_at','>=', $date)
						 ->where('status','!=','draft')
						 ->where('created_at','<', $dateMax)
						 ->count();
		$date = $date->format('F, Y');
		return View::make('news.filters.date', compact('articles','articlesOlder','date','articleTagsSelect','articlesCount'));
	}

	/**
	 * Return search for unread articles
	 *
	 * @return Response
	 */
	public function unreadFilter() {
		$articleTagsSelect = $this->article->getSelectListTags();
		$currentUser = current_user_path();
		$lastMonth = new DateTime('-1 month');
		$articles = Article::where('created_at','>=',$lastMonth)
					->where('been_read','not like','%'.$currentUser.'%')
					->where('status','!=','draft')
					->orderBy('created_at','DESC')
					->paginate(10);
		$articlesCount = Article::where('created_at','>=',$lastMonth)
					->where('been_read','not like','%'.$currentUser.'%')
					->where('status','!=','draft')
					->count();
		return View::make('news.filters.unread', compact('articles','articleTagsSelect','articlesCount'));
	}
	
	/**
	 * Return search for favorite articles
	 *
	 * @return Response
	 */
	public function favoritesFilter() {
		$articleTagsSelect = $this->article->getSelectListTags();
		$currentUser = current_user_path();
		$articles = Article::where('favorited','like','%'.$currentUser.'%')
				->where('status','!=','draft')
				->orderBy('created_at','DESC')
				->paginate(10);
		$articlesCount = Article::where('favorited','like','%'.$currentUser.'%')
						 ->where('status','!=','draft')
						 ->count();
		return View::make('news.filters.favorites', compact('articles','articleTagsSelect','articlesCount'));
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
					'fav' => 'Favorite added!'
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
		$articleTagsSelect = $this->article->getSelectListTags();
		$currentUser = current_user_path();
		$articles = Article::where('mentions','like','%'.$currentUser.'%')
					->where('status','!=','draft')
					->orderBy('created_at','DESC')
					->paginate(10);
		$articlesCount = Article::where('mentions','like','%'.$currentUser.'%')
						 ->where('status','!=','draft')
						 ->count();
		return View::make('news.filters.mentions', compact('articles','articleTagsSelect','articlesCount'));
	}

	/**
	 * Return search for scheduled articles
	 *
	 * @return Response
	 */
	public function draftsFilter() {
		$articleTagsSelect = $this->article->getSelectListTags();
		$currentUser = Auth::user();
		if($currentUser->userrole == 'admin') {
			$articles = Article::where('status','=','draft')
						->orderBy('created_at','DESC')
						->paginate(10);
			$articlesCount = Article::where('status','=','draft')->count();
			return View::make('news.filters.drafts', compact('articles','articleTagsSelect','articlesCount'));
		}
		else {
			$articles = Article::where('status','=','draft')
						->where('author_id', '=', $currentUser->id)
						->orderBy('created_at','DESC')
						->paginate(10);
			$articlesCount = Article::where('status','=','draft')->count();
			return View::make('news.filters.drafts', compact('articles','articleTagsSelect','articlesCount'));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function tagsFilter($tag)
	{
		if($tag == 'Tag Filter') return Redirect::to('/news');

		$articleTagsSelect = $this->article->getSelectListTags($tag);
		$tag = Tag::where('slug','=',$tag)->first();
		
		$articleTagRelationships = TagRelationship::where('tag_id','=',$tag->id)
					->where('type','=','article')
					->orderBy('created_at','DESC')
					->get();
		foreach($articleTagRelationships as $tagArticle) {
			$articleIDs[] = $tagArticle->type_id;
		}
		if(!empty($articleIDs)) $articleIDs = array_unique($articleIDs);
		else $articleIDs = array(0);
		$articles = Article::whereIn('id',$articleIDs)
					 ->orderBy('created_at','DESC')
					 ->get();
		$articlesCount = Article::whereIn('id',$articleIDs)->count();
		
		return View::make('news.filters.tags', compact('tag','articles','articleTagsSelect','articlesCount'));
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
		$comments = $this->articleComment->getComments($article->id);
		$subComments = $this->articleComment->getSubComments($article->id);
		if($article) return View::make('news.single', compact('article','comments','subComments'));
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
		$article = Article::where('slug', $article)->first();
		if(Auth::user()->id == $article->author_id || Auth::user()->userrole == 'admin') {
			if(empty($article)) return Redirect::route('news');
			else return View::make('news.edit', compact('article'));
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
			'attachment[]' => 'mimes:jpg,jpeg,png,gif,pdf',
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
				//dd($attachment);
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

			if($previousMentions != $newMentions) $this->mailer->articlePingEmail($article,$previousMentions);

			return Redirect::to('/news/article/'.$article->slug)->with('flash_message_success', '<i>' . $article->title . '</i> successfully updated!');
		}

		return Redirect::to('/news/article/'.$article->slug.'/edit')->with('flash_message_error','Something went wrong. :(');
	}

	/**
	 * Update the article on single view pages.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateOnSingleView($id, $value)
	{
		if(Request::ajax()) {
			if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/news')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
			$article = Article::where('id','=',$id)->first();
			if(empty($article)) return Redirect::to('/news');
			else $oldValue = $article->$value;
			
			if(Input::has('attachnewtag') == 'attachtag') {

		 		$validator = Validator::make(Input::all(), array(
					'tag_id' => 'required|integer',
					'type_id' => 'required|integer'
				));

				if($validator->fails()) {
					$messages = $validator->messages();
					$response = array(
						'actionType' => 'article-update',
						'errorMsg' => $messages->first()
					);
					return Response::json( $response );
				}

				$articleId = Input::get('type_id');
				$parseTags = Input::get('tag_id');
				$parseTags = explode(',', $parseTags);
				$parseTags = array_unique($parseTags);
				foreach($parseTags as $parseTag) {
					if(is_numeric($parseTag)) {
						$newTagRelationship = $this->tagRelationship->newRelationship($parseTag, 'article', $articleId);
						if($newTagRelationship == 'fail') {
							$response = array(
								'actionType' => 'article-update',
								'errorMsg' => 'Oops, there was a problem attaching the tag(s). Please try again.'
							);
							return Response::json( $response );
						}
						if($newTagRelationship == 'existing') {
							$response = array(
								'actionType' => 'article-update',
								'errorMsg' => 'This tag is already attached to this Article.'
							);
							return Response::json( $response );
						}
					}
					else {
						$response = array(
							'actionType' => 'article-update',
							'errorMsg' => 'Oops, there was a problem attaching the tag(s). Please try again.'
						);
						return Response::json( $response );
					}
				}

				$response = array(
					'actionType' => 'article-update',
					'tagsText' => Input::get('tagsText'),
					'tagID' => Input::get('tag_id'),
					'msg' => 'Tag added successfully!'
				);
				return Response::json( $response );

			}
			if(Input::has('detachtag') == 'detachtag') {
				$validator = Validator::make(Input::all(), array(
					'tag_id' => 'required|integer',
					'type_id' => 'required|integer'
				));
				if($validator->fails()) {
					$messages = $validator->messages();
					$response = array(
						'actionType' => 'tag-detach',
						'errorMsg' => $messages->first()
					);
					return Response::json( $response );
				}
				$tagID = Input::get('tag_id');
				$type = 'article';
				$typeID = Input::get('type_id');

				$findExisitingRelationship = TagRelationship::where('tag_id','=',$tagID)
											 ->where('type','=',$type)
											 ->where('type_id','=',$typeID)
											 ->first();
				try
				{
					$findExisitingRelationship->delete();
				} catch(Illuminate\Database\QueryException $e)
				{
					$response = array(
						'actionType' => 'tag-detach',
						'errorMsg' => 'Oops, there was a problem removing the tag. Please try again.'
					);
					return Response::json( $response );
				}

				$response = array(
					'actionType' => 'tag-detach',
					'tagsText' => Input::get('tagsText'),
					'msg' => 'Tag removed successfully!'
				);
				return Response::json( $response );
			}
			
			return Response::json( $response );
		}
		else return Redirect::route('news');
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
						'actionType' => 'attachment-delete',
						'errorMsg' => 'Oops, something went wrong. Please try again.',
					);
					return Response::json( $response );
				}

			$response = array(
				'actionType' => 'attachment-delete',
				'msg' => 'Attachment removed.',
				//'windowAction' => '/news/article/'.$article->slug.'/edit',
				'image' => $imageName,
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
		else return Redirect::route('news');
	}

}