@extends('layout.main')

@section('page-title')
{{ $project->title }}
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">
<div class="update-something-form">
<h3>Update Project:</h3>
{{ Form::open( array('id' => $project->id, 'files' => true, 'class' => 'update-project', 'url' => '/projects/post/'.$project->slug, 'method' => 'post') ) }}

{{ Form::hidden('id', $project->id) }}

<div class="new-form-field">
{{ Form::label('title', 'Title:') }}
{{ Form::text('title', $project->title, array('placeholder' => 'Title project using: Account Name - Project Type (e.g. Sample Inn - New Website)', 'class' => 'project-title field')) }}
</div>

<div class="new-form-field">
{{ Form::label('content', 'Project Scope:') }}
{{ Form::textarea('content', $project->content, array('placeholder' => 'Define project scope (e.g. New website for Sample Inn using attached contract).', 'class' => 'project-content field', 'id' => 'project-content')) }}
</div>

<div class="new-form-field new-form-field-extras">
	<div class="form-subscribe-buttons">
		{{ Form::label('subscribe', 'Subscribe Users:') }}
		{{ display_subscribable($project->subscribed) }}
	</div>
	{{ Form::hidden('subscribed', $project->subscribed, array('class' => 'project-subscribed field', 'id' => 'project-subscribed'), $project->subscribed) }}
</div>

<div class="horizontal-rule"><hr /></div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('assigned_id', 'Assigned To:') }}
<div class="select-dropdown">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
	<select class="project-assigned-user" name="project-assigned-user">{{ get_active_user_list_select(User::find($project->assigned_id)->first_name. ' ' .User::find($project->assigned_id)->last_name) }}</select>
</div>
</div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('stage', 'Current Stage:') }}
<div class="select-dropdown">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
	<select class="change-project-stage-list" name="change-project-stage-list">{{ $project->getProjectStages($project->stage, $project->id) }}</select>
</div>
</div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('due_date', 'Stage Due Date:') }}
{{ Form::text('due_date', Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('m/d/Y'), array('placeholder' => 'Due Date', 'class' => 'datepicker project-due-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
</div>
<div class="horizontal-rule"><hr /></div>
<div class="new-form-field new-form-field-extras">
	<div class="form-account-searchbox">
		{{ Form::label('account_name', 'Change Account:') }}
		{{ Form::text('account_name', Account::find($project->account_id)->name, array('placeholder' => 'Search Accounts...', 'class' => 'search-accounts field')) }}
		{{ Form::hidden('account_id', $project->account_id, array('class' => 'project-account-id field')) }}
		<div class="accounts-search-ajax"></div>
	</div>
</div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('template_id', 'Project Template:') }}
<span>{{ucwords(str_replace('-',' ', $project->type))}}</span>
{{ Form::hidden('template_name', $project->type, array('class' => 'project-template-name field', 'id' => 'project-template-name')) }}
</div>

@if($project->period == 'recurring')
<div class="new-form-field new-form-field-extras">
{{ Form::label('period', 'Is this project recurring?') }}
<span>Yes</span>
</div>
@endif

@if($project->period == 'ending')
<div class="new-form-field new-form-field-extras">
{{ Form::label('launch_date', 'Launch Date:') }}
{{ Form::text('launch_date', Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->format('m/d/Y'), array('placeholder' => 'Launch Date', 'class' => 'datepicker project-launch-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
{{ Form::hidden('start_date', Carbon::createFromFormat('Y-m-d H:i:s', $project->start_date)->format('m/d/Y'), array('placeholder' => 'Start Date', 'class' => 'project-start-date field')) }}
</div>
@else
<div class="new-form-field new-form-field-extras">
{{ Form::label('start_date', 'Start Date:') }}
{{ Form::text('start_date', Carbon::createFromFormat('Y-m-d H:i:s', $project->start_date)->format('m/d/Y'), array('placeholder' => 'Start Date', 'class' => 'datepicker project-start-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
</div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('end_date', 'End Date:') }}
{{ Form::text('end_date', Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->format('m/d/Y'), array('placeholder' => 'End Date', 'class' => 'datepicker project-end-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
</div>
@endif

<div class="horizontal-rule"><hr /></div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('priority', 'Priority:') }}
<div class="select-dropdown">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
	{{ Form::select('priority', array('high' => 'High', 'normal' => 'Normal', 'low' => 'Low') , $project->priority) }}
</div>
</div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('status', 'Status:') }}
<div class="select-dropdown">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
	{{ Form::select('status', array('open' => 'Open', 'closed' => 'Closed', 'archived' => 'Archived') , $project->status) }}
</div>
</div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('attachment', 'Attach File(s):') }}
{{ Form::file('attachment[]',array('multiple', 'class'=>'projects-post-attachment')) }}
</div>

{{ Form::submit('Save Article', array('class' => 'save form-button', 'id' => 'update-project-submit') ) }}

<a href="/projects/post/{{ $project->slug }}" class="form-button cancel">Cancel</a>

{{ Form::close() }}

@if(!empty($project->attachment))
<div class="new-form-field edit-attachments">
	<p>Current Attachment(s):</p>
	{{ $project->getAttachments($project->id,'post-edit-attachment') }}
</div>
@endif

@if(Auth::user()->userrole == 'admin')
{{ Form::open( array('class' => 'delete-project delete-post', 'url' => '/projects/post/'.$project->id, 'method' => 'delete', 'id' => $project->id) ) }}

{{ Form::label('id', 'Admin Alert: Deleting a project should be a last case scenario.')}}
{{ Form::hidden('id', $project->id) }}
{{ Form::submit('Delete Project', array('class' => 'delete form-button') ) }}

{{ Form::close() }}
@endif
</div>
</div>
@stop