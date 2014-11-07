<?php

class Tag extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tags';

	/**
	 * Search tags and return results
	 *
	 * @return object
	 */
	public function getTagsSearch($search) {
		$tags = Tag::where('name','like','%'.$search.'%')
				   ->orderBy('name','ASC')
				   ->take(20)
				   ->get();

		return $tags;
	}


	/**
	 * Get tag counts
	 *
	 * @return object
	 */
	public function getTagCount($id, $type = null)
	{
		if($type == null) $tagCount = TagRelationship::where('tag_id','=',$id)->count();
		else $tagCount = TagRelationship::where('tag_id','=',$id)->where('type','=',$type)->count();
		return $tagCount;
	}

	/**
	 * Get all tags from the system
	 *
	 * @return object
	 */
	public function getAllTags()
	{
		$tags = Tag::all();

		return $tags;
	}

	/**
	 * Get tags created in last month
	 *
	 * @return object
	 */
	public function getRecentTags()
	{
		$createdMonthAgo = Carbon::now()->subMonth()->format('Y-m-d');
		$tags = Tag::where('created_at','>=',$createdMonthAgo)
				->orderBy('created_at','DESC')
				->get();

		return $tags;
	}

	/**
	 * Get tags and sort by times_used (saving for later, need to figure out a better way to do this)
	 *
	 * @return object
	 */
	public function getPopularTags()
	{
		//$tags = Tag::orderBy('times_used','DESC')
		//		->get();

		//return $tags;
	}

	/**
	 * Get tags created in last month
	 *
	 * @return object
	 */
	public function getTypeTags($type)
	{
		$tagIDs = array();
		$tagTypes = TagRelationship::where('type','=',$type)->get();
		if($tagTypes->isEmpty()) {
			$foundTags = Tag::where('id','=',0)
						 ->get();
		}
		else {
			foreach($tagTypes as $tagType) {
				$tagIDs[] = $tagType->tag_id;
			}
			$tagIDs = array_unique($tagIDs);

			$foundTags = Tag::whereIn('id',$tagIDs)
						 ->orderBy('created_at','DESC')
						 ->get();
		}
		return $foundTags;
	}

	/**
	 * Get tags based on first letter
	 *
	 * @return object
	 */
	public function getFirstLetterTags($letter = null)
	{
		$tags = Tag::where('name','like',$letter.'%')
				->get();

		return $tags;
	}

	/**
	 * Get first letter of tags to make select list of available tags
	 *
	 * @return object
	 */
	public function getLetterSelectListTags($letter = null)
	{
		$tagName = '';
		$tagLetters = array();
		$tagSelect = '';
		$tags = Tag::all();
		foreach($tags as $tag)
		{
			$tagName = $tag->name;
			$tagLetters[] = $tagName[0];
		}
		$tagLetters = array_unique($tagLetters);
		sort($tagLetters);
		foreach($tagLetters as $tagL)
		{
			if(ucwords($letter) == $tagL) $selected = 'selected';
			else $selected = '';
			$tagSelect .= '<option value=' . lcfirst($tagL) . ' ' . $selected . '>' . $tagL . '</option>';
		}
		return $tagSelect;
	}

	/**
	 * Get tags by ID for display
	 *
	 * @return object
	 */
	public function displayTags($typeID, $type)
	{
		$returnTags = '';
		$findRelationship = TagRelationship::where('type_id','=',$typeID)
							->where('type','=',$type)
							->get();
		foreach($findRelationship as $tag) {
			$findTag = Tag::where('id','=',$tag->tag_id)->first();
			if(!empty($findTag)) $returnTags .= '<span class="tag-name"><a id="'.$findTag->id.'" class="tag-id ss-tag" href="/tags/name/'.$findTag->slug.'">'.$findTag->name.'</a></span>';
		}
		return $returnTags;
	}
}