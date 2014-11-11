<?php

class Account extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'accounts';

	public function getAccountsSearch($search) {
		$accounts = Account::where('name','like','%'.$search.'%')
				   ->where('status','=','active')
				   ->orderBy('name','ASC')
				   ->take(10)
				   ->get();

		return $accounts;
	}

	/**
	 * Get tags by ID for display
	 *
	 * @return string
	 */
	public function displayTags($typeID, $type)
	{
		$returnTags = '';
		$findRelationship = TagRelationship::where('type_id','=',$typeID)
							->where('type','=',$type)
							->get();
		foreach($findRelationship as $tag) {
			$findTag = Tag::where('id','=',$tag->tag_id)->first();
			if(!empty($findTag)) $returnTags .= '<span class="tag-name"><a id="'.$findTag->id.'" class="tag-id ss-tag" href="/accounts/tags/'.$findTag->slug.'">'.$findTag->name.'</a></span>';
		}
		return $returnTags;
	}
}