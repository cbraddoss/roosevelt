@extends('admin.templates')

@section('page-title')
{{ 'Template: ' . $template->name }}
@stop

@section('admin-template-content')
<div class="update-something-form">
{{ Form::open( array('class' => 'update-template', 'url' => '/admin/templates/'.$template->slug, 'method' => 'post', 'id' => $template->id) ) }}

{{ Form::hidden('id', $template->id) }}

<div class="new-form-field">
	{{ Form::label('name','Name:') }}
	{{ Form::text('name', $template->name, array('placeholder' => 'Name', 'class' => 'name field')) }}
</div>

<div class="new-form-field">
	{{ Form::label('type','Type:') }}
	<span class="user-value type-value select-dropdown">
		<span class="ss-dropdown"></span>
		<span class="ss-directup"></span>
		{{ Form::select('type', array('project' => 'Project', 'billable' => 'Billable', 'invoice' => 'Invoice', 'help' => 'Help') , $template->type) }}
	</span>

</div>

<div class="new-form-field">
	{{ Form::label('status','Status:') }}
	<span class="user-value status-value select-dropdown">
		<span class="ss-dropdown"></span>
		<span class="ss-directup"></span>
		{{ Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive') , $template->status) }}
	</span>
</div>

<div class="new-form-field">
	<div class="form-textarea-buttons">
	{{ Form::label('content', 'Add Template code:') }}
	<span class="ss-up textarea-button add-start template-code" id="[[START]]">Start Section</span>
	<span class="ss-rows textarea-button add-header template-code" id="[[h]]">Header</span>
	<span class="ss-check textarea-button add-checkbox template-code" id="[[o]]">Checkbox</span>
	<span class="ss-down textarea-button add-end template-code" id="[[END]]">End Section</span>
		
	</div>
</div>

<div class="new-form-field template-checklist">
{{ $templateTasks }}
</div>

{{ Form::submit('Save Template', array('class' => 'save-template form-button') ) }}

<a href="/admin/templates" class="form-button cancel">Cancel</a>

{{ Form::close() }}
</div>
<div class="template-output">
<div class="page-cover">
</div>
<div class="template-preview">
<div class="close-template-preview">X Close</div>
<h2>TEMPLATE: {{ $template->name }}</h2>
<h4><a href="#">Sample Account</a></h4>
{{ $templateTasks }}
</div>
</div>

@stop