<?php

class TagRelationship extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tag_relationships';

	/**
	 * Update Tag Relationship
	 *
	 * @return object
	 */
	public function newRelationship($tagID, $type, $typeID) {
		$findExisitingRelationship = TagRelationship::where('tag_id','=',$tagID)
									 ->where('type','=',$type)
									 ->where('type_id','=',$typeID)
									 ->first();
		if(!empty($findExisitingRelationship)) {
			return 'existing';
		}
		$newTagRelationship = new TagRelationship;
		$newTagRelationship->tag_id = $tagID;
		$newTagRelationship->type = $type;
		$newTagRelationship->type_id = $typeID;
		
		try
		{
			$newTagRelationship->save();
		} catch(Illuminate\Database\QueryException $e)
		{
			return 'fail';
		}

		return $newTagRelationship;
	}

}