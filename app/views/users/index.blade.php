<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>InsideOut Solutions Employee Hub &amp; Remote Office</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

	</style>
</head>
<body>
	<h1>All Users</h1>
	@if($users->count())
	@foreach ($users as $user)
		<li>{{ link_to("/users/{$user->username}", $user->username) }}</li>
	@endforeach
	@else
		<p>No users found.</p>
	@endif
</body>
</html>