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
	 * Get tags and sort by times_used
	 *
	 * @return object
	 */
	public function getPopularTags()
	{
		$tags = Tag::orderBy('times_used','DESC')
				->get();

		return $tags;
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
	public function getSelectListTags($letter = null)
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
	public function displayTags($ids)
	{
		$returnTags = '';
		$parseTags = $ids;
		$parseTags = explode(',', $parseTags);
		$parseTags = array_unique($parseTags);
		foreach($parseTags as $tag) {
			$findTag = Tag::where('id','=',$tag)->first();
			$returnTags .= '<span class="tag-name"><a class="ss-tag" href="/assets/vault/tags/'.$tag->name.'">'.$tag->name.'</a></span>';
		}
		
		return $returnTags;
	}
}