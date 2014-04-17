<?php

class Article extends Eloquent {

	protected $fillable = array('title','content');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'articles';

	public function getAllPublished() {
		$articles = Article::where('status','=','published')
					->orderBy('created_at','DESC')
					->paginate(5);
		return $articles;
	}
}