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