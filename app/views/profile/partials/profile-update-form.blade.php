{{ Form::open( array('class' => 'update-profile', 'url' => '/profile/' . lcfirst(Auth::user()->first_name) . '-' . lcfirst(Auth::user()->last_name), 'method' => 'post') ) }}

{{ Form::hidden('id') }}

{{ Form::hidden('confirm-profile-update', 'yes') }}

<table>
	<tbody>
		<tr class="profile-first-name">
			<th>{{ Form::label('first_name','First Name:') }}</th><td>{{ Form::text('first_name', null, array('placeholder' => 'First Name', 'class' => 'first-name field', 'autofocus' => 'autofocus')) }}</td>
		</tr>
		<tr class="profile-last-name">
			<th>{{ Form::label('last_name','Last Name:') }}</th><td>{{ Form::text('last_name', null, array('placeholder' => 'Last Name', 'class' => 'last-name field')) }}</td>
		</tr>
		<tr class="profile-email">
			<th>Email:</th><td>{{ Auth::user()->email }}</td>
		</tr>
		<tr>
			<th></th><td></td>
		</tr>
		<tr class="profile-extension">
			<th>{{ Form::label('extension','Extension:') }}</th><td>{{ Form::text('extension', null, array('placeholder' => '555', 'class' => 'extension field')) }}</td>
		</tr>
		<tr class="profile-cell-phone">
			<th>{{ Form::label('cell_phone','Cell Phone:') }}</th><td>{{ Form::text('cell_phone', null, array('placeholder' => '555-555-5555', 'class' => 'cell-phone field')) }}</td>
		</tr>
		<tr>
			<th></th><td></td>
		</tr>
		<tr class="profile-password">
			<th>{{ Form::label('password','Password:') }}</th><td>{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'password field')) }}</td>
		</tr>
		<tr class="profile-password-again">
			<th>{{ Form::label('password_again','Password Again:') }}</th><td>{{ Form::password('password_again', array('placeholder' => 'Password Again', 'class' => 'password_again field')) }}</td>
		</tr>
		<tr>
			<th></th><td></td>
		</tr>
		<tr>
			<th>{{ Form::submit('Save User', array('class' => 'save-profile') ) }}</th><td><span class="cancel">Cancel</span></td>
		</tr>
	</tbody>
</table>

{{ Form::close() }}