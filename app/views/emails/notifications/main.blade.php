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
		background: #eee;
		font-size: 62.5%;
		color: #000;
	}
	.header-div {
		font-size: 1.6em;
		width: 620px;
		padding: 0px;
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
		border: 1px solid #ccc;
	}
	.logo {
		display: block;
		margin: 0 auto;
	}
	.content-div {
		font-size: 1.8em;
		width: 600px;
		margin: 0px auto 0px;
		padding: 5px 10px 5px;
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
		margin: 10px 0;
	}
	.activity-div {
		font-size: 1.6em;
		letter-spacing: 1px;
		width: 620px;
		padding: 0px;
		margin: 0 auto;
		position: relative;
		z-index: 10;
		background: #3c698c; /* Old browsers */
		background: -moz-linear-gradient(top,  #3c698c 0%, #4b83b4 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#3c698c), color-stop(100%,#4b83b4)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #3c698c 0%,#4b83b4 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #3c698c 0%,#4b83b4 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #3c698c 0%,#4b83b4 100%); /* IE10+ */
		background: linear-gradient(to bottom,  #3c698c 0%,#4b83b4 100%); /* W3C */
		border: 1px solid #ccc;		
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
		border-top: 1px dashed #ccc;
		text-align: center;
	}
	h4 {
		font-size: 1.1em;
		font-weight: 100;
		color: #fff;
		letter-spacing: 1px;
		margin: 10px 0 5px;
		padding-bottom: 10px;
		border-bottom: 1px dashed #ccc;
		text-align: center;

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
		box-shadow: 0px 0px 2px 0px #3c698c;
	}
	ul li a span {
		padding: 2px 7px 2px;
		margin: 0;
		font-size: 0.9em;
		font-weight:500;
		color: #fff;
		text-shadow: 1px 1px 1px #000;
		border-radius: 20px;
		background: red; /*rgba(169,83,6, 0.9);*//*rgba(75,131,180,0.9);*/
		background: #ff9389; /* Old browsers */
		background: -moz-linear-gradient(top,  #ff9389 0%, #cc0000 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff9389), color-stop(100%,#cc0000)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #ff9389 0%,#cc0000 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #ff9389 0%,#cc0000 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #ff9389 0%,#cc0000 100%); /* IE10+ */
		background: linear-gradient(to bottom,  #ff9389 0%,#cc0000 100%); /* W3C */
	}
	.footer {
		text-align: center;
		letter-spacing: 1px;
		padding: 10px;
		font-size: 1em;
		font-weight: 100;
	}
	</style>
</head>
<body>
<div class="header-div">
	<a href="http://insideout.com"><img src="https://assets.insideout.com/images/ios-logo2-clear.png" class="logo" alt="InsideOut Solutions"></a>
	<h3>InsideOut Solutions Employee Hub & Remote Office</h3>
</div>
<div class="content-div">
	{{ $content }}
</div>
<div class="activity-div">
	<h4>Your Current Activity:</h4>
	<ul>
	<li><a href="http://roosevelt.insideout.com/tasks/">{{ $tasks }} Tasks</a></li>
	<li><a href="http://roosevelt.insideout.com/projects/">{{ $projects }} Projects</a></li>
	<li><a href="http://roosevelt.insideout.com/billables/">{{ $billables }} Billables</a></li>
	<li><a href="http://roosevelt.insideout.com/help/">{{ $help }} Help</a></li>
	</ul>
</div>
<div class="footer">
	<p>Be sure to add office@insideout.com to your address book.</p>
	<p>&copy; {{ Carbon::now()->format('Y') }} <a href="http://insideout.com">InsideOut Solutions, Inc.</a></p>
	<p>Designed and Developed by the IOS DevTeam.</p>
</div>
</body>
</html>