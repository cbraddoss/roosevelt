@extends('admin.templates')

@section('page-h2')
{{ 'Template: ' . $template->name }}
@stop

@section('admin-template-content')
<div class="update-something-form">
<h2>Edit <i>{{ $template->name }}</i>:</h2>
{{ Form::open( array('class' => 'update-template', 'url' => '/admin/templates/'.$template->slug, 'method' => 'post', 'id' => $template->id) ) }}

{{ Form::hidden('id', $template->id) }}

<div class="new-form-field">
{{ Form::label('name', 'Name: ') }}
{{ Form::text('name', $template->name, array('placeholder' => 'Template Name', 'class' => 'template-name field')) }}
</div>

<div class="new-form-field">
{{ Form::label('type', 'Type: ') }}
<div class="select-dropdown">
<span class="ss-dropdown"></span>
<span class="ss-directup"></span>
{{ Form::select('type', array('project' => 'Project', 'billable' => 'Billable', 'invoice' => 'Invoice', 'help' => 'Help') , $template->type) }}
</div>
</div>

<div class="new-form-field">
{{ Form::label('status','Status:') }}
<div class="select-dropdown">
<span class="ss-dropdown"></span>
<span class="ss-directup"></span>
{{ Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive') , $template->status) }}
</div>
</div>

@foreach($templateTasks as $task)
<div class="new-form-field">
{{ Form::label('section', 'Task Section:') }}
{{ Form::text('section['.$task->id.']', $task->section, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
</div>

<div class="new-form-field">
{{ Form::label('content', 'Task Description:') }}
{{ Form::text('content['.$task->id.']', $task->content, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
</div>
<br />
@endforeach

{{ Form::submit('Save Template', array('class' => 'save-template form-button') ) }}

<a href="/admin/templates" class="form-button cancel">Cancel</a>

{{ Form::close() }}
</div>

</div>

@stop