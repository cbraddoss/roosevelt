<div class="user-add-form create-something-form">
<h2>New User:</h2>
{{ Form::open( array('id' => 'add-new', 'class' => 'add-user', 'url' => '/admin/users', 'method' => 'post') ) }}

<div class="new-form-field">
{{ Form::label('first_name', 'First Name:') }}
{{ Form::text('first_name', null, array('placeholder' => 'First Name', 'class' => 'first-name field')) }}
</div>

<div class="new-form-field">
{{ Form::label('last_name', 'Last Name:') }}
{{ Form::text('last_name', null, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}
</div>

<div class="new-form-field">
{{ Form::label('email', 'Email Address:') }}
{{ Form::email('email', null, array('placeholder' => 'Email Address', 'class' => 'email field', 'autocomplete' => 'off')) }}
</div>

<div class="new-form-field">
{{ Form::label('password', 'Password:') }}
{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'password field')) }}
</div>

<div class="new-form-field">
{{ Form::label('userrole', 'Role:') }}
<div class="select-dropdown">
<span class="ss-dropdown"></span>
<span class="ss-directup"></span>
{{ Form::select('userrole', array('admin' => 'Admin', 'standard' => 'Standard', 'non-standard' => 'Sub-Contracted') , 'standard') }}
</div>
</div>

{{ Form::submit('Add User', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>