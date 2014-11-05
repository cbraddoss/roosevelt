<?php

use \Tags;

class TagsController extends \BaseController {

	/**
     * Instantiate a new ProjectsController instance.
     */
    public function __construct(Tag $tag)
    {
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

		$this->tag = $tag;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tags = $this->tag->getAllTags();
		$tagsCount = $tags->count();
		$tagSelect = $this->tag->getLetterSelectListTags();
		$pageHeaderTwo = 'All Tags';
		$tagsNotFound = 'There are currently no tags in the system.';
		return View::make('tags.index',compact('tags','tagsCount','tagSelect','pageHeaderTwo','tagsNotFound'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function search($name) {
		if ( Session::token() !== Input::get( '_token' ) ) return Redirect::to('/projects')->with('flash_message_error','Form submission error. Please don\'t do that.');
 		
		$tags = $this->tag->getTagsSearch($name);
		$tagsSearched = '';
		foreach($tags as $tag) {
			$tagsSearched .= '<span value="'.$tag->id.'" class="tags-searched tag-name"><a class="ss-tag">' . $tag->name . '</a></span>';
		}
		if($tagsSearched != '') {
			$response = array(
				'tagsSearch' => $tagsSearched,
				'msg' => 'found some'
			);
			return Response::json( $response );
		}
		else {
			$response = array(
				'tagsSearch' => $name,
				'msg' => 'none'
			);
			return Response::json($response);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function recent()
	{
		$tags = $this->tag->getRecentTags();
		$tagsCount = $tags->count();
		$tagSelect = $this->tag->getLetterSelectListTags();
		$pageHeaderTwo = 'Recent Tags';
		$tagsNotFound = 'No tags have been created recently. Be sure to tag all the things!';
		return View::make('tags.index',compact('tags','tagsCount','tagSelect','pageHeaderTwo','tagsNotFound'));
	}

	/**
	 * Display a listing of the resource. (saving for later)
	 *
	 * @return Response
	 */
	public function popular()
	{
		$tags = $this->tag->getPopularTags();
		$tagsCount = $tags->count();
		$tagSelect = $this->tag->getLetterSelectListTags();
		$pageHeaderTwo = 'Popular Tags';
		$tagsNotFound = 'No popular tags available. Be sure to tag all the things!';
		return View::make('tags.index',compact('tags','tagsCount','tagSelect','pageHeaderTwo','tagsNotFound'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function letter($letter)
	{
		if(strlen($letter) > 1)
		{
			return Redirect::route('tags');
		}
		$tags = $this->tag->getFirstLetterTags($letter);
		$tagsCount = $tags->count();
		$tagSelect = $this->tag->getLetterSelectListTags($letter);
		$pageHeaderTwo = 'Starting with (' . ucwords($letter) . ')';
		$tagsNotFound = 'No tags begin with the letter ('. ucwords($letter) .').';
		return View::make('tags.index',compact('tags','tagsCount','tagSelect','pageHeaderTwo','tagsNotFound'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function type($type)
	{
		if($type == 'Type Filter')
		{
			return Redirect::route('tags');
		}
		$tags = $this->tag->getTypeTags($type);
		$tagsCount = $tags->count();
		$tagSelect = $this->tag->getLetterSelectListTags();
		$pageHeaderTwo = 'Tags for (' . ucwords($type) . ')';
		$tagsNotFound = 'No tags for ('. ucwords($type) .'). Be sure to tag all the things!';
		return View::make('tags.index',compact('tags','tagsCount','tagSelect','pageHeaderTwo','tagsNotFound','type'));
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
	public function store($name)
	{
		$newTag = new Tag;
		$newTag->name = clean_title($name);
		$newTag->slug = convert_title_to_path($name);
		if(Input::get('tagsAddToExisting') == 'add-to-existing') {
			$tagsAddToExisting = 'add-to-existing';
		}
		else $tagsAddToExisting = '';
		try
		{
			$newTag->save();
		} catch(Illuminate\Database\QueryException $e)
		{
			$response = array(
				'actionType' => 'tag-add',
				'errorMsg' => 'Oops, there was a problem saving a tag. Please try again.'
			);
			return Response::json( $response );
		}
		$response = array(
			'actionType' => 'tag-add',
			'saved' => 'saved',
			'tagsAddToExisting' => $tagsAddToExisting,
			'tagID' => $newTag->id,
			'tagname' => $newTag->name,
			'msg' => 'Tag successfully added to system!'
		);
		return Response::json( $response );
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($name)
	{
		$tag = Tag::where('slug','=',$name)->first();
		$tagSelect = $this->tag->getLetterSelectListTags();
		//Find resources using this tag. This could be fun
		

		$accountTagRelationships = TagRelationship::where('tag_id','=',$tag->id)
					->where('type','=','account')
					->orderBy('created_at','DESC')
					->get();
		foreach($accountTagRelationships as $tagAccount) {
			$accountIDs[] = $tagAccount->type_id;
		}
		if(!empty($accountIDs)) $accountIDs = array_unique($accountIDs);
		else $accountIDs = array(0);
		$accounts = Account::whereIn('id',$accountIDs)
					 ->orderBy('created_at','DESC')
					 ->get();


		$projectTagRelationships = TagRelationship::where('tag_id','=',$tag->id)
					->where('type','=','project')
					->orderBy('created_at','DESC')
					->get();
		foreach($projectTagRelationships as $tagProject) {
			$projectIDs[] = $tagProject->type_id;
		}
		if(!empty($projectIDs)) $projectIDs = array_unique($projectIDs);
		else $projectIDs = array(0);
		$projects = Project::whereIn('id',$projectIDs)
					 ->orderBy('created_at','DESC')
					 ->get();


		// billables

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


		// help

		// invoices

		$vaultTagRelationships = TagRelationship::where('tag_id','=',$tag->id)
					->where('type','=','vault')
					->orderBy('created_at','DESC')
					->get();
		foreach($vaultTagRelationships as $tagVault) {
			$vaultIDs[] = $tagVault->type_id;
		}
		if(!empty($vaultIDs)) $vaultIDs = array_unique($vaultIDs);
		else $vaultIDs = array(0);
		$vaults = Vault::whereIn('id',$vaultIDs)
					 ->orderBy('created_at','DESC')
					 ->get();

		// assets
		
		// personal

		return View::make('tags.single', compact('tag','tagSelect','vaults','accounts','projects','articles'));
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
