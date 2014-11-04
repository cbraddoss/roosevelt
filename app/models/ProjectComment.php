<?php

class ProjectComment extends Eloquent {

	protected $fillable = array('content');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'project_comments';

	public function getComments($id) {
		$comments = ProjectComment::where('project_id','=',$id)
					->where('reply_to_id','=',0)
					->orderBy('created_at','ASC')
					->get();
		return $comments;
	}

	public function getSubComments($id) {
		$comments = ProjectComment::where('project_id','=',$id)
					->where('reply_to_id','>',0)
					->orderBy('created_at','ASC')
					->get();
		return $comments;

	}

	public function getCommentAttachments($id,$class = 'comment-single-attachment') {
		$comment = ProjectComment::find($id);
		$projectImage = $comment->attachment;
		$thumbnails = array();
		if(!empty($projectImage)) {
			foreach(unserialize($projectImage) as $attachment) {
				$getThumbnail = substr_replace($attachment, 'thumbnail-',17,0);
				$thumbnails[] = $getThumbnail;
			}
		}
		$thumbnailsSend = '';
		if(!empty($thumbnails)) {
			foreach($thumbnails as $thumbnail) {
				$attachmentTitle = preg_replace('/(\\/)(uploads)(\\/)(\\d+)(\\/)(\\d+)(\\/)(thumbnail)(-)(\\d+)(-)/is', '', $thumbnail);
				if(strpos($thumbnail, '.pdf')) $thumbnailsSend .= '<span formlocation="/projects/post/comment" class="'.$class.' comment-pdf-attachment"><a href="' . str_replace('thumbnail-','',$thumbnail) .'" target="_blank" rel="gallery-'.$id.'"><img src="/images/pdficon.png" alt="'.$attachmentTitle.'"><span>'.$attachmentTitle.'</span></a></span>';
				else $thumbnailsSend .= '<span formlocation="/projects/post/comment" class="'.$class.'"><a href="'. str_replace('thumbnail-','',$thumbnail) .'" rel="gallery-'.$id.'">'. HTML::image($thumbnail, $attachmentTitle, array('class' => 'comment-attachment')).'</a></span>';
			}
		}

		return $thumbnailsSend;
	}

}