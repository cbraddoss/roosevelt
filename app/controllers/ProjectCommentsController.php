<?php

use \Mailer;
use \Project;
use \ProjectComment;

class ProjectCommentsController extends \BaseController {

	protected $mailer;
	/**
     * Instantiate a new CommentsController instance.
     */
	public function __construct(Mailer $mailer, Project $project, ProjectComment $projectComment)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

        $this->mailer = $mailer;

        $this->project = $project;

        $this->projectComment = $projectComment;
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
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/projects')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
 		$validator = Validator::make(Input::only('content', 'project-id', 'project-slug', 'attachment'), array(
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
			$newProjectComment = new ProjectComment;
			$newProjectComment->project_id = Input::get('project-id');
			$newProjectComment->content =  clean_content(Input::get('content'));
			$newProjectComment->author_id = Auth::user()->id;
			$newProjectComment->mentions = find_mentions(Input::get('content'));
			$newProjectComment->edit_id = Auth::user()->id;
			if(Input::has('reply_to_id')) $newProjectComment->reply_to_id = Input::get('reply_to_id');
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
				$newProjectComment->attachment = serialize($fileNames);
			}

			try
			{
				$newProjectComment->save();
			} catch(Illuminate\Database\QueryException $e)
			{
				$response = array(
					'errorMsg' => 'Oops, something went wrong. Please contact the DevTeam.'
				);
				return Response::json( $response );
			}

			//$this->mailer->articleCommentPingEmail($newProjectComment);
			
			$response = array(
				'slug' => Input::get('project-slug'),
				'department' => Input::get('project-department'),
				'comment_id' => $newProjectComment->id,
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
	public function show($project)
	{
		$project = Project::where('slug', $project)->first();
		if(empty($project)) return Redirect::route('projects');
				
		if(Request::ajax()) return View::make('projects.partials.comment-form', compact('project'));
		else return Redirect::to('/projects/'.$project->department.'/'.$project->slug);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$comment = ProjectComment::find($id);
		if(empty($comment)) return Redirect::route('projects');
		if(Auth::user()->id == $comment->author_id || Auth::user()->userrole == 'admin') {
			if(Request::ajax()) return View::make('projects.partials.comment-edit', compact('comment'));
			else return Redirect::to('/projects');
		}
		else return Redirect::to('/projects');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/projects')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
 		$validator = Validator::make(Input::only('content', 'project-slug', 'attachment'), array(
			'content' => 'required',
			'attachment' => 'mimes:jpg,jpeg,png,gif,pdf',
		));
		
		$projectSlug = Input::get('project-slug');
		$projectGet = Project::where('slug','=',$projectSlug)->first();
		$projectDept = $projectGet->department;

		if($validator->fails()) {
			$messages = $validator->messages();
			return Redirect::to('/projects/'.$projectDept.'/'.$projectSlug)->withInput()->withErrors($messages->first());
		}
		else {
			$commentUpdate = ProjectComment::find($id);

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
				return Redirect::to('/projects/'.$projectDept.'/'.$projectSlug)->with('flash_message_error','Oops, something went wrong. Please contact the DevTeam.');
			}

			//$this->mailer->articleCommentPingEmail($commentUpdate,$previousMentions);
			
			return Redirect::to('/projects/'.$projectDept.'/'.$projectSlug.'/?comment=edit#comment-'.$commentUpdate->id)->with('flash_message_success', 'Comment successfully updated!');
		}

		return Redirect::to('/projects/'.$projectDept.'/'.$projectSlug)->with('flash_message_error','Something went wrong. :(');
	}

	public function removeImage($id,$imageName) {
		if(Request::ajax()) {
			if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/projects')->with('flash_message_error','Form submission error. Please don\'t do that.');
 			
			$projectSlug = Input::get('project-slug');
			$projectDept = Input::get('project-department');

			$comment = ProjectComment::find($id);
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
				'path' => '/projects/'.$projectDept.'/'.$projectSlug,
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
