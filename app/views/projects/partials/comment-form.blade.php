<span class="create-something-title">Reply</span>
<div class="page-cover">
</div>
<div id="project-comment-{{ $project->id }}" class="projects-post-new-comment create-something-form">
	<h3>Comment on {{ $project->title }}:</h3>
	{{ Form::open( array('id' => 'add-comment-'.$project->id, 'files' => true, 'class' => 'add-comment', 'url' => '/projects/post/'.$project->slug.'/comment', 'method' => 'post') ) }}
		
		<div class="form-textarea-buttons">
			<span class="textarea-button-text">Ping a user:</span>
			{{ display_pingable() }}
		</div>

		{{ Form::hidden('project-id', $project->id) }}
		{{ Form::hidden('project-slug') }}

		{{ Form::textarea('content', null, array('placeholder' => 'Post a comment to: ' . $project->title, 'class' => 'comment-content field', 'id' => 'comment-content')) }}

		{{ Form::file('attachment[]', array('multiple', 'class'=>'projects-post-attachment')) }}
		
		{{ Form::submit('Post Comment', array('class' => 'save form-button', 'id' => 'add-new-comment') ) }}
<span id="post-reply" class="cancel form-button">Cancel</span>
	{{ Form::close() }}
</div>