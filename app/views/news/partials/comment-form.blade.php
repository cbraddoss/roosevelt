<div class="page-cover">
</div>
<div id="article-comment-{{ $article->id }}" class="news-article-new-comment create-something-form">
	{{ Form::open( array('id' => 'add-comment'.$article->id, 'files' => true, 'class' => 'add-comment', 'url' => '/news/article/'.$article->slug.'/comment', 'method' => 'post') ) }}
	
		{{ Form::textarea('content', null, array('placeholder' => 'Post a comment to: ' . $article->title, 'class' => 'comment-content field', 'id' => 'comment-content')) }}

		{{ Form::label('attachment[]', 'Attach files:', array('class' => 'comment-attachment-label')) }}
		{{ Form::file('attachment[]', array('multiple', 'class'=>'new-article-attachment')) }}

		{{ Form::submit('Post Comment', array('class' => 'save form-button', 'id' => 'add-new-comment') ) }}

	{{ Form::close() }}
</div>