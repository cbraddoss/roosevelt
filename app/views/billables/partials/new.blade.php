<div class="billable-add-form create-something-form">
<h3>New Billable:</h3>
{{ Form::open( array('id' => 'add-new', 'files' => true, 'class' => 'add-billable', 'url' => '/billables/', 'method' => 'post') ) }}

{{ Form::submit('Create', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>