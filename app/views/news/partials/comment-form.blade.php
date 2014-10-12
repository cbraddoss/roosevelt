<div id="article-comment-{{ $article->id }}" class="news-article-new-comment create-something-form">
<h2>Comment on {{ $article->title }}:</h2>
{{ Form::open( array('id' => 'add-comment-'.$article->id, 'files' => true, 'class' => 'add-comment', 'url' => '/news/article/'.$article->slug.'/comment', 'method' => 'post') ) }}
		
<div class="new-form-field">
<div class="form-textarea-buttons form-action-buttons">
{{ Form::label('content', 'Ping a user:') }}
{{ display_pingable() }}
</div>
</div>

{{ Form::hidden('article-id', $article->id) }}
{{ Form::hidden('article-slug') }}

<div class="new-form-field">
{{ Form::label('content','Comment:') }}
{{ Form::textarea('content', null, array('placeholder' => 'Post a comment to: ' . $article->title, 'class' => 'comment-content field', 'id' => 'comment-content')) }}
</div>
		
<div class="new-form-field">
{{ Form::label('attachment[]','Attach File(s):') }}
{{ Form::file('attachment[]', array('multiple', 'class'=>'new-article-attachment')) }}
</div>
		
{{ Form::submit('Post Comment', array('class' => 'save form-button', 'id' => 'add-new-comment') ) }}
<span id="post-reply" class="cancel form-button">Cancel</span>
{{ Form::close() }}
</div>