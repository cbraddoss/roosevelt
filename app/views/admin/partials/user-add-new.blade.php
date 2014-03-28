<td colspan="8">

	<div class="user-add-form">
	
	{{ Form::open( array('id' => 'add-new', 'class' => 'add-user', 'url' => 'admin', 'method' => 'post') ) }}
	
	{{ Form::hidden('confirm-add', 'yes') }}
	
	{{ Form::text('first_name', null, array('placeholder' => 'First Name', 'class' => 'first-name field')) }}
	
	{{ Form::text('last_name', null, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}
	
	{{ Form::email('email', null, array('placeholder' => 'Email Address', 'class' => 'email field', 'autocomplete' => 'off')) }}
	
	{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'password field')) }}
	
	{{ Form::select('userrole', array('admin' => 'admin', 'standard' => 'standard') , 'standard') }}
	
	{{ Form::text('extension', null, array('placeholder' => 'Extension', 'class' => 'extension field')) }}
	
	{{ Form::submit('Add User', array('class' => 'save', 'id' => 'add-new-submit') ) }}
	
	<span id="add-new" class="cancel">Cancel</span>

	{{ Form::close() }}

	</div>
</td>