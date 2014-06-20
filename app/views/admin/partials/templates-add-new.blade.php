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
	<div class="form-textarea-buttons">
	{{ Form::label('content', 'Add Template code:') }}
	<span class="ss-up textarea-button add-start template-code" id="[[START]]">Start Section</span>
	<span class="ss-rows textarea-button add-header template-code" id="[[h]]">Header</span>
	<span class="ss-check textarea-button add-checkbox template-code" id="[[o]]">Checkbox</span>
	<span class="ss-down textarea-button add-end template-code" id="[[END]]">End Section</span>
		
	</div>
</div>

<div class="new-form-field">
{{ Form::label('items', 'Checklist Template: ') }}
{{ Form::textarea('items', null, array('placeholder' => 'Add checklist items here.', 'class' => 'template-items field', 'id' => 'template-items')) }}
</div>

{{ Form::submit('Create', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="cancel-new-template" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>