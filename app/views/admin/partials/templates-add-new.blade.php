<div class="template-add-form create-something-form">
<h3>Create new template:</h3>
{{ Form::open( array('id' => 'add-new-template', 'files' => true, 'class' => 'add-template', 'url' => '/admin/templates/', 'method' => 'post') ) }}

{{ Form::label('type', 'Type: ') }}
{{ Form::select('type', array('project' => 'Project', 'billable' => 'Billable', 'invoice' => 'Invoice', 'help' => 'Help') , 'project') }}

{{ Form::text('name', null, array('placeholder' => 'Template Name', 'class' => 'template-name field')) }}

{{ Form::textarea('items', null, array('placeholder' => 'Add checklist items here.', 'class' => 'template-items field', 'id' => 'template-items')) }}

{{ Form::submit('Create', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="cancel-new-template" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>