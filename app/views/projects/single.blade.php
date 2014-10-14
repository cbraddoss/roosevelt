@extends('layout.main')

@section('page-h1')
{{ 'Projects' }}
@stop

@section('page-h2')
{{ $project->title }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
@if($project->period == 'ending')
			<div class="post-dates">
				<div class="post-date-box">
					<span class="post-date-icon ss-uploadcloud"></span>
					
					<span class="post-date">{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->format('l - F j') }}</span>
					
					<div class="post-date-subbox">
						@if(Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date) > Carbon::now()->addMonth())
						<span>(Launch date ~ {{ Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->diffForHumans() }})</span>
						@elseif(Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date) > Carbon::now()->addDays(6))
						<span>(Launch date ~ {{ Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->diffForHumans() }})</span>
						@else
						<span>(Launch date is {{ Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->diffForHumans() }})</span>
						@endif
					</div>
				</div>
			</div>
@else
			<div class="post-dates">
				<div class="post-date-box">
					<span class="post-date-icon ss-refresh"></span>
					
					<span class="post-date">{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->format('l - F j, Y') }}</span>
				
					<div class="post-date-subbox">
						<span>(Refreshes unless closed out)</span>
					</div>
				</div>
			</div>
@endif
		</li>
		<li>
			{{ $progress }}
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="projects-page"  class="single-page inner-page">
	<h2>@yield('page-h2')</h2>

	<div id="project-{{ $project->id }}" class="projects-post office-post-single" slug="{{ $project->slug }}">
		
		<div class="post-attachment">
			@if($project->getAttachments($project->id))
			{{ $project->getAttachments($project->id) }}
			@else
			<p>No attachment(s) found.</p>
			@endif
		</div>
		<div class="post-content">
			<p>{{ display_content($project->content) }}</p>
		</div>
		<div class="projects-post-sub office-post-sub">
			<small>Created on: {{ $project->created_at->format('F j, Y') }} by {{ link_to('/projects/assigned-to/'.any_user_path($project->author_id), User::find($project->author_id)->first_name.' '.User::find($project->author_id)->last_name) }}</small> | 
			@if(Auth::user()->id == $project->author_id || Auth::user()->userrole == 'admin')
			<small><a class="edit-project edit-link link" href="/projects/post/{{ $project->slug }}/edit">Edit Project</a></small>
			@endif
			<small class="right">
			Last edit: {{ $project->updated_at->format('F j, Y h:i:s A') }} by {{ link_to('/projects/assigned-to/'.any_user_path($project->edit_id), User::find($project->edit_id)->first_name.' '.User::find($project->edit_id)->last_name) }}
			</small>
		</div>
		<div class="post-manager">
			<h3>Project Manager:</h3>
			<img src="{{ gravatar_url(User::find($project->manager_id)->email,25) }}" alt="{{ User::find($project->manager_id)->first_name }} {{ User::find($project->manager_id)->last_name }}">
			@if($project->author_id == Auth::user()->id || Auth::user()->can_manage == 'yes')
			<div class="select-dropdown">
				<span class="ss-dropdown"></span>
				<span class="ss-directup"></span>
				<select class="change-project-manager-list" name="change-project-manager-list">
					{{ get_can_manage_user_list_select(User::find($project->manager_id)->first_name. ' ' .User::find($project->manager_id)->last_name) }}
				</select>
			</div>
			@else
			<p>{{ User::find($project->author_id)->first_name . ' ' . User::find($project->author_id)->last_name }}</p>
			@endif
			{{ Form::open( array('id' => 'change-project-manager-'.$project->id, 'class' => 'change-project-manager-form', 'url' => '/projects/singleviewupdate/'.$project->id.'/manager_id', 'method' => 'post') ) }}
				{{ Form::hidden('id', $project->id) }}
			{{ Form::close() }}
		</div>
		
		<div class="post-subscribed">
			<h3>Subscribed <small>(receives email notifications)</small>:</h3>
			@foreach($subscribed as $subd)
				@if(!empty($subd))
					@if($project->author_id == Auth::user()->id || $subd == Auth::user()->user_path || Auth::user()->can_manage == 'yes')
					<div class="user-subscribed ss-delete" value="{{ $subd }}">{{ ucwords(str_replace('-',' ',$subd)) }}</div>
					@else
					<div class="user-subscribed">{{ ucwords(str_replace('-',' ',$subd)) }}</div>
					@endif
				@endif
			@endforeach
		@if($project->author_id == Auth::user()->id || Auth::user()->can_manage == 'yes')
			<div class="select-dropdown">
				<span class="ss-dropdown"></span>
				<span class="ss-directup"></span>
				<select class="add-project-sub-list" name="add-project-sub-list">
				<option value="">Select User</option>
				{{ get_active_user_list_select() }}
				</select>
			</div>
		@endif
		{{ Form::open( array('id' => 'change-project-sub-'.$project->id, 'class' => 'change-project-sub-form', 'url' => '/projects/singleviewupdate/'.$project->id.'/subscribed', 'method' => 'post') ) }}
			{{ Form::hidden('id', $project->id) }}
		{{ Form::close() }}
		</div>
		
		<div class="clear"></div>
		<div class="project-stage-due-date">
			<h4>Project Phase:</h4>
			<span class="project-stage ss-location">{{ $project->stage }}</span>
			
			<span class="project-due-date ss-calendar">{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j, Y') }}</span>
		
			<div class="post-assigned-to">
				<img src="{{ gravatar_url(User::find($project->assigned_id)->email,25) }}" alt="{{ User::find($project->assigned_id)->first_name }} {{ User::find($project->assigned_id)->last_name }}">
					<div class="select-dropdown">
						<span class="ss-dropdown"></span>
						<span class="ss-directup"></span>
						<select class="change-project-user-list" name="change-project-user-list">{{ get_active_user_list_select(User::find($project->assigned_id)->first_name. ' ' .User::find($project->assigned_id)->last_name) }}</select>
					</div>
				{{ Form::open( array('id' => 'change-project-user-'.$project->id, 'class' => 'change-project-user-form', 'url' => '/projects/singleviewupdate/'.$project->id.'/assigned_id', 'method' => 'post') ) }}
					{{ Form::hidden('id', $project->id) }}
				{{ Form::close() }}
			</div>
		</div>
		<div class="project-checklist">
		{{ Form::open( array('id' => 'change-project-checkboxes-'.$project->id, 'class' => 'change-project-checkboxes-form', 'url' => '/projects/singleviewupdate/'.$project->id.'/checkboxes', 'method' => 'post') ) }}
			{{ Form::hidden('id', $project->id) }}
			{{ Form::hidden('user_finished_id', Auth::user()->id) }}
			{{ Form::hidden('user_finished_name', Auth::user()->first_name.' '.Auth::user()->last_name) }}
			{{ Form::hidden('user_finished_date', Carbon::now()->format('M d')) }}
			{{ $tasks }}
		{{ Form::close() }}
		</div>
		
	</div>
	<div id="projects-post-comment-form" class="create-something-new">
		<div class="projects-button"><span class="post-comment add-button"><span class="ss-reply"></span> Reply</span></div>
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
					{{ $comment->getCommentAttachments($comment->id) }}
					<p>{{ display_content($comment->content) }}</p>
					<div class="comment-details">
						<div class="comment-meta">
							<div class="comment-options">
								<div id="comment-post-comment-form" class="create-something-new">
									<div class="comment-reply-button"><span class="post-comment add-button"><span class="ss-reply"></span> Reply</span></div>
								</div>
							</div>

							<span class="comment-author" author="{{ User::find($comment->author_id)->first_name }}">{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}</span>
							<span class="comment-time">on 
							@if($comment->created_at->format('Y') == Carbon::now()->format('Y'))
								{{ $comment->created_at->format('F j g:i a') }}
							@else
								{{ $comment->created_at->format('F j, Y g:i a') }}
							@endif
							</span> | 
							<span class="comment-permalink"><a href="/projects/post/{{ $project->slug }}#comment-{{ $comment->id }}">Permalink</a></span> | 
							@if(Auth::user()->id == $project->author_id || Auth::user()->userrole == 'admin')
								<span class="comment-edit-button"><a class="edit-link edit-comment">Edit</a></span>
							@endif
						
						</div>
					</div>
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
							{{ $subComment->getCommentAttachments($subComment->id) }}
							<p>{{ display_content($subComment->content) }}</p>
							<div class="comment-details">
								<div class="comment-meta">
									<span class="comment-author">{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}</span>
									<span class="comment-time">on 
									@if($comment->created_at->format('Y') == Carbon::now()->format('Y'))
										{{ $subComment->created_at->format('F j g:i a') }}
									@else
										{{ $subComment->created_at->format('F j, Y g:i a') }}
									@endif
									</span> | 
									<span class="comment-permalink"><a href="/projects/post/{{ $project->slug }}#comment-{{ $subComment->id }}">Permalink</a></span> | 
									@if(Auth::user()->id == $project->author_id || Auth::user()->userrole == 'admin')
										<span class="comment-edit-button"><a class="edit-link edit-comment">Edit</a></span>
									@endif
								</div>
							</div>
						</div>
					</div>
				@endif
			@endforeach
		@endforeach
	@endif
</div>
@stop