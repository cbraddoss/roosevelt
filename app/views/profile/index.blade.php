@extends('layout.main')

@section('page-title')
{{ Auth::user()->first_name }}{{ '\'s Profile' }}
@stop

@section('page-content')
<div id="page-title">
	<h2>Your Profile</h2>
</div>

<div id="profile-page"  class="inner-page">
	
	<p><span class="user-image"><img src="{{ gravatar_url(Auth::user()->email,100) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"></span></p>
	<div id="profile-details">
		<table>
			<tbody>
				<tr class="profile-first-name">
					<th>First Name:</th><td>{{ Auth::user()->first_name }}</td>
				</tr>
				<tr class="profile-last-name">
					<th>Last Name:</th><td>{{ Auth::user()->last_name }}</td>
				</tr>
				<tr class="profile-email">
					<th>Email:</th><td>{{ Auth::user()->email }}</td>
				</tr>
				<tr>
					<th></th><td></td>
				</tr>
				<tr class="profile-extension">
					<th>Extension:</th><td>{{ Auth::user()->extension }}</td>
				</tr>
				<tr class="profile-cell-phone">
					<th>Cell Phone:</th><td>{{ Auth::user()->cell_phone }}</td>
				</tr>
				<tr>
					<th></th><td></td>
				</tr>
				<tr class="profile-password">
					<th>Password:</th><td>********</td>
				</tr>
				<tr class="profile-password-again">
					<th></th><td></td>
				</tr>
			</tbody>
		</table>

		<div class="profile-update-button"><button>Edit Profile</button></div>
	</div>
</div>
@stop