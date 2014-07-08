<div class="template-add-form create-something-form">
<h3>New Template:</h3>
{{ Form::open( array('id' => 'add-new-template', 'files' => true, 'class' => 'add-template', 'url' => '/admin/templates/', 'method' => 'post') ) }}

<div class="new-form-field">
{{ Form::label('type', 'Type: ') }}
	<div class="select-dropdown">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
	{{ Form::select('type', array('project' => 'Project', 'billable' => 'Billable', 'invoice' => 'Invoice', 'help' => 'Help') , 'project') }}
</div>
</div>

<div class="new-form-field">
{{ Form::label('name', 'Title: ') }}
{{ Form::text('name', null, array('placeholder' => 'Template Name', 'class' => 'template-name field')) }}
</div>

<div class="new-form-field">
{{ Form::label('section', 'Task:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
<div class="new-form-field remove-task">
	<div class="form-textarea-buttons">
		<span class="textarea-button template-code ss-hyphen"></span>
	</div>
</div>
</div>
<div class="new-form-field">
{{ Form::label('section', 'Task:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
<div class="new-form-field remove-task">
	<div class="form-textarea-buttons">
		<span class="textarea-button template-code ss-hyphen"></span>
	</div>
</div>
</div>
<div class="new-form-field">
{{ Form::label('section', 'Task:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
<div class="new-form-field remove-task">
	<div class="form-textarea-buttons">
		<span class="textarea-button template-code ss-hyphen"></span>
	</div>
</div>
</div>
<div class="new-form-field">
{{ Form::label('section', 'Task:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
<div class="new-form-field remove-task">
	<div class="form-textarea-buttons">
		<span class="textarea-button template-code ss-hyphen"></span>
	</div>
</div>
</div>
<div class="new-form-field">
{{ Form::label('section', 'Task:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
<div class="new-form-field remove-task">
	<div class="form-textarea-buttons">
		<span class="textarea-button template-code ss-hyphen"></span>
	</div>
</div>
</div>

<div class="new-form-field add-task-ten">
	<div class="form-textarea-buttons">
		<span class="textarea-button template-code ss-plus">10</span>
	</div>
</div>
<div class="new-form-field add-task-five">
	<div class="form-textarea-buttons">
		<span class="textarea-button template-code ss-plus">5</span>
	</div>
</div>
<div class="new-form-field add-task-one">
	<div class="form-textarea-buttons">
		<span class="textarea-button template-code ss-plus">1</span>
	</div>
</div>

<div class="clear"></div>

{{ Form::submit('Create', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="cancel-new-template" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>