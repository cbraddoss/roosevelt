<div class="update-something-form">
{{ Form::open( array('id' => 'edit-comment-'.$comment->id, 'files' => true, 'class' => 'update-something edit-comment', 'url' => '/projects/post/comment/'. $comment->id, 'method' => 'post') ) }}
	
<div class="new-form-field">
<div class="form-textarea-buttons form-action-buttons">
{{ display_pingable() }}
</div>
</div>

{{ Form::hidden('project-slug') }}

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

{{ Form::close() }}

@if(!empty($comment->attachment))
<div class="new-form-field edit-comment-attachments">
<p>Current Attachment(s):</p>
{{ $comment->getCommentAttachments($comment->id,'comment-edit-attachment edit-this-attachment') }}
</div>
@endif


</div>