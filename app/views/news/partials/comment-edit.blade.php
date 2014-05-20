<div class="edit-something-form">
{{ Form::open( array('id' => 'edit-comment-'.$comment->id, 'files' => true, 'class' => 'edit-comment', 'url' => '/news/article/comment/'. $comment->id, 'method' => 'post') ) }}
	
	<div class="form-textarea-buttons">
		<span class="textarea-button-text">Ping a user:</span>
		{{ display_pingable() }}
	</div>

	{{ Form::hidden('article-slug') }}

	{{ Form::textarea('content', $comment->content, array('class' => 'update-comment-content field', 'id' => 'update-comment-content')) }}

	{{ Form::file('attachment[]', array('multiple', 'class'=>'update-comment-attachment')) }}
	
	<span class="cancel form-button">Cancel</span>

	{{ Form::submit('Update', array('class' => 'save form-button', 'id' => 'update-comment') ) }}
	
@if(!empty($comment->attachment))
<div class="edit-comment-attachments">
	{{ $comment->getCommentAttachments($comment->id,'comment-edit-attachment') }}
</div>

{{ Form::close() }}

@endif
</div>