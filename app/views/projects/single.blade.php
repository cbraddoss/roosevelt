@extends('layout.main')

@section('page-title')
{{ $project->title .' <small>(Project)</small>' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
@if(Auth::user()->id == $project->author_id || Auth::user()->userrole == 'admin')
		<li>
			<div class="create-something-new">
				<div class="anchor-button"><a class="edit-project edit-link ss-write" href="/projects/post/{{ $project->slug }}/edit">Edit Post</a></div>
			</div>
		</li>
@endif
		<li>
			<span class="ss-check">0/4</span>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">

	<div id="project-{{ $project->id }}" class="projects-post office-post-single" slug="{{ $project->slug }}">
		@if($project->period == 'ending')
		<div class="post-dates">
			<span class="launch-date">Launch Date: {{ Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->format('F j, Y') }}</span>
			<span class="due-date">The {{ ucwords(str_replace('-','', $project->stage)) }} stage assigned to {{ User::find($project->assigned_id)->first_name }} {{ User::find($project->assigned_id)->last_name }} is currently Due on {{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j, Y') }}</span>
		</div>
		@else
		<div class="post-dates">
			<h3>This Project is scheduled to End on {{ $project->end_date->format('F j, Y') }}</h3>
			<span>(Unless closed out, this project will automatically start over)</span>
		</div>
		@endif
		<div class="post-manager">
			<h3>Project Manager:</h3>
			<img src="{{ gravatar_url(User::find($project->author_id)->email,40) }}" alt="{{ User::find($project->author_id)->first_name }} {{ User::find($project->author_id)->last_name }}">
			<p>{{ User::find($project->author_id)->first_name . ' ' . User::find($project->author_id)->last_name }}</p>
		</div>
		<div class="post-assigned-to">
			<h3>Assigned to:</h3>
			<img src="{{ gravatar_url(User::find($project->assigned_id)->email,40) }}" alt="{{ User::find($project->assigned_id)->first_name }} {{ User::find($project->assigned_id)->last_name }}">
			<p>{{ User::find($project->assigned_id)->first_name . ' ' . User::find($project->assigned_id)->last_name }}</p>
		</div>
		<div class="post-subscribed">
			<h3>Subscribed <small>(receives email notifications)</small>:</h3>
		@if($project->author_id == Auth::user()->id || Auth::user()->can_manage == 'yes')
			@foreach($subscribed as $subd)
			@if(!empty($subd))
			<span class="ss-delete" value="{{ $subd }}">{{ ucwords(str_replace('-',' ',$subd)) }}</span>
			@endif
			@endforeach
			<span class="ss-plus"><select class="add-project-sub-list" name="add-project-sub-list"><option value="">Select User</option>{{ get_active_user_list_select() }}</select></span>
		@else
			@foreach($subscribed as $subd)
			@if(!empty($subd))
			<span>{{ ucwords(str_replace('-',' ',$subd)) }}</span>
			@endif
			@endforeach
		@endif
		{{ Form::open( array('id' => 'change-project-sub-'.$project->id, 'class' => 'change-project-sub-form', 'url' => '/projects/singleviewupdate/'.$project->id.'/subscribed', 'method' => 'post') ) }}
			{{ Form::hidden('id', $project->id) }}
		{{ Form::close() }}
		</div>
		<div class="post-content">
			<h3>Project Scope:</h3>
			<p>{{ display_content($project->content) }}</p>
		</div>
		<div class="post-attachment">
			<h3>Attachment(s):</h3>
			{{ $project->getAttachments($project->id) }}
		</div>
		<div class="clear"></div>
		<h3>Project Checklist:</h3>
		<h4>{{ ucwords(str_replace('-',' ', $project->type)) }}</h4>
		<div class="project-checklist">
			{{ $tasks }}
		</div>
		<div class="projects-post-sub office-post-sub">
			<small>Created on: {{ $project->created_at->format('F j, Y') }} by {{ link_to('/projects/assigned-to/'.any_user_path($project->author_id), User::find($project->author_id)->first_name.' '.User::find($project->author_id)->last_name) }}</small>
			
			<small class="right">
			Last edit: {{ $project->updated_at->format('F j, Y h:i:s A') }} by {{ link_to('/projects/assigned-to/'.any_user_path($project->edit_id), User::find($project->edit_id)->first_name.' '.User::find($project->edit_id)->last_name) }}
			</small>
			{{ Form::open( array('id' => 'project-subscribed-'.$project->id, 'class' => 'project-subscribed', 'url' => '/projects/listviewupdate/'.$project->id.'/subscribed', 'method' => 'post') ) }}
				{{ Form::hidden('id', $project->id) }}
			{{ Form::close() }}
		</div>
	</div>
	<div id="projects-post-comment-form" class="create-something-new">
		<span class="projects-button"><button class="post-comment">Reply</button></span>
	</div>
	<h3 class="comment-on">Project Comments:</h3>
	<div id="comments"></div>
	@if($comments->isEmpty())
		<p>No comments yet. Reply to start a conversation on this project!</p>
	@else
		@foreach($comments as $comment)
			@if(Auth::user()->user_path == User::find($comment->author_id)->user_path) 
				<div id="comment-{{ $comment->id }}" class="projects-post-comment current-user-comment office-post-comment">
				<img src="{{ gravatar_url(User::find($comment->author_id)->email,40) }}" class="comment-author-image current-user-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
			@else <div id="comment-{{ $comment->id }}" class="projects-post-comment office-post-comment"><img src="{{ gravatar_url(User::find($comment->author_id)->email,40) }}" class="comment-author-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
			@endif
				<div class="comment-contents">
					<div class="comment-details">
						<small>
							<span class="comment-author" author="{{ User::find($comment->author_id)->first_name }}">{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}</span>
							<span class="comment-time">on 
							@if($comment->created_at->format('Y') == Carbon::now()->format('Y'))
								{{ $comment->created_at->format('F j g:i a') }}
							@else
								{{ $comment->created_at->format('F j, Y g:i a') }}
							@endif
							</span>
							@if(Auth::user()->id == $project->author_id || Auth::user()->userrole == 'admin')
								<span class="comment-edit-button"><a class="edit-link edit-comment">Edit</a></span>
							@endif
						
						<div class="comment-options">
							<div id="comment-post-comment-form" class="create-something-new">
								<span class="comment-reply-button"><button class="post-comment">Reply</button></span>
							</div>
						</div>
						</small>
					</div>
					{{ $comment->getCommentAttachments($comment->id) }}
					<p>{{ display_content($comment->content) }}</p>
				</div>
			</div>
			@foreach($subComments as $subComment)
				@if($subComment->reply_to_id == $comment->id)
					@if(Auth::user()->user_path == User::find($subComment->author_id)->user_path) 
						<div id="comment-{{ $subComment->id }}" class="projects-post-comment current-user-comment office-post-comment office-post-sub-comment">
						<img src="{{ gravatar_url(User::find($subComment->author_id)->email,40) }}" class="comment-author-image current-user-image" alt="{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}">
					@else <div id="comment-{{ $subComment->id }}" class="projects-post-comment office-post-comment office-post-sub-comment"><img src="{{ gravatar_url(User::find($subComment->author_id)->email,40) }}" class="comment-author-image" alt="{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}">
					@endif
						<div class="comment-contents">
							<div class="comment-details">
								<small>
									<span class="comment-author">{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}</span>
									<span class="comment-time">on 
									@if($comment->created_at->format('Y') == Carbon::now()->format('Y'))
										{{ $subComment->created_at->format('F j g:i a') }}
									@else
										{{ $subComment->created_at->format('F j, Y g:i a') }}
									@endif
									</span>
									@if(Auth::user()->id == $project->author_id || Auth::user()->userrole == 'admin')
										<span class="comment-edit-button"><a class="edit-link edit-comment">Edit</a></span>
									@endif
								</small>
							</div>
							{{ $subComment->getCommentAttachments($subComment->id) }}
							<p>{{ display_content($subComment->content) }}</p>
						</div>
					</div>
				@endif
			@endforeach
		@endforeach
	@endif
</div>
@stop