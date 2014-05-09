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
					->orderBy('created_at','ASC')
					->get();
		return $comments;
	}

}