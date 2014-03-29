@extends('layout.main')

@section('page-title')
{{ Auth::user()->first_name }}{{ '\'s Profile' }}
@stop

@section('page-content')
<div id="page-title">
	<h2>Your Profile</h2>
</div>

<div id="profile-page"  class="inner-page">
	<div class="profile-update-button"><button>Edit Profile</button></div>
	<p><span class="user-image"><img src="{{ gravatar_url(Auth::user()->email) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"></span> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
					

</div>
@stop