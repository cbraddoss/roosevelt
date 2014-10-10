<div class="template-add-form create-something-form">
<h2>New Template:</h2>
{{ Form::open( array('id' => 'add-new-template', 'files' => true, 'class' => 'add-template', 'url' => '/admin/templates/', 'method' => 'post') ) }}

<div class="new-form-field">
{{ Form::label('type', 'Type:') }}
<div class="select-dropdown">
<span class="ss-dropdown"></span>
<span class="ss-directup"></span>
{{ Form::select('type', array('project' => 'Project', 'billable' => 'Billable', 'invoice' => 'Invoice', 'help' => 'Help') , 'project') }}
</div>
</div>

<div class="new-form-field">
{{ Form::label('name', 'Template Name:') }}
{{ Form::text('name', null, array('placeholder' => 'Template Name', 'class' => 'template-name field')) }}
</div>

<div class="new-form-field">
	<div class="office-notice"><i>'<b>Section</b>' field can be repeated to assign multiple tasks to the same section.</i></div>
</div>

<div class="new-form-field">
{{ Form::label('section', 'Task Section:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
</div>

<div class="new-form-field">
{{ Form::label('content', 'Task Description:') }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
</div>

<div class="new-form-field">
	<div class="form-action-buttons post-tooltip">
		<span class="textarea-button form-action-button template-code remove-task ss-hyphen"></span>
		<span class="textarea-button form-action-button template-code add-task ss-plus tooltip-hover"><span class="tooltip">Add Section/Task Below</span></span>
	</div>
</div>

<div class="new-form-field">
{{ Form::label('section', 'Task Section:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
</div>

<div class="new-form-field">
{{ Form::label('content', 'Task Description:') }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
</div>

<div class="new-form-field">
	<div class="form-action-buttons post-tooltip">
		<span class="textarea-button form-action-button template-code remove-task ss-hyphen"></span>
		<span class="textarea-button form-action-button template-code add-task ss-plus tooltip-hover"><span class="tooltip">Add Section/Task Below</span></span>
	</div>
</div>

<div class="new-form-field">
{{ Form::label('section', 'Task Section:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
</div>

<div class="new-form-field">
{{ Form::label('content', 'Task Description:') }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
</div>

<div class="new-form-field">
	<div class="form-action-buttons post-tooltip">
		<span class="textarea-button form-action-button template-code remove-task ss-hyphen"></span>
		<span class="textarea-button form-action-button template-code add-task ss-plus tooltip-hover"><span class="tooltip">Add Section/Task Below</span></span>
	</div>
</div>

<div class="new-form-field">
{{ Form::label('section', 'Task Section:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
</div>

<div class="new-form-field">
{{ Form::label('content', 'Task Description:') }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
</div>

<div class="new-form-field">
	<div class="form-action-buttons post-tooltip">
		<span class="textarea-button form-action-button template-code remove-task ss-hyphen"></span>
		<span class="textarea-button form-action-button template-code add-task ss-plus tooltip-hover"><span class="tooltip">Add Section/Task Below</span></span>
	</div>
</div>

<div class="new-form-field">
{{ Form::label('section', 'Task Section:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
</div>

<div class="new-form-field">
{{ Form::label('content', 'Task Description:') }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
</div>

<div class="new-form-field">
	<div class="form-action-buttons post-tooltip">
		<span class="textarea-button form-action-button template-code remove-task ss-hyphen"></span>
		<span class="textarea-button form-action-button template-code add-task ss-plus tooltip-hover"><span class="tooltip">Add Section/Task Below</span></span>
	</div>
</div>

<div class="new-form-field add-task-buttons">
	<div class="form-action-buttons post-tooltip">
		<span class="textarea-button form-action-button template-code ss-plus add-task-ten tooltip-hover"><span class="tooltip">Add<br />Ten</span>10</span>
		<span class="textarea-button form-action-button template-code ss-plus add-task-five tooltip-hover"><span class="tooltip">Add<br />Five</span>5</span>
		<span class="textarea-button form-action-button template-code ss-plus add-task-one tooltip-hover"><span class="tooltip">Add<br />One</span>1</span>
	</div>
</div>

<div class="clear"></div>

{{ Form::submit('Create', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="cancel-new-template" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>