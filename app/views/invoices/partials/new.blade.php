<div class="invoice-add-form create-something-form">
<h2>New Invoice:</h2>
{{ Form::open( array('id' => 'add-new', 'files' => true, 'class' => 'add-invoice', 'url' => '/invoice/', 'method' => 'post') ) }}

{{ Form::submit('Create', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>