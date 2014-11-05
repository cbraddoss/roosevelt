<!doctype html>
<html lang="en" ng-app>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('page-h2') :: InsideOut Solutions Employee Hub & Remote Office</title>
	
	@include('layout.css')

	@yield('page-css')

	@yield('page-head')
</head>
<body class="{{ body_class() }}">
	<div id="header">
		<div class="section">

			<div id="search-box">
				<div class="search-details">
					{{ Form::open( array('class' => 'office-search', 'url' => '/search', 'method' => 'post') ) }}
					<input type="text" class="search" name="s" id="s" placeholder="The gremlins are still building the search functionality. Check back soon." />
					<!-- <input type="text" class="search" name="s" id="s" placeholder="Search the Office..." /> -->
					{{ Form::close() }}
				</div>
			</div>

			<div id="nav_menu">
				<div class="section">
					<div id="menu_header">
						<div class="menu_nav">
							<ul id="menu_links">
								<li alt="Dashboard" id="link-dashboard" class="link"><a class="ss-home link-href" href="/"><span class="link-text">Dashboard</span></a></li>
								<li alt="Projects" id="link-projects" class="link"><a href="/projects" class="ss-list link-href"><span class="link-text">Projects</span></a>{{ find_assigned_count('projects') }}
								<ul class="sub_menu_links-hover">
									<li class="sub-link"><a href="/projects">All Open</a></li>
									<li class="sub-link"><a href="/projects/date/{{ Carbon::now()->format('Y') }}/{{ Carbon::now()->format('F') }}">Due {{ Carbon::now()->format('F') }}</a></li>
									<li class="sub-link"><a href="/projects/assigned-to/{{ Auth::user()->user_path }}">Your Projects</a></li>
								</ul>
								</li>
								<li alt="Billable Updates" id="link-billables" class="link"><a href="/billables" class="ss-dollarsign link-href"><span class="link-text">Billables</span></a>{{ find_assigned_count('billables') }}
								<ul class="sub_menu_links-hover">
									<li class="sub-link"><a href="/billables">All Open</a></li>
									<li class="sub-link"><a href="/billables/stage/in-production">In Production</a></li>
									<li class="sub-link"><a href="/billables/assigned-to/{{ Auth::user()->user_path }}">Your Billables</a></li>
								</ul>
								</li>
								<li alt="Invoices" id="link-invoices" class="link"><a href="/invoices" class="ss-file link-href"><span class="invoice-dollar">$</span><span class="link-text">Invoices</span></a></li>
								<li alt="Accounts" id="link-accounts" class="link"><a href="/accounts" class="ss-buildings link-href"><span class="link-text">Accounts</span></a>
								<ul class="sub_menu_links-hover">
									<li class="sub-link"><a href="/accounts">All Active</a></li>
									<li class="sub-link"><a href="/accounts/type/hosting">Hosting Client</a></li>
									<li class="sub-link"><a href="/accounts/type/promo">Promo Client</a></li>
									<li class="sub-link"><a href="/accounts/type/print">Print Client</a></li>
								</ul>
								</li>
								<li alt="Calendar" id="link-calendar" class="link"><a href="/calendar" class="ss-calendar link-href"><span class="link-text">Calendar</span></a>{{ find_assigned_count('calendar') }}
								<ul class="sub_menu_links-hover">
									<li class="sub-link"><a href="/calendar">{{ Carbon::now()->format('F') }}</a></li>
									@if(Carbon::now()->format('F') == 'November')
									<li class="sub-link"><a href="/calendar/{{ Carbon::now()->format('Y') }}/{{ Carbon::now()->addMonth()->format('F') }}">{{ Carbon::now()->addMonth()->format('F') }}</a></li>
									<li class="sub-link"><a href="/calendar/{{ Carbon::now()->addYear()->format('Y') }}/{{ Carbon::now()->addMonths(2)->format('F') }}">{{ Carbon::now()->addMonths(2)->format('F') }}</a></li>
									@elseif(Carbon::now()->format('F') == 'December')
									<li class="sub-link"><a href="/calendar/{{ Carbon::now()->addYear()->format('Y') }}/{{ Carbon::now()->addMonth()->format('F') }}">{{ Carbon::now()->addMonth()->format('F') }}</a></li>
									<li class="sub-link"><a href="/calendar/{{ Carbon::now()->addYear()->format('Y') }}/{{ Carbon::now()->addMonths(2)->format('F') }}">{{ Carbon::now()->addMonths(2)->format('F') }}</a></li>
									@else
									<li class="sub-link"><a href="/calendar/{{ Carbon::now()->format('Y') }}/{{ Carbon::now()->addMonth()->format('F') }}">{{ Carbon::now()->addMonth()->format('F') }}</a></li>
									<li class="sub-link"><a href="/calendar/{{ Carbon::now()->format('Y') }}/{{ Carbon::now()->addMonths(2)->format('F') }}">{{ Carbon::now()->addMonths(2)->format('F') }}</a></li>
									@endif
								</ul>
								</li>
								<li alt="Internal Help" id="link-help" class="link"><a href="/help" class="ss-help link-href"><span class="link-text">Help</span></a>{{ find_assigned_count('help') }}</li>
								<li alt="News" id="link-news" class="link"><a href="/news" class="ss-newspaper link-href"><span class="link-text">News</span></a>{{ find_unread_count('articles') }}
								<ul class="sub_menu_links-hover">
									<li class="sub-link"><a href="/news/">All Articles</a></li>
									<li class="sub-link"><a href="/news/unread">Unread</a></li>
									<li class="sub-link"><a href="/news/favorites">Favorites</a></li>
									<li class="sub-link"><a href="/news/mentions">Mentions</a></li>
									<li class="sub-link"><a href="/news/drafts">Drafts</a></li>
								</ul>
								</li>
								<!-- <li alt="Wiki" id="link-wiki" class="link"><a href="/wiki" class="ss-compose link-href"><span class="link-text">Wiki</span></a></li> -->
								<li alt="Assets" id="link-assets" class="link"><a href="/assets" class="ss-briefcase link-href"><span class="link-text">Assets</span></a>
								<ul class="sub_menu_links-hover">
									<li class="sub-link"><a href="/assets/vault">Vault</a></li>
									<li class="sub-link"><a href="/assets/status">Status</a></li>
									<li class="sub-link"><a href="/assets">Assets</a></li>
								</ul>
								</li>
								<li alt="Search" id="link-search" class="link"><a href="#" class="ss-search link-href"><span class="link-text">Search</span></a>
								<ul class="sub_menu_links-hover">
									<li class="sub-link"><a href="#"><span class="link-text">Search All</span></a></li>
									<li class="sub-link"><a href="/tags">Search Tags</a></li>
								</ul>
								</li>
								<li alt="Profile" id="link-profile" class="link"><a href="/profile" class="link-href"><img class="link-image" src="{{ gravatar_url(Auth::user()->email,35) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"><span class="link-text">{{ Auth::user()->first_name }}</span></a><span class="linked-to" value=""><a href="/to-do/{{ current_user_path() }}"></a></span>
									<ul class="sub_menu_links-hover">
										<li><a href="/profile/" class="sub-link">Profile</a></li>
										<li><a href="/to-do/{{ Auth::user()->user_path }}" class="sub-link">To-Do List</a></li>
										@if(Auth::user()->userrole == 'admin')
										<li class="sub-link"><a href="/admin/users/">User Admin</a></li>
										<li class="sub-link"><a href="/admin/templates">Template Admin</a></li>
										@endif
										<li class="sub-link"><a href="/logout/">Logout</a></li>
									</ul>
								</li>
							</ul>
						</div> <!-- .menu_nav -->
					</div> <!-- #menu_header -->
				</div> <!-- .section -->
			</div> <!-- #nav_menu -->
			
			@if(Session::get('flash_message_error'))
				<div id="message-box">
						<div class="close-message ss-delete"></div>
					<div class="section">
						<div class="action-message"><span class="flash-message flash-message-error"><span class="ss-alert"></span>{{ Session::get('flash_message_error') }}</span></div>
					</div>
				</div>
			@endif
			@if(!$errors->isEmpty())
				<div id="message-box">
						<div class="close-message ss-delete"></div>
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
						<div class="close-message ss-delete"></div>
					<div class="section">
						<div class="action-message"><span class="flash-message flash-message-success"><span class="ss-check"></span>{{ Session::get('flash_message_success') }}</span></div>
					</div>
				</div>
			@endif
			<div id="message-box-json">
					<div class="close-message ss-delete"></div>
				<div class="section">
					<!-- ajax json responses -->
				</div>
			</div>

		</div> <!-- .section -->
	</div> <!-- #header -->
	
	<div id="page">
		<div class="section">
			<div id="content">
				<div id="page-title">
					<img class="logo" src="/images/ios-logo-ds.png" alt="IOS Remote Office" />
					<span class="todays-date">{{ Carbon::now()->format('l, F j, 2014') }}</span>
					@if(current_page() == '/')
					<h1>InsideOut Solutions Remote Office</h1>
					@else
					<h1>@yield('page-h1')</h1>
					@endif
				</div>
				<div id="page-nav_menu">
					@yield('header-menu')
				</div>
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
<noscript><p><span class="alert">Oops:</span> JavaScript appears to be disabled in this browser. <br />Please enable to continue.</p></noscript>
</body>
</html>