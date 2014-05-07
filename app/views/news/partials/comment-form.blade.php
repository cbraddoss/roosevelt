<div id="article-comment-{{ $article->id }}" class="news-article-comment">
	{{ Form::open( array('id' => 'add-comment'.$article->id, 'files' => true, 'class' => 'add-comment', 'url' => '/news/article/'.$article->slug, 'method' => 'post') ) }}
	
		{{ Form::label('content', 'Comment:') }}
		{{ Form::textarea('content', null, array('placeholder' => 'Post a comment to: ' . $article->title, 'class' => 'comment-content field', 'id' => 'comment-content')) }}

		{{ Form::label('attachment[]', 'Attach files:') }}
		{{ Form::file('attachment[]', array('multiple', 'class'=>'new-article-attachment')) }}

		{{ Form::submit('Post Comment', array('class' => 'save form-button', 'id' => 'add-new-comment') ) }}

	{{ Form::close() }}
</div>