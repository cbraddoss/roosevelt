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
				if(strpos($thumbnail, '.pdf')) $thumbnailsSend .= '<span class="right article-pdf-attachment"><a href="' .public_path(). str_replace('thumbnail-','',$thumbnail) .'" target="_blank"><img src="/images/pdficon.png" alt="'.$attachmentTitle.'"></a></span>';
				else $thumbnailsSend .= '<span class="right '.$class.'"><a href="'. str_replace('thumbnail-','',$thumbnail) .'">'. HTML::image($thumbnail, $attachmentTitle, array('class' => 'article-attachment')).'</a></span>';
			}
		}

		return $thumbnailsSend;
	}
}