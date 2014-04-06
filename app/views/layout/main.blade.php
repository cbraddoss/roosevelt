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
<body>
	<div id="header">
		<div class="section">
			<div id="user-menu">
				<div class="section">
					<div class="user-menu-name"><img src="{{ gravatar_url(Auth::user()->email,30) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
					<ul>
						<li id="link-profile" class="link"><a href="/profile/"><span class="ss-user"></span>Profile</a></li>
						@if(Auth::user()->userrole == 'admin')
						<li id="link-admin" class="link"><a href="/admin/"><span class="ss-settings"></span>Admin</a></li>
						@endif
						<li id="link-logout" class="link"><a href="/logout"><span class="ss-logout"></span>Logout</a></li>
					</ul>
				</div>
			</div>
			<div id="company-header">
				<a class="logo" href="/"><img src="/images/ios-logo-remote-office.png" alt="InsideOut Solutions Logo" /></a>
			</div>
			<div id="nav_menu">
				<div id="menu_header">
					<div class="menu_nav">
						<ul id="menu_links">
							<li alt="Dashboard" id="link-dashboard" class="link active"><a class="ss-home" href="/">Dashboard</a></li>
							<li alt="Projects" id="link-projects" class="link"><a href="/projects" class="ss-list">Projects</a>{{ find_assigned_count('projects') }}</li>
							<li alt="Billable Updates" id="link-billables" class="link"><a href="/billables" class="ss-flag">Billables</a>{{ find_assigned_count('billables') }}</li>
							<li alt="Invoices" id="link-invoices" class="link"><a href="/invoices" class="ss-dollarsign">Invoices</a></li>
							<li alt="Accounts" id="link-accounts" class="link"><a href="/accounts" class="ss-buildings">Accounts</a></li>
							<li alt="Calendar" id="link-calendar" class="link"><a href="/calendar" class="ss-calendar">Calendar</a>{{ find_assigned_count('calendar') }}</li>
							<li alt="Internal Help" id="link-help" class="link"><a href="/help" class="ss-help">Help</a>{{ find_assigned_count('help') }}</li>
							<li alt="News" id="link-news" class="link"><a href="/news" class="ss-newspaper">News</a>{{ find_unread_count('articles') }}</li>
							<li alt="Wiki" id="link-wiki" class="link"><a href="/wiki" class="ss-compose">Wiki</a></li>
							<li alt="Tools" id="link-tools" class="link"><a href="/tools" class="ss-flask">Tools</a></li>
							<li alt="Search" id="link-search" class="link"><span class="ss-search">Search</span></li>
						</ul>
					</div> <!-- .menu_nav -->
				</div> <!-- #menu_header -->
				<div id="search-box">
					<p>Search for a Project, Account, Contact, Due Date (Aug 21, 2014), or Wiki entry!</p>
					<input type="text" class="search" name="s" id="s" placeholder="Search" /><input class="search-submit" type="submit" value="Search" />
				</div>
			</div> <!-- #nav_menu -->
		</div> <!-- .section -->
	</div> <!-- #header -->

	<div id="side">
		<div class="section">
			<div id="sidebar">
				<div id="todo-box">
					
					<div id="todo-list">
						<div id="show-tasks-list" class="todo-sub-box">
							<a id="tasks" class="ss-check todo-feed-title active" href="#">Your Tasks <span class="todo-num">NUM</span><span class="down-arrow ss-down"></span></a>
							<ul id="tasks-feed" class="todo-feed">
								<li class=""><a href="#" class="task-item">TITLE</a> <span>DUEDATE</span></li>
								<li class=""><a href="#" class="task-item">TITLE</a> <span>DUEDATE</span></li>
								<li class=""><a href="#" class="task-item">TITLE</a> <span>DUEDATE</span></li>
								<li class=""><a href="#" class="task-item">TITLE</a> <span>DUEDATE</span></li>
								<li><a href="#" class="task-item view-all">View all...</a></li>
							</ul>
						</div>
						<div id="show-leads-list" class="todo-sub-box">
							<a id="leads" class="ss-briefcase todo-feed-title" href="#">Current Leads <span class="todo-num">NUM</span><span class="down-arrow ss-down"></span></a>
							<ul id="leads-feed" class="todo-feed">
								<li><a href="#" class="leads-item">TITLE</a> <span>DUEDATE</span></li>
								<li><a href="#" class="leads-item">TITLE</a> <span>DUEDATE</span></li>
								<li><a href="#" class="leads-item">TITLE</a> <span>DUEDATE</span></li>
								<li><a href="#" class="leads-item">TITLE</a> <span>DUEDATE</span></li>
								<li><a href="#" class="leads-item">TITLE</a> <span>DUEDATE</span></li>
								<li><a href="#" class="leads-item view-all">View all...</a></li>
							</ul>
						</div>
						<div id="show-projects-list" class="todo-sub-box">
							<a id="projects" class="ss-list todo-feed-title" href="#">Projects <span class="todo-num">NUM</span><span class="down-arrow ss-down"></span></a>
							<ul id="projects-feed" class="todo-feed">
								<li><a href="#" class="projects-item">TITLE</a> <span>DUEDATE</span></li>
								<li><a href="#" class="projects-item">TITLE</a> <span>DUEDATE</span></li>
								<li><a href="#" class="projects-item">TITLE</a> <span>DUEDATE</span></li>
								<li><a href="#" class="projects-item view-all">View all...</a></li>
							</ul>
						</div>
					</div> <!-- #todo-list -->
				</div> <!-- #todo-box -->
			</div>
		</div>
	</div>

	<div id="page">
		<div class="section">
			
			<div id="content">
				<div id="page-title">
					<h2>@yield('page-title')</h2>
				</div>

				@yield('page-content')
			</div> <!-- #content -->

			<div class="clear"></div>
		</div> <!-- .section -->
	</div> <!-- #page -->
	<div class="success-notice"><span class="ss-check"></span><p></p></div>
	<div class="error-notice"><span class="ss-delete"></span><p></p></div>

@include('layout.js')

@yield('page-js')

@yield('page-foot')
</body>
</html>