{{ Form::open( array('class' => 'update-user', 'url' => '/profile/' . lcfirst(Auth::user()->first_name) . '-' . lcfirst(Auth::user()->last_name), 'method' => 'post') ) }}

{{ Form::hidden('id') }}

{{ Form::hidden('confirm-update', 'yes') }}

<table>
	<tbody>
		<tr class="profile-first-name">
			<th>{{ Form::label('first_name','First Name:') }}</th><td>{{ Form::text('first_name', null, array('placeholder' => 'First Name', 'class' => 'first-name field', 'autofocus' => 'autofocus')) }}</td>
		</tr>
		<tr class="profile-last-name">
			<th>{{ Form::label('last_name','Last Name:') }}</th><td>{{ Form::text('last_name', null, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}</td>
		</tr>
		<tr class="profile-email">
			<th>{{ Form::label('email','Email:') }}</th><td>{{ Form::email('email', null, array('placeholder' => 'Email Address', 'class' => 'email field')) }}</td>
		</tr>
		<tr>
			<th></th><td></td>
		</tr>
		<tr class="profile-extension">
			<th>Extension:</th><td>{{ Form::text('extension', null, array('placeholder' => '555', 'class' => 'extension field')) }}</td>
		</tr>
		<tr class="profile-cell-phone">
			<th>Cell Phone:</th><td>{{ Form::text('cell_phone', null, array('placeholder' => '555-555-5555', 'class' => 'cell-phone field')) }}</td>
		</tr>
		<tr>
			<th></th><td></td>
		</tr>
		<tr class="profile-password">
			<th>Password:</th><td>{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'password field')) }}</td>
		</tr>
		<tr class="profile-password-again">
			<th></th><td></td>
		</tr>
	</tbody>
</table>
	
{{ Form::submit('Save User', array('class' => 'save') ) }}

<button class="cancel">Cancel</button>

{{ Form::close() }}