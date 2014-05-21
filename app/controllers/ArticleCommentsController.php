<?php

class ArticleCommentsController extends \BaseController {

	/**
     * Instantiate a new CommentsController instance.
     */
	public function __construct(Mailer $mailer, Article $article, ArticleComment $articleComment)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

        $this->mailer = $mailer;

        $this->article = $article;

        $this->articleComment = $articleComment;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
 		
 		$validator = Validator::make(Input::only('content', 'article-id', 'article-slug', 'attachment'), array(
			'content' => 'required',
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
			$newArticleComment = new ArticleComment;
			$newArticleComment->article_id = Input::get('article-id');
			$newArticleComment->content =  clean_content(Input::get('content'));
			$newArticleComment->author_id = Auth::user()->id;
			$newArticleComment->mentions = find_mentions(Input::get('content'));
			$newArticleComment->edit_id = Auth::user()->id;
			if(Input::has('reply_to_id')) $newArticleComment->reply_to_id = Input::get('reply_to_id');
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
				$newArticleComment->attachment = serialize($fileNames);
			}

			try
			{
				$newArticleComment->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				$response = array(
					'errorMsg' => 'Oops, something went wrong. Please contact the DevTeam.'
				);
				return Response::json( $response );
			}

			article_comment_ping_email($newArticleComment);

			$response = array(
				'slug' => Input::get('article-slug'),
				'comment_id' => $newArticleComment->id,
				'msg' => 'Comment posted.'
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
		$article = Article::where('slug', $article)->first();
		if(empty($article)) return Redirect::route('news');
		
		if($article->status == 'draft') {
			if($currentUser->userrole == 'admin' || $article->author_id == $currentUser->id) $testing = ''; 
			else return Redirect::route('news');
		}
		
		if(Request::ajax()) return View::make('news.partials.comment-form', compact('article'));
		else return Redirect::to('/news/article/'.$article->slug);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$comment = ArticleComment::find($id);
		if(empty($comment)) return Redirect::route('news');
		if(Auth::user()->id == $comment->author_id || Auth::user()->userrole == 'admin') {
			if(Request::ajax()) return View::make('news.partials.comment-edit', compact('comment'));
			else return Redirect::to('/news');
		}
		else return Redirect::to('/news');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/news')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
 		$validator = Validator::make(Input::only('content', 'article-slug', 'attachment'), array(
			'content' => 'required',
			'attachment' => 'mimes:jpg,jpeg,png,gif,pdf',
		));
		
		$articleSlug = Input::get('article-slug');

		if($validator->fails()) {
			$messages = $validator->messages();
			return Redirect::to('/news/article/'.$articleSlug)->withInput()->withErrors($messages->first());
		}
		else {
			$commentUpdate = ArticleComment::find($id);

			$commentUpdate->content =  clean_content(Input::get('content'));
			$previousMentions = $commentUpdate->mentions;
			$commentUpdate->mentions = find_mentions(Input::get('content'));
			$newMentions = $commentUpdate->mentions;
			$commentUpdate->edit_id = Auth::user()->id;
			
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

				if(!empty($commentUpdate->attachment)) {
					$extractAttachment = unserialize($commentUpdate->attachment);
					$allFiles = array_merge($extractAttachment, $fileNames);
					//dd($allFiles);
					$commentUpdate->attachment = serialize($allFiles);
				}
				else $commentUpdate->attachment = serialize($fileNames);
			}

			try
			{
				$commentUpdate->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				return Redirect::to('/news/article/'.$articleSlug)->with('flash_message_error','Oops, something went wrong. Please contact the DevTeam.');
			}

			if($previousMentions != $newMentions) article_comment_ping_email($commentUpdate,$previousMentions);
			
			return Redirect::to('/news/article/'.$articleSlug.'/?comment=edit#comment-'.$commentUpdate->id)->with('flash_message_success', 'Comment successfully updated!');
		}

		return Redirect::to('/news/article/'.$articleSlug)->with('flash_message_error','Something went wrong. :(');
	}

	public function removeImage($id,$imageName) {
		if(Request::ajax()) {
			if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/news')->with('flash_message_error','Form submission error. Please don\'t do that.');
 			
			$articleSlug = Input::get('article-slug');

			$comment = ArticleComment::find($id);
			$attachments = $comment->attachment;
			$attachments = unserialize($attachments);
			$imagePath = Input::get('imagePath');
			$imageName = $imagePath;
			$name = array_search($imageName, $attachments);
			if($name !== false) unset($attachments[$name]);
			if(empty($attachments)) $comment->attachment = '';
			else $comment->attachment = serialize($attachments);
			try
				{
					$comment->save();
				} catch(Illuminate\Database\QueryException $e)
				{
					$response = array(
						'errorMsg' => 'Oops, something went wrong. Please try again.',
					);
					return Response::json( $response );
				}

			$response = array(
				'image' => $imageName,
				'path' => '/news/article/'.$articleSlug,
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
		//
	}


}
