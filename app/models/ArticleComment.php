<?php

class ArticleComment extends Eloquent {

	protected $fillable = array('content');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'article_comments';

	public function getComments($id) {
		$comments = ArticleComment::where('article_id','=',$id)
					->where('reply_to_id','=',0)
					->orderBy('created_at','ASC')
					->get();
		return $comments;
	}

	public function getSubComments($id) {
		$comments = ArticleComment::where('article_id','=',$id)
					->where('reply_to_id','>',0)
					->orderBy('created_at','ASC')
					->get();
		return $comments;

	}

	public function getCommentAttachments($id,$class = 'comment-single-attachment') {
		$comment = ArticleComment::find($id);
		$articleImage = $comment->attachment;
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
				if(strpos($thumbnail, '.pdf')) $thumbnailsSend .= '<span formlocation="/news/article/comment" class="'.$class.' comment-pdf-attachment"><a href="' . str_replace('thumbnail-','',$thumbnail) .'" target="_blank" rel="gallery-'.$id.'"><img src="/images/pdficon.png" alt="'.$attachmentTitle.'"><span>'.$attachmentTitle.'</span></a></span>';
				else $thumbnailsSend .= '<span formlocation="/news/article/comment" class="'.$class.'"><a href="'. str_replace('thumbnail-','',$thumbnail) .'" rel="gallery-'.$id.'">'. HTML::image($thumbnail, $attachmentTitle, array('class' => 'comment-attachment')).'</a></span>';
			}
		}

		return $thumbnailsSend;
	}

}