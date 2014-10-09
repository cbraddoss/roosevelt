<div class="help-add-form create-something-form">
<h2>New Help:</h2>
{{ Form::open( array('id' => 'add-new', 'files' => true, 'class' => 'add-help', 'url' => '/help/', 'method' => 'post') ) }}

{{ Form::submit('Create', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>