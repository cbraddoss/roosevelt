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
		background: #eee url('https://assets.insideout.com/images/ticks.png') top left;
		font-size: 130%;
	}
	#logo-div {
		width: 600px;
		padding: 10px;
		margin: 0 auto;
		position: relative;
		z-index: 10;
	background: #4b83b4; /* Old browsers */
	background: -moz-linear-gradient(top,  #4b83b4 0%, #3c698c 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#4b83b4), color-stop(100%,#3c698c)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #4b83b4 0%,#3c698c 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #4b83b4 0%,#3c698c 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #4b83b4 0%,#3c698c 100%); /* IE10+ */
	background: linear-gradient(to bottom,  #4b83b4 0%,#3c698c 100%); /* W3C */
	}
	.logo {
		background: #A95306;
		display: block;
		margin: 0 auto;
		border: 1px solid #4b83b4;
	}
	#text-div {
		width: 600px;
		margin: 0px auto 0px;
		padding: 5px 10px 5px;
		text-align:left;
		background: rgba(255,255,255,0.6);
	}
	a {
		color: #4b83b4;
	}
	h3 {
		text-align: center;
		font-weight: 700;
		border-bottom: 1px solid #ddd;
		padding-bottom: 20px;
	}
	h4 {
		text-align: center;
		font-weight: 100;
		border-top: 1px solid #ddd;
		border-bottom: 1px solid #ddd;
		padding: 10px 0px;
		margin-top: 80px;
	}
	ul { width: 100%; }
	ul li {
		display: inline-block;
		width: 20%;
		text-align:center;
	}
	ul li a {
		display: block;
		text-decoration: none;
		background: #4d4d4d; /* Old browsers */
		background: -moz-linear-gradient(top,  #4d4d4d 0%, #333333 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#4d4d4d), color-stop(100%,#333333)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #4d4d4d 0%,#333333 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #4d4d4d 0%,#333333 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #4d4d4d 0%,#333333 100%); /* IE10+ */
		background: linear-gradient(to bottom,  #4d4d4d 0%,#333333 100%); /* W3C */
		padding: 5px;
		color: #fff;
		font-weight: 100;
		border-top:1px solid rgba(32,32,32,0.1);
		border-right:1px solid rgba(32,32,32,0.3);
		border-bottom:1px solid rgba(32,32,32,0.3);
		border-left:1px solid rgba(32,32,32,0.1);
	}
	ul li a span {
		border-radius: 10px;
		border-top:1px solid rgba(32,32,32,0.1);
		border-right:1px solid rgba(32,32,32,0.3);
		border-bottom:1px solid rgba(32,32,32,0.3);
		border-left:1px solid rgba(32,32,32,0.1);
		color: #fff;
		background: #c05d07; /* Old browsers */
		background: -moz-linear-gradient(top,  #c05d07 0%, #a95306 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#c05d07), color-stop(100%,#a95306)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #c05d07 0%,#a95306 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #c05d07 0%,#a95306 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #c05d07 0%,#a95306 100%); /* IE10+ */
		background: linear-gradient(to bottom,  #c05d07 0%,#a95306 100%); /* W3C */
		font-weight: 100;
		padding: 0px 5px;
	}
	#footer {
		text-align: center;
		letter-spacing: 1px;
		padding: 10px;
		font-size: 0.7em;
	}
	</style>
</head>
<body>
<div id="logo-div"><img src="https://assets.insideout.com/images/ios-logo2-clear.png" class="logo" alt="InsideOut Solutions"></div>
<div id="text-div">
	<h3>InsideOut Solutions Employee Hub & Remote Office</h3>
	<p>Your article, <b>{{ $title }}</b>, has a new reply by {{ $author }}</p>
	<p>View the post here: <a href="{{ $link }}">{{ $title }}</a></p>
	
	<h4>Your Current Activity:</h4>
	<ul>
	<li><a href="http://roosevelt.insideout.com/tasks/">{{ $tasks }} Tasks</a></li>
	<li><a href="http://roosevelt.insideout.com/projects/">{{ $projects }} Projects</a></li>
	<li><a href="http://roosevelt.insideout.com/billables/">{{ $billables }} Billables</a></li>
	<li><a href="http://roosevelt.insideout.com/help/">{{ $help }} Help</a></li>
	</ul>
</div>
<div id="footer">
	<p>Be sure to add office@insideout.com to your address book.</p>
	<p>&copy; {{ Carbon::now()->format('Y') }} InsideOut Solutions, Inc.</p>
	<p>Designed and Developed by the IOS DevTeam.</p>
</div>
</body>
</html>