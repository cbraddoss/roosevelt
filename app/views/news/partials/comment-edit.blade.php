<div class="edit-something-form">
{{ Form::open( array('id' => 'edit-comment-'.$comment->id, 'files' => true, 'class' => 'edit-comment', 'url' => '/news/article/comment/'. $comment->id, 'method' => 'post') ) }}
	
<div class="new-form-field">
	<div class="form-textarea-buttons">
		{{ Form::label('content', 'Ping a user:') }}
		{{ display_pingable() }}
	</div>
</div>

	{{ Form::hidden('article-slug') }}

<div class="new-form-field">
	{{ Form::label('content', 'Content:') }}
	{{ Form::textarea('content', $comment->content, array('class' => 'update-comment-content field', 'id' => 'update-comment-content')) }}
</div>

<div class="new-form-field">
	{{ Form::label('attachment[]', 'Attach file(s):') }}
	{{ Form::file('attachment[]', array('multiple', 'class'=>'update-comment-attachment')) }}
</div>

	{{ Form::submit('Update', array('class' => 'save form-button', 'id' => 'update-comment') ) }}
	<span class="cancel form-button">Cancel</span>
	
@if(!empty($comment->attachment))
<div class="edit-comment-attachments">
	{{ $comment->getCommentAttachments($comment->id,'comment-edit-attachment') }}
</div>

{{ Form::close() }}

@endif
</div>