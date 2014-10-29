<!doctype html>
<html lang="en" ng-app>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>InsideOut Solutions Employee Hub & Remote Office</title>
	<style>
	body {
		font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, sans-serif;
		background: #fafafa;
		font-size: 62.5%;
		color: #000;
		margin: 0;
		padding: 0;
	}
	.header-div {
		font-size: 1.4em;
		background: #4B83B4;
		position: relative;
		height: 90px;
		width: 100%;
		box-sizing: border-box;
	}
	.logo {
		position: absolute;
		top: 6px;
		left: 20px;
		opacity: 0.1;
		z-index: 0;
	}
	h1 {
		font-size: 2em;
		font-weight: 300;
		letter-spacing: 0.0225em;
		line-height: 90px;
		padding: 0 0px 0px 20px;
		margin: 0;
		color: #fff;
		float: left;
		z-index: 1;
		position: relative;
	}
	.content-div {
		font-size: 1.8em;
		width: 97%;
		margin: 0px 0 0px;
		padding: 5px 1% 5px;
		text-align:left;
	}
	.content-div p {
		display: block;
		margin: 10px 0;
	}
	.content-div small {
		font-size: 0.8em;
		font-style: italic;
		display: block;
		margin: 20px 0 0;
	}
	.activity-div {
		font-size: 1.6em;
		letter-spacing: 1px;
		width: 100%;
		padding: 0px;
		margin: 0 auto;
		position: relative;
		z-index: 10;		
	}
	a {
		color: #4b83b4;
	}
	h3 {
		font-size: 1.2em;
		font-weight: 100;
		color: #fff;
		letter-spacing: 1px;
		margin: 5px 0 10px;
		padding-top: 10px;
		text-align: left;
	}
	.header-div h3 {
		float:left;
		display: inline-block;
		height: 45px;
		padding: 0px 0 0 10px;
		margin: 0;
		width: 60%;
	}
	h4 {
		font-size: 1em;
		font-weight: 100;
		color: #000;
		letter-spacing: 1px;
		margin: 10px 0 5px;
		padding-bottom: 0px;
		text-align: left;
	}
	.activity-div h4 {
		color: #ffffff;
		height: 28px;
		padding: 7px 1% 0;
		margin: 20px 0 0;
		background: #4B83B4;
	}
	ul { width: 75%; padding: 0 1%; margin: 0; }
	ul li {
		display: inline-block;
		width: 75px;
		text-align:center;
		padding: 10px 0 15px;
		margin-right: 5px;
	}
	.activity-div ul li a {
		color: #ffffff;
		font-size: 1.2em;
		text-decoration: none;
		padding: 5px 14px;
		display: block;
		margin-bottom: 5px;
		background: #FF4D4D;
		border-radius: 3px;
	}
	.activity-div ul li a:hover {
		background: #FF4D4D;
	}
	.footer {
		text-align: center;
		letter-spacing: 1px;
		padding: 10px;
		font-size: 1em;
		font-weight: 100;
		margin-top: 100px;
	}
	</style>
</head>
<body>
<div class="header-div">
	<img class="logo" src="http://assets.insideout.com/images/ios-logo-ds.png" alt="IOS Remote Office" />
	<h1>InsideOut Solutions Remote Office</h1>
</div>
@yield('email-content')
<div class="footer">
	<p>Be sure to add office@insideout.com to your address book.</p>
	<p>&copy; {{ Carbon::now()->format('Y') }} <a href="http://insideout.com">InsideOut Solutions, Inc.</a></p>
	<p>Designed and Developed by the IOS DevTeam.</p>
</div>
</body>
</html>