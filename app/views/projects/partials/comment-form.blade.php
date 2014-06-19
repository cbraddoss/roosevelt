<div id="project-comment-{{ $project->id }}" class="projects-post-new-comment create-something-form">
	<h3>Comment on {{ $project->title }}:</h3>
	{{ Form::open( array('id' => 'add-comment-'.$project->id, 'files' => true, 'class' => 'add-comment', 'url' => '/projects/post/'.$project->slug.'/comment', 'method' => 'post') ) }}
		
		<div class="new-form-field">
		<div class="form-textarea-buttons">
			{{ Form::label('content', 'Ping a user:') }}
			{{ display_pingable() }}
		</div>
		</div>

		{{ Form::hidden('project-id', $project->id) }}
		{{ Form::hidden('project-slug') }}

		<div class="new-form-field">
		{{ Form::label('content','Comment:') }}
		{{ Form::textarea('content', null, array('placeholder' => 'Post a comment to: ' . $project->title, 'class' => 'comment-content field', 'id' => 'comment-content')) }}
		</div>
		<div class="new-form-field">
		{{ Form::label('attachment[]','Attach File(s):') }}
		{{ Form::file('attachment[]', array('multiple', 'class'=>'projects-post-attachment')) }}
		</div>
		{{ Form::submit('Post Comment', array('class' => 'save form-button', 'id' => 'add-new-comment') ) }}
<span id="post-reply" class="cancel form-button">Cancel</span>
	{{ Form::close() }}
</div>