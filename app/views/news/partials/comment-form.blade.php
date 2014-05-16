<span class="create-something-title">Reply</span>
<div class="page-cover">
</div>
<div id="article-comment-{{ $article->id }}" class="news-article-new-comment create-something-form">
	{{ Form::open( array('id' => 'add-comment-'.$article->id, 'files' => true, 'class' => 'add-comment', 'url' => '/news/article/'.$article->slug.'/comment', 'method' => 'post') ) }}
		
		<div class="form-textarea-buttons">
			<span class="textarea-button-text">Ping a user:</span>
			{{ display_pingable() }}
		</div>

		{{ Form::hidden('article-id', $article->id) }}
		{{ Form::hidden('article-slug') }}

		{{ Form::textarea('content', null, array('placeholder' => 'Post a comment to: ' . $article->title, 'class' => 'comment-content field', 'id' => 'comment-content')) }}

		{{ Form::file('attachment[]', array('multiple', 'class'=>'new-article-attachment')) }}
		
		{{ Form::submit('Post Comment', array('class' => 'save form-button', 'id' => 'add-new-comment') ) }}
<span id="post-reply" class="cancel form-button">Cancel</span>
	{{ Form::close() }}
</div>