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
	 * Get all tags for vault items
	 *
	 * @return object
	 */
	public function getSelectListVaultTags($select = null)
	{
		$vaultTagRelationships = TagRelationship::where('type','=','vault')
					->orderBy('created_at','DESC')
					->get();
		foreach($vaultTagRelationships as $tagVault) {
			$tagIDs[] = $tagVault->tag_id;
		}
		if(!empty($tagIDs)) $tagIDs = array_unique($tagIDs);
		else $tagIDs = array(0);
		$tags = Tag::whereIn('id',$tagIDs)
					 ->orderBy('created_at','DESC')
					 ->get();

		$vaultsTagsSelect = '';
		foreach($tags as $tag) {
			if($select == $tag->slug) $vaultsTagsSelect .= '<option value="'.$tag->slug.'" select>'.$tag->name.'</option>';
			else $vaultsTagsSelect .= '<option value="'.$tag->slug.'">'.$tag->name.'</option>';
		}
		return $vaultsTagsSelect;
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
			if(!empty($findTag)) $returnTags .= '<span class="tag-name"><a class="ss-tag" href="/assets/vault/tags/'.$findTag->slug.'">'.$findTag->name.'</a></span>';
		}
		return $returnTags;
	}

	/**
	 * Get vault attachment
	 *
	 * @return object
	 */
	public function getAttachments($id,$class = 'post-single-attachment') {
		$vault = Vault::find($id);
		$vaultImage = $vault->attachment;
		$thumbnails = array();
		if(!empty($vaultImage)) {
			foreach(unserialize($vaultImage) as $attachment) {
				$getThumbnail = substr_replace($attachment, 'thumbnail-',17,0);
				$thumbnails[] = $getThumbnail;
			}
		}
		$thumbnailsSend = '';
		if(!empty($thumbnails)) {
			foreach($thumbnails as $thumbnail) {
				$attachmentTitle = preg_replace('/(\\/)(uploads)(\\/)(\\d+)(\\/)(\\d+)(\\/)(thumbnail)(-)(\\d+)(-)/is', '', $thumbnail);
				if(strpos($thumbnail, '.pdf')) $thumbnailsSend .= '<span class="'.$class.' post-pdf-attachment"><a href="' . str_replace('thumbnail-','',$thumbnail) .'" target="_blank" rel="gallery-'.$id.'"><img src="/images/pdficon.png" alt="'.$attachmentTitle.'"><span>'.$attachmentTitle.'</span></a></span>';
				else $thumbnailsSend .= '<span class="'.$class.'"><a href="'. str_replace('thumbnail-','',$thumbnail) .'" rel="gallery-'.$id.'">'. HTML::image($thumbnail, $attachmentTitle, array('class' => 'post-attachment')).'</a></span>';
			}
		}

		return $thumbnailsSend;
	}
}