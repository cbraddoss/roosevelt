<!doctype html>
<html lang="en" ng-app>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('page-title') :: InsideOut Solutions Employee Hub & Remote Office</title>
	
	@include('layout.css')

	@yield('page-css')

	@yield('page-head')
</head>
<body class="{{ body_class() }}">
	<div id="header">
		<div class="section">
			<div id="company-header">
				<div id="company-logo">
					<a href="/" class="logo"><img src="/images/ios-logo-ds.png" alt="IOS Remote Office" /></a>
				</div>
				<div id="page-title">
					@if(current_page() == '/')
					<h2>Welcome to the IOS Remote Office</h2>
					@else
					<h2>@yield('page-title')</h2>
					@endif
				</div>
			</div>			
			
			<div id="search-box">
				<div class="search-details">
					{{ Form::open( array('class' => 'office-search', 'url' => '/search', 'method' => 'post') ) }}
					<input type="text" class="search" name="s" id="s" placeholder="Search the Office..." /><span class="ss-search"></span>
					{{ Form::close() }}
				</div>
			</div>

			<div id="welcome-box">
				<img src="{{ gravatar_url(Auth::user()->email,35) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
				<ul id="welcome-name">
					<li id="link-name" class="link">Howdy, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</li>
					<li id="link-to-do" class="link"><a href="/to-do/{{ Auth::user()->user_path }}">To-Do List: </a><span id="linked-to-welcome" class="linked-to"><a href="/to-do/{{ Auth::user()->user_path }}"></a></span></li>
				</ul>
			</div>
			
			
			@if(Session::get('flash_message_error'))
				<div id="message-box">
					<div class="section">
						<div class="action-message"><span class="flash-message flash-message-error"><span class="ss-alert"></span> {{ Session::get('flash_message_error') }}</span></div>
					</div>
				</div>
			@endif
			@if(!$errors->isEmpty())
				<div id="message-box">
					<div class="section">
						<div class="action-message">
						@foreach ($errors->all() as $error)
							<span class="flash-message flash-message-error"><span class="ss-alert"></span>{{ $error }}</span>
						@endforeach
						</div>
					</div>
				</div>
			@endif
			@if(Session::get('flash_message_success'))
				<div id="message-box">
					<div class="section">
						<div class="action-message"><span class="flash-message flash-message-success"><span class="ss-check"></span> {{ Session::get('flash_message_success') }}</span></div>
					</div>
				</div>
			@endif
			@if(Input::get('user') == 'new')
			<div id="message-box">
				<div class="section">
					<div class="action-message"><span class="flash-message flash-message-success">User added successfully.</span></div>
				</div>
			</div>
			@endif
			<div id="message-box-json">
				<div class="section">
					<!-- ajax json responses -->
				</div>
			</div>

		</div> <!-- .section -->
	</div> <!-- #header -->
	<div id="nav_menu">
		<div class="section">
			<div id="menu_header">
				<div class="menu_nav">
					<ul id="menu_links">
						<li alt="Dashboard" id="link-dashboard" class="link"><a class="link-href" href="/"><img src="/images/ios-logo-ds.png" alt="InsideOut Solutions Logo" /><span class="link-text">Dashboard</span></a></li>
						<li alt="Projects" id="link-projects" class="link"><a href="/projects" class="ss-list link-href"><span class="link-text">Projects</span></a>{{ find_assigned_count('projects') }}</li>
						<li alt="Billable Updates" id="link-billables" class="link"><a href="/billables" class="ss-dollarsign link-href"><span class="link-text">Billables</span></a>{{ find_assigned_count('billables') }}</li>
						<li alt="Invoices" id="link-invoices" class="link"><a href="/invoices" class="ss-file link-href"><span class="invoice-dollar">$</span><span class="link-text">Invoices</span></a></li>
						<li alt="Accounts" id="link-accounts" class="link"><a href="/accounts" class="ss-buildings link-href"><span class="link-text">Accounts</span></a></li>
						<li alt="Calendar" id="link-calendar" class="link"><a href="/calendar" class="ss-calendar link-href"><span class="link-text">Calendar</span></a>{{ find_assigned_count('calendar') }}</li>
						<li alt="Internal Help" id="link-help" class="link"><a href="/help" class="ss-help link-href"><span class="link-text">Help</span></a>{{ find_assigned_count('help') }}</li>
						<li alt="News" id="link-news" class="link"><a href="/news" class="ss-newspaper link-href"><span class="link-text">News</span></a>{{ find_unread_count('articles') }}
						<ul class="sub_menu_links-hover">
							<li class="sub-link"><a href="/news/">All</a></li>
							<li class="sub-link"><a href="/news/unread">Unread</a></li>
							<li class="sub-link"><a href="/news/favorites">Favorites</a></li>
							<li class="sub-link"><a href="/news/mentions">Mentions</a></li>
							<li class="sub-link"><a href="/news/drafts">Drafts</a></li>
						</ul>
						</li>
						<ul class="sub_menu_links">
							<li class="sub-link"><a href="/news/">All</a></li>
							<li class="sub-link"><a href="/news/unread">Unread</a></li>
							<li class="sub-link"><a href="/news/favorites">Favorites</a></li>
							<li class="sub-link"><a href="/news/mentions">Mentions</a></li>
							<li class="sub-link"><a href="/news/drafts">Drafts</a></li>
						</ul>
						<li alt="Wiki" id="link-wiki" class="link"><a href="/wiki" class="ss-compose link-href"><span class="link-text">Wiki</span></a></li>
						<li alt="Tools" id="link-tools" class="link"><a href="/tools" class="ss-flask link-href"><span class="link-text">Tools</span></a></li>
						<li alt="Profile" id="link-profile" class="link"><a href="/profile/" class="link-href"><img src="{{ gravatar_url(Auth::user()->email,35) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"><span class="link-text">{{ Auth::user()->first_name }}</span></a><span id="linked-to-profile" class="linked-to" value=""><a href="/to-do/{{ Auth::user()->user_path }}"></a></span>
						<ul class="sub_menu_links-hover">
							<li><a href="/to-do/{{ Auth::user()->user_path }}" class="sub-link">To-Do List</a></li>
							@if(Auth::user()->userrole == 'admin')
							<li class="sub-link"><a href="/admin/">Admin</a></li>
							@endif
							<li><a href="/logout" class="sub-link">Logout</a></li>
						</ul>
						</li>
						<ul class="sub_menu_links">
							<li><a href="/to-do/{{ Auth::user()->user_path }}" class="sub-link">To-Do List</a></li>
							@if(Auth::user()->userrole == 'admin')
							<li class="sub-link"><a href="/admin/">Admin</a></li>
							@endif
							<li><a href="/logout" class="sub-link">Logout</a></li>
						</ul>
					</ul>
				</div> <!-- .menu_nav -->
			</div> <!-- #menu_header -->
		</div> <!-- #nav_menu -->
	</div>
	<div id="page">
		<div class="section">
			
			<div id="content">
				@yield('page-content')
			</div> <!-- #content -->

			<div class="clear"></div>
		</div> <!-- .section -->
	</div> <!-- #page -->

	<div id="footer">
		<div class="section">
			<div class="footer-text">
				<p>Designed and Developed by the <a href="mailto:devteam@insideout.com?subject=Remote Office">IOS DevTeam</a> |
				&copy; 2010-{{ Carbon::now()->format('Y') }} <a href="http://insideout.com">InsideOut Solutions</a></p>
			</div>
		</div>
	</div>
@include('layout.js')

@yield('page-js')

@yield('page-foot')
</body>
</html>