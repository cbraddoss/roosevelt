@extends('layout.main')

@section('page-title')
{{ Auth::user()->first_name }}{{ '\'s Profile' }}
@stop

@section('page-content')
<div id="profile-page"  class="inner-page">
	
	<p><span class="user-image"><img src="{{ gravatar_url(Auth::user()->email,100) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"></span></p>
	<div id="profile-details">
		<table id="profile-table">
			<tbody>
				<tr class="profile-field">
					<th>First Name:</th><td class="profile-first-name" fieldval="{{ Auth::user()->first_name }}">{{ Auth::user()->first_name }}</td>
				</tr>
				<tr class="profile-field">
					<th>Last Name:</th><td class="profile-last-name" fieldval="{{ Auth::user()->last_name }}">{{ Auth::user()->last_name }}</td>
				</tr>
				<tr class="profile-field">
					<th>Email:</th><td class="profile-email" fieldval="{{ Auth::user()->email }}">{{ Auth::user()->email }}</td>
				</tr>
				<tr>
					<th></th><td></td>
				</tr>
				<tr class="profile-field">
					<th>Extension:</th><td class="profile-extension" fieldval="{{ Auth::user()->extension }}">{{ Auth::user()->extension }}</td>
				</tr>
				<tr class="profile-field">
					<th>Cell Phone:</th><td class="profile-cell-phone" fieldval="{{ Auth::user()->cell_phone }}">{{ Auth::user()->cell_phone }}</td>
				</tr>
				<tr>
					<th></th><td></td>
				</tr>
				<tr class="profile-field">
					<th>Password:</th><td class="profile-password">********</td>
				</tr>
				<tr class="profile-field">
					<th></th><td class="profile-password-again"></td>
				</tr>
				<tr class="profile-update-button">
					<th><a href="/profile/edit" id="{{ Auth::user()->id }}" class="button edit-profile">Edit Profile</a></th><tr></tr>
				</tr>
			</tbody>
		</table>
	</div>
</div>
@stop