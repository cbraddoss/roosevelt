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
		$tagSelect = $this->tag->getSelectListTags();
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
			$tagsSearched .= '<span value="'.$tag->id.'" class="tags-searched ss-plus">' . $tag->name . '</span>';
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
		$tagSelect = $this->tag->getSelectListTags();
		$pageHeaderTwo = 'Recent Tags';
		$tagsNotFound = 'No tags have been created recently. Be sure to tag all the things!';
		return View::make('tags.index',compact('tags','tagsCount','tagSelect','pageHeaderTwo','tagsNotFound'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function popular()
	{
		$tags = $this->tag->getPopularTags();
		$tagsCount = $tags->count();
		$tagSelect = $this->tag->getSelectListTags();
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
		$tagSelect = $this->tag->getSelectListTags($letter);
		$pageHeaderTwo = 'Starting with (' . ucwords($letter) . ')';
		$tagsNotFound = 'No tags begin with the letter ('. ucwords($letter) .').';
		return View::make('tags.index',compact('tags','tagsCount','tagSelect','pageHeaderTwo','tagsNotFound'));
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
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($name)
	{
		$tag = Tag::where('name','=',$name)->first();
		$tagSelect = $this->tag->getSelectListTags();
		return View::make('tags.single', compact('tag','tagSelect'));
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
