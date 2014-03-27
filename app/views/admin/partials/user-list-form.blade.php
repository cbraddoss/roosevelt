<td colspan="8" class="user-update">
	<div id="" class="user-update-form">
	
	{{ Form::open( array('class' => 'update-user', 'url' => 'admin', 'method' => 'post') ) }}
	
	{{ Form::hidden('id') }}

	{{ Form::hidden('confirm-update', 'yes') }}
	
	{{ Form::text('first_name', null, array('placeholder' => 'First Name', 'class' => 'first-name field', 'autofocus' => 'autofocus')) }}
	
	{{ Form::text('last_name', null, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}
	
	{{ Form::email('email', null, array('placeholder' => 'Email Address', 'class' => 'email field')) }}
	
	{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'password field')) }}
	
	{{ Form::select('userrole', array('admin' => 'admin', 'standard' => 'standard')) }}
	
	{{ Form::text('extension', null, array('placeholder' => 'Extension', 'class' => 'extension field')) }}
	
	{{ Form::text('cell_phone', null, array('placeholder' => 'Cell Phone', 'class' => 'cell-phone field')) }}
	
	{{ Form::select('status', array('active' => 'active', 'inactive' => 'inactive') ) }}
	
	{{ Form::submit('Save User', array('class' => 'save') ) }}
	
	<span class="cancel">Cancel</span>

	{{ Form::close() }}


	{{ Form::open( array('class' => 'delete-user', 'url' => 'admin', 'method' => 'post') ) }}
					
	{{ Form::hidden('id') }}

	{{ Form::hidden('confirm-delete', 'yes') }}

	{{ Form::hidden('first_name', null, array('class' => 'first-name field')) }}
	
	{{ Form::hidden('last_name', null, array('class' => 'last-name field')) }}

	{{ Form::submit('Delete User', array('class' => 'delete') ) }}

	{{ Form::close() }}
	</div>
</td>
			