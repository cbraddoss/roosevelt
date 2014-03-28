<!doctype html>
<html lang="en" ng-app>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	@yield('page-title')
	@include('layout.css')
</head>
<body>
	<div id="header">
		<div class="section">
			@include('layout.header')
		</div> <!-- .section -->
	</div> <!-- #header -->

	<div id="side">
		<div class="section">
				@include('layout.sidebar')
		</div>
	</div>

	<div id="page">
		<div class="section">
			
			<div id="content">
				@yield('page-content')
			</div> <!-- #content -->

			<div class="clear"></div>
		</div> <!-- .section -->
	</div> <!-- #page -->
	<div class="success-notice"><span class="ss-check"></span><p></p></div>
	<div class="error-notice"><span class="ss-delete"></span><p></p></div>
@include('layout.js')
</body>
</html>