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
	<span class="user-value type-value">{{ Form::select('type', array('project' => 'Project', 'billable' => 'Billable', 'invoice' => 'Invoice', 'help' => 'Help') , $template->type) }}</span>
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


{{ Form::open( array('class' => 'delete-template', 'url' => '/admin/templates/'.$template->id, 'method' => 'delete') ) }}

{{ Form::hidden('id', $template->id) }}

{{ Form::hidden('name', $template->name, array('class' => 'name field')) }}

<div class="user-field">
{{ Form::submit('Delete Template', array('class' => 'delete') ) }}
</div>
{{ Form::close() }}

<div class="template-output">
<h3>Sample Project:</h3>
<h4><a href="#">Sample Account</a></h4>
{{ $template->convertCode($template->items) }}
</div>

@stop