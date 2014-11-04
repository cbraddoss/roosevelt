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
		
		<div class="post-content">
		<h3 class="ss-crosshair"> Project Scope:</h3>
			<p>{{ display_content($project->content) }}</p>
			<div class="post-project-attachment">
				@if($project->getAttachments($project->id))
				<h3 class="ss-attach"> Attachment(s):</h3>
				{{ $project->getAttachments($project->id) }}
				@endif
			</div>
		</div>
		
		<div class="post-project-account">
			<h3 class="ss-buildings"> Account:</h3>
			<h4><a href="/accounts/account/{{ Account::find($project->account_id)->slug }}">{{ Account::find($project->account_id)->name }}</a></h4>
		</div>
		<div class="post-subscribed">
			<h3 class="ss-send"> Subscribed:
					<div class="select-dropdown">
						<span class="ss-dropdown"></span>
						<span class="ss-directup"></span>
						<select class="add-project-sub-list" name="add-project-sub-list">
						<option value="">Select User</option>
						{{ get_active_user_list_select() }}
						</select>
					</div>
			</h3>
			@foreach($subscribed as $subd)
				@if(!empty($subd))
					@if($project->author_id == Auth::user()->id || $subd == Auth::user()->user_path || Auth::user()->can_manage == 'yes')
					<div class="user-subscribed ss-delete" value="{{ $subd }}">{{ ucwords(str_replace('-',' ',$subd)) }}</div>
					@else
					<div class="user-subscribed">{{ ucwords(str_replace('-',' ',$subd)) }}</div>
					@endif
				@endif
			@endforeach
		<br class="clear" />
		{{ Form::open( array('id' => 'change-project-sub-'.$project->id, 'class' => 'change-project-sub-form', 'url' => '/projects/singleviewupdate/'.$project->id.'/subscribed', 'method' => 'post') ) }}
			{{ Form::hidden('id', $project->id) }}
		{{ Form::close() }}
		</div>
		
		<div class="clear"></div>
		<div class="project-stage-due-date">
			<h3 class="ss-location"><small> Stage:</small></h3>
			<span class="project-stage">{{ $project->stage }}</span>
			</div>

		<div class="project-stage-due-date">
			<h3 class="ss-calendar"><small> Due Date:</small></h3>
			<div class="project-due-date change-project-date" data-date="{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('m-d-Y') }}" data-date-format="mm-dd-yyyy" data-date-viewmode="days">
				<span class="project-due-date-text tooltip-hover">
					<span class="tooltip">Change<br />Due Date</span>
					<span class="post-due-date">{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j') }}</span>
				</span>
				{{ Form::open( array('id' => 'change-project-date-'.$project->id, 'class' => 'change-project-date-form', 'url' => '/projects/listviewupdate/'.$project->id.'/due_date', 'method' => 'post') ) }}
					{{ Form::hidden('id', $project->id) }}
				{{ Form::close() }}
			</div>
			</div>

		<div class="project-stage-due-date">
			<div class="post-assigned-to">
			<h3><img src="{{ gravatar_url(User::find($project->assigned_id)->email,20) }}" alt="{{ User::find($project->assigned_id)->first_name }} {{ User::find($project->assigned_id)->last_name }}" /><small> Assigned To:</small></h3>
<span class="tooltip-hover"><span class="tooltip">Change<br />User</span></span>
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

		<div class="project-stage-due-date">
			<h3 class="ss-alert"><small> Priority:</small></h3>
			<div class="post-priority">
<span class="priority-icon tooltip-hover"><span class="tooltip">Change<br />Priority</span></span>
<div class="select-dropdown">
<span class="ss-dropdown"></span>
<span class="ss-directup"></span>
{{ Form::select('change-project-priority', array('high' => 'High', 'normal' => 'Normal', 'low' => 'Low'), $project->priority) }}
</div>
{{ Form::open( array('id' => 'change-project-priority-'.$project->id, 'class' => 'change-project-priority-form', 'url' => '/projects/singleviewupdate/'.$project->id.'/priority', 'method' => 'post') ) }}
{{ Form::hidden('id', $project->id) }}
{{ Form::close() }}
			</div>
			</div>

		<div class="project-stage-due-date">
			<h3><img src="{{ gravatar_url(User::find($project->manager_id)->email,20) }}" alt="{{ User::find($project->manager_id)->first_name }} {{ User::find($project->manager_id)->last_name }}" /><small> Manager:</small></h3>
			<div class="post-manager">
<span class="manager-icon tooltip-hover"><span class="tooltip">Project<br />Manager</span></span>
@if($project->author_id == Auth::user()->id || Auth::user()->can_manage == 'yes')
<div class="select-dropdown">
<span class="ss-dropdown"></span>
<span class="ss-directup"></span>
<select class="change-project-manager-list" name="change-project-manager-list">
<option>Select Manager</option>
{{ get_can_manage_user_list_select(User::find($project->manager_id)->first_name. ' ' .User::find($project->manager_id)->last_name) }}
</select>
</div>
@else
<span>{{ User::find($project->manager_id)->first_name . ' ' . User::find($project->manager_id)->last_name }}</span>
@endif
{{ Form::open( array('id' => 'change-project-manager-'.$project->id, 'class' => 'change-project-manager-form', 'url' => '/projects/singleviewupdate/'.$project->id.'/manager_id', 'method' => 'post') ) }}
{{ Form::hidden('id', $project->id) }}
{{ Form::close() }}
			</div>
			</div>

		<div class="project-stage-due-date">
			@if($project->period == 'recurring')
			<h3 class="ss-refresh"><small> Refreshes:</small></h3>
			@else
			<h3 class="ss-uploadcloud"><small> Launching:</small></h3>
			@endif
			<div class="project-launch-date change-project-launch-date" data-date="{{ Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->format('m-d-Y') }}" data-date-format="mm-dd-yyyy" data-date-viewmode="days">
				<span class="project-launch-date-text tooltip-hover">
					<span class="tooltip">Change<br />Launch</span>
					<span class="post-launch-date"> {{ Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->format('F j') }}</span>
				</span>
				{{ Form::open( array('id' => 'change-project-launch-date-'.$project->id, 'class' => 'change-project-launch-date-form', 'url' => '/projects/singleviewupdate/'.$project->id.'/end_date', 'method' => 'post') ) }}
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
		<div class="projects-post-sub office-post-sub">
			<small>Created on: {{ $project->created_at->format('F j, Y') }} by {{ link_to('/projects/assigned-to/'.any_user_path($project->author_id), User::find($project->author_id)->first_name.' '.User::find($project->author_id)->last_name) }}</small> | 
			@if(Auth::user()->id == $project->author_id || Auth::user()->userrole == 'admin')
			<small><a class="edit-project edit-link link" href="/projects/post/{{ $project->slug }}/edit">Edit Project</a></small>
			@endif
			<small class="right">
			Last edit: {{ $project->updated_at->format('F j, Y h:i:s A') }} by {{ link_to('/projects/assigned-to/'.any_user_path($project->edit_id), User::find($project->edit_id)->first_name.' '.User::find($project->edit_id)->last_name) }}
			</small>
		</div>
	</div>
	<div id="projects-post-comment-form" class="create-something-new">
		<div class="projects-button">
			<span formtype="post-reply" formlocation="/projects/post/{{ $project->slug }}/comment" class="post-comment add-button">
			<span class="ss-reply"></span> Reply</span>
		</div>
	</div>
	<h3 class="comment-on">Project Comments:</h3>
	
	<div id="comments"></div>
	@if($comments->isEmpty())
		<p>No comments yet. Reply to start a conversation on this project!</p>
	@else
		@foreach($comments as $comment)
			@if(Auth::user()->user_path == User::find($comment->author_id)->user_path) 
				<div id="comment-{{ $comment->id }}" class="projects-post-comment current-user-comment office-post-comment">
				<img src="{{ gravatar_url(User::find($comment->author_id)->email,30) }}" class="comment-author-image current-user-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
				<span class="comment-author" author="{{ User::find($comment->author_id)->first_name }}">{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}:</span>
			@else
				<div id="comment-{{ $comment->id }}" class="projects-post-comment office-post-comment">
				<img src="{{ gravatar_url(User::find($comment->author_id)->email,30) }}" class="comment-author-image" alt="{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}">
				<span class="comment-author" author="{{ User::find($comment->author_id)->first_name }}">{{ User::find($comment->author_id)->first_name }} {{ User::find($comment->author_id)->last_name }}:</span>
			@endif
				<div class="comment-contents">
					{{ $comment->getCommentAttachments($comment->id) }}
					<p class="comment-text">{{ display_content($comment->content) }}</p>
					<div class="comment-details">
						<div class="comment-meta">
							<div class="comment-options">
								<div id="comment-post-comment-form" class="create-something-new">
									<div class="comment-reply-button">
										<span commentid="{{ $comment->id }}" formtype="comment-reply" formlocation="/projects/post/{{ $project->slug }}/comment" class="post-comment add-button">
										<span class="ss-reply"></span> Reply</span>
									</div>
								</div>
							</div>

							<span class="comment-posted">Posted: </span>
							<span class="comment-time">
							@if($comment->created_at->format('Y') == Carbon::now()->format('Y'))
								{{ $comment->created_at->format('F j g:i a') }}
							@else
								{{ $comment->created_at->format('F j, Y g:i a') }}
							@endif
							</span> | 
							@if($comment->created_at != $comment->updated_at)
							<small>
							{{ User::find($comment->edit_id)->first_name }} edited: 
							@if($comment->updated_at->format('Y') == Carbon::now()->format('Y'))
								{{ $comment->updated_at->format('F j g:i a') }}
							@else
								{{ $comment->updated_at->format('F j, Y g:i a') }}
							@endif
							</small> | 
							@endif
							<span class="comment-permalink"><a href="/projects/post/{{ $project->slug }}#comment-{{ $comment->id }}">Permalink</a></span>
							@if(Auth::user()->id == $project->author_id || Auth::user()->userrole == 'admin')
								<span class="comment-edit-button">
									 | <a  commentid="{{ $comment->id }}" formtype="comment-edit" formlocation="/projects/post/comment/{{ $comment->id }}/edit" class="edit-link edit-comment">Edit</a>
								</span>
							@endif
						
						</div>
					</div>
				</div>
			</div>
			@foreach($subComments as $subComment)
				@if($subComment->reply_to_id == $comment->id)
					@if(Auth::user()->user_path == User::find($subComment->author_id)->user_path) 
						<div id="comment-{{ $subComment->id }}" class="projects-post-comment current-user-comment office-post-comment office-post-sub-comment">
						<img src="{{ gravatar_url(User::find($subComment->author_id)->email,30) }}" class="comment-author-image current-user-image" alt="{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}">
						<span class="comment-author">{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}:</span>
					@else
						<div id="comment-{{ $subComment->id }}" class="projects-post-comment office-post-comment office-post-sub-comment">
						<img src="{{ gravatar_url(User::find($subComment->author_id)->email,30) }}" class="comment-author-image" alt="{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}">
						<span class="comment-author">{{ User::find($subComment->author_id)->first_name }} {{ User::find($subComment->author_id)->last_name }}:</span>
					@endif
						<div class="comment-contents">
							{{ $subComment->getCommentAttachments($subComment->id) }}
							<p class="comment-text">{{ display_content($subComment->content) }}</p>
							<div class="comment-details">
								<div class="comment-meta">
									<span class="comment-posted">Posted: </span>
									<span class="comment-time">
									@if($subComment->created_at->format('Y') == Carbon::now()->format('Y'))
										{{ $subComment->created_at->format('F j g:i a') }}
									@else
										{{ $subComment->created_at->format('F j, Y g:i a') }}
									@endif
									</span> | 
									@if($subComment->created_at != $subComment->updated_at)
									<small>
									{{ User::find($subComment->edit_id)->first_name }} edited: 
									@if($subComment->updated_at->format('Y') == Carbon::now()->format('Y'))
										{{ $subComment->updated_at->format('F j g:i a') }}
									@else
										{{ $subComment->updated_at->format('F j, Y g:i a') }}
									@endif
									</small> | 
									@endif
									<span class="comment-permalink"><a href="/projects/post/{{ $project->slug }}#comment-{{ $subComment->id }}">Permalink</a></span>
									@if(Auth::user()->id == $subComment->author_id || Auth::user()->userrole == 'admin')
										<span class="comment-edit-button">
											 | <a commentid="{{ $subComment->id }}" formtype="comment-edit" formlocation="/projects/post/comment/{{ $subComment->id }}/edit" class="edit-link edit-comment">Edit</a>
										</span>
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