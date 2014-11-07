<?php

class Article extends Eloquent {

	protected $fillable = array('title','content');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'articles';

	public function getOnlyPublished() {
		$articles = Article::where('status','=','published')
					->orderBy('created_at','DESC')
					->paginate(10);

		return $articles;
	}

	public function getOnlySticky() {
		$articles = Article::orderBy('created_at','DESC')
					->where('status','=','sticky')->get();

		return $articles;
	}

	public function getCommentsCount($id) {
		$commentsCount = ArticleComment::where('article_id','=',$id)->count();
		return $commentsCount;
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
			if(!empty($findTag)) $returnTags .= '<span class="tag-name"><a id="'.$findTag->id.'" class="tag-id ss-tag" href="/news/tags/'.$findTag->slug.'">'.$findTag->name.'</a></span>';
		}
		return $returnTags;
	}

	/**
	 * Get all tags for artcile posts
	 *
	 * @return object
	 */
	public function getSelectListTags($select = null)
	{
		$articleTagRelationships = TagRelationship::where('type','=','article')
					->orderBy('created_at','DESC')
					->get();
		foreach($articleTagRelationships as $tagArticle) {
			$tagIDs[] = $tagArticle->tag_id;
		}
		if(!empty($tagIDs)) $tagIDs = array_unique($tagIDs);
		else $tagIDs = array(0);
		$tags = Tag::whereIn('id',$tagIDs)
					 ->orderBy('name','ASC')
					 ->get();

		$articlesTagsSelect = '';
		foreach($tags as $tag) {
			if($select == $tag->slug) $articlesTagsSelect .= '<option value="'.$tag->slug.'" selected>'.$tag->name.'</option>';
			else $articlesTagsSelect .= '<option value="'.$tag->slug.'">'.$tag->name.'</option>';
		}
		return $articlesTagsSelect;
	}

	/**
	 * Get attachments by ID for display
	 *
	 * @return string
	 */
	public function getAttachments($id,$class = 'post-single-attachment') {
		$article = Article::find($id);
		$articleImage = $article->attachment;
		$thumbnails = array();
		if(!empty($articleImage)) {
			foreach(unserialize($articleImage) as $attachment) {
				$getThumbnail = substr_replace($attachment, 'thumbnail-',17,0);
				$thumbnails[] = $getThumbnail;
			}
		}
		$thumbnailsSend = '';
		if(!empty($thumbnails)) {
			foreach($thumbnails as $thumbnail) {
				$attachmentTitle = preg_replace('/(\\/)(uploads)(\\/)(\\d+)(\\/)(\\d+)(\\/)(thumbnail)(-)(\\d+)(-)/is', '', $thumbnail);
				if(strpos($thumbnail, '.pdf')) $thumbnailsSend .= '<span formlocation="/news/article" class="'.$class.' post-pdf-attachment article-pdf-attachment"><a href="' . str_replace('thumbnail-','',$thumbnail) .'" target="_blank" rel="gallery-'.$id.'"><img src="/images/pdficon.png" alt="'.$attachmentTitle.'"><span>'.$attachmentTitle.'</span></a></span>';
				else $thumbnailsSend .= '<span formlocation="/news/article" class="'.$class.'"><a href="'. str_replace('thumbnail-','',$thumbnail) .'" rel="gallery-'.$id.'">'. HTML::image($thumbnail, $attachmentTitle, array('class' => 'article-attachment post-attachment')).'</a></span>';
			}
		}

		return $thumbnailsSend;
	}
}