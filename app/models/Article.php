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

	public function getAttachments($id,$class = 'article-single-attachment') {
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
				if(strpos($thumbnail, '.pdf')) $thumbnailsSend .= '<span class="right '.$class.' article-pdf-attachment"><a href="' . str_replace('thumbnail-','',$thumbnail) .'" target="_blank" rel="gallery-'.$id.'"><img src="/images/pdficon.png" alt="'.$attachmentTitle.'"><span>'.$attachmentTitle.'</span></a></span>';
				else $thumbnailsSend .= '<span class="right '.$class.'"><a href="'. str_replace('thumbnail-','',$thumbnail) .'" rel="gallery-'.$id.'">'. HTML::image($thumbnail, $attachmentTitle, array('class' => 'article-attachment')).'</a></span>';
			}
		}

		return $thumbnailsSend;
	}
}