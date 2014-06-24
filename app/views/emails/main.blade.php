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
		font-size: 1.6em;
		width: 100%;
		height: 45px;
		padding: 0px;
		margin: 0;
		position: relative;
		z-index: 10;
		background: #4b83b4;
		background: linear-gradient(to top,  #4b83b4 0%,#3c698c 100%);
		box-shadow: 1px 1px 3px 0px #000;
		overflow: hidden;
	}
	.logo {
		display: block;
		float:left;
		margin: -16px 0 0 1%;
		height:61px;
		overflow: hidden;
	}
	/*#company-header {
	margin-left: 13%;
	letter-spacing: 0.0625em;
	font-size: 1em;
	height:45px;
	float:left;
	z-index: 59;
	color: #fff;
	position: relative;
}
#company-header a.logo {
	position: fixed;
	left: 1%;
	top:-16px;
	color: #fff;
	height:61px;
	overflow: hidden;
}*/
	.content-div {
		font-size: 1.8em;
		width: 97%;
		margin: 0px 0 0px;
		padding: 5px 1% 5px;
		text-align:left;
		background: rgba(255,255,255,0.6);
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
		color: #fff;
		height: 28px;
		padding: 7px 1% 0;
		margin: 20px 0 0;
		background: #4b83b4;
		background: linear-gradient(to top,  #4b83b4 0%,#3c698c 100%);
		box-shadow: 1px 1px 3px 0px #000;
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
		color: #fff;
		font-size: 1.2em;
		text-decoration: none;
		padding: 5px 14px;
		display: block;
		margin-bottom: 5px;
		box-shadow: 1px 1px 2px 0px #000;
		background: #c60;
		background: linear-gradient(165deg, #c60 0%,#a40 100%);
		border-radius: 3px;
	}
	.activity-div ul li a:hover {
		box-shadow: inset 1px 1px 2px 0px #000;
		background: #a40;
		background: linear-gradient(165deg, #a40 0%,#c60 100%);
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
	<div id="company-logo">
		<a href="{{ URL::to('/') }}" class="logo"><img src="http://assets.insideout.com/images/ios-logo-ds.png" alt="IOS Remote Office" /></a>
	</div>
	<h3>InsideOut Solutions<br />Remote Office</h3>
</div>
@yield('email-content')
<div class="footer">
	<p>Be sure to add office@insideout.com to your address book.</p>
	<p>&copy; {{ Carbon::now()->format('Y') }} <a href="http://insideout.com">InsideOut Solutions, Inc.</a></p>
	<p>Designed and Developed by the IOS DevTeam.</p>
</div>
</body>
</html>