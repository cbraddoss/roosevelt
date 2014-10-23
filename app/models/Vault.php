<?php

class Vault extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'vaults';

	/**
	 * Get all vaults from the system
	 *
	 * @return object
	 */
	public function getAllVaults()
	{
		$vaults = Vault::all();

		return $vaults;
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
			$returnTags .= '<span class="tag-name"><a class="ss-tag" href="/assets/vault/tags/'.$findTag->slug.'">'.$findTag->name.'</a></span>';
		}
		
		return $returnTags;
	}
}