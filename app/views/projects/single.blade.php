@extends('layout.main')

@section('page-title')
{{ $project->title }}
@stop


@section('page-content')
<div id="projects-page"  class="inner-page">

	@include('projects.partials.sub-menu')
	
	<div id="project-{{ $project->id }}" class="projects-post office-post-single">
		<p class="post-manager">Project manager: {{ User::find($project->author_id)->first_name . ' ' . User::find($project->author_id)->last_name }}</p>
		<div class="post-subscribed">Subscribed:
		@if($project->author_id == Auth::user()->id || Auth::user()->userrole == 'admin')
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
			
		{{ $project->getAttachments($project->id) }}
		<p>{{ display_content($project->content) }}</p>
		<div class="project-checklist">
			{{ $tasks }}
		</div>
		<div class="projects-post-sub office-post-sub">
			<small>Created on: {{ $project->created_at->format('F j, Y') }}</small>
			
			<small class="right">
			@if(Auth::user()->id == $project->author_id || Auth::user()->userrole == 'admin')
			<a class="edit-project edit-link" href="/projects/{{ $project->department }}/{{ $project->slug }}/edit">Edit Post</a>
			@endif
			Last edit: {{ $project->updated_at->format('F j, Y h:i:s A') }} by {{ User::find($project->edit_id)->first_name }} {{ User::find($project->edit_id)->last_name }}</small>
			{{ Form::open( array('id' => 'project-subscribed-'.$project->id, 'class' => 'project-subscribed', 'url' => '/projects/listviewupdate/'.$project->id.'/subscribed', 'method' => 'post') ) }}
				{{ Form::hidden('id', $project->id) }}
			{{ Form::close() }}
		</div>
	</div>
	<div id="comments"></div>
	@foreach($comments as $comment)
	@if(Auth::user()->user_path == User::find($comment->author_id)->user_path) 
		<div id="comment-{{ $comment->id }}" class="projects-post-comment current-user-comment office-post-comment">
		<img src="{{ gravatar_url(User::find($comment->author_id)->email,40) }}" class="comment-author-image current-user-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
	@else <div id="comment-{{ $comment->id }}" class="projects-post-comment office-post-comment"><img src="{{ gravatar_url(User::find($comment->author_id)->email,40) }}" class="comment-author-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
	@endif
		<div class="comment-contents">
			<div class="comment-details">
				<small>
					<span class="comment-author">{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}</span>
					<span class="comment-time">on 
					@if($comment->created_at->format('Y') == Carbon::now()->format('Y'))
						{{ $comment->created_at->format('F j g:i a') }}
					@else
						{{ $comment->created_at->format('F j, Y g:i a') }}
					@endif
					</span>
					@if(Auth::user()->id == $project->author_id || Auth::user()->userrole == 'admin')
						<span class="comment-edit-button"><button class="edit-link edit-comment">Edit</button></span>
					@endif
				</small>
				
				<div class="comment-options">
					<div id="comment-post-comment-form" class="create-something-new">
						<span class="comment-reply-button"><button class="post-comment">Reply</button></span>
					</div>
				</div>
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
								<span class="comment-edit-button"><button class="edit-link edit-comment">Edit</button></span>
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
</div>
@stop