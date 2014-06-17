@extends('admin.templates')

@section('page-title')
{{ 'Template: ' . $template->name }}
@stop

@section('admin-template-content')

{{ Form::open( array('class' => 'update-template', 'url' => '/admin/templates/'.$template->slug, 'method' => 'post', 'id' => $template->id) ) }}

{{ Form::hidden('id', $template->id) }}

<div class="user-field">
	<span class="user-title name">{{ Form::label('name','Name:') }}</span>
	<span class="user-value name-value">{{ Form::text('name', $template->name, array('placeholder' => 'Name', 'class' => 'name field')) }}</span>
</div>

<div class="user-field">
	<span class="user-title type">{{ Form::label('type','Type:') }}</span>
	<span class="user-value type-value select-dropdown">
		<span class="ss-dropdown"></span>
		<span class="ss-directup"></span>
		{{ Form::select('type', array('project' => 'Project', 'billable' => 'Billable', 'invoice' => 'Invoice', 'help' => 'Help') , $template->type) }}
	</span>

</div>

<div class="user-field">
	<span class="user-title status">{{ Form::label('status','Status:') }}</span>
	<span class="user-value status-value select-dropdown">
		<span class="ss-dropdown"></span>
		<span class="ss-directup"></span>
		{{ Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive') , $template->status) }}
	</span>
</div>

<div class="user-textarea">
	<span class="user-value items-value">{{ Form::textarea('items', $template->items, array('placeholder' => 'Create new checklist here.', 'class' => 'template-items field', 'id' => 'template-items')) }}</span>
</div>

<div class="user-field">
	{{ Form::submit('Save Template', array('class' => 'save-template') ) }}
</div>
<div class="user-field">
	<a href="/admin/templates" class="button cancel">Cancel</a>
</div>

{{ Form::close() }}

<div class="template-output">
<div class="page-cover">
</div>
<div class="template-preview">
<div class="close-template-preview">X Close</div>
<h2>TEMPLATE: {{ $template->name }}</h2>
<h4><a href="#">Sample Account</a></h4>
{{ $template->convertCode($template->items) }}
</div>
</div>

@stop