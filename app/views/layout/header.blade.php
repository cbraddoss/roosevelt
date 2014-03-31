			<div id="user-menu">
				<div class="section">
					<div class="user-menu-name"><img src="{{ gravatar_url(Auth::user()->email,30) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}"> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
					<ul>
						<li id="link-profile" class="link"><a href="/profile/{{ lcfirst(Auth::user()->first_name) }}-{{ lcfirst(Auth::user()->last_name) }}"><span class="ss-user"></span>Profile</a></li>
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
							<li alt="Projects" id="link-projects" class="link"><a href="/projects" class="ss-list">Projects</a><span class="ss-bookmark"></span><span class="linked-to">5</span></li>
							<li alt="Billable Updates" id="link-billables" class="link"><a href="/billables" class="ss-flag">Billables</a><span class="ss-bookmark"></span><span class="linked-to">3</span></li>
							<li alt="Invoices" id="link-invoices" class="link"><a href="/invoices" class="ss-dollarsign">Invoices</a></li>
							<li alt="Accounts" id="link-accounts" class="link"><a href="/accounts" class="ss-buildings">Accounts</a></li>
							<li alt="Calendar" id="link-calendar" class="link"><a href="/calendar" class="ss-calendar">Calendar</a><span class="ss-bookmark"></span><span class="linked-to">10</span></li>
							<li alt="Internal Help" id="link-help" class="link"><a href="/help" class="ss-help">Help</a><span class="ss-bookmark"></span><span class="linked-to">7</span></li>
							<li alt="News" id="link-news" class="link"><a href="/news" class="ss-newspaper">News</a><span class="ss-bookmark"></span><span class="linked-to">4</span></li>
							<li alt="Wiki" id="link-wiki" class="link"><a href="/wiki" class="ss-compose">Wiki</a></li>
							<li alt="Tools" id="link-tools" class="link"><a href="/tools" class="ss-settings">Tools</a></li>
							<li alt="Search" id="link-search" class="link"><span class="ss-search">Search</span></li>
						</ul>
					</div> <!-- .menu_nav -->
				</div> <!-- #menu_header -->
				<div id="search-box">
					<p>Search for a Project, Account, Contact, Due Date (Aug 21, 2014), or Wiki entry!</p>
					<input type="text" class="search" name="s" id="s" placeholder="Search" /><input class="search-submit" type="submit" value="Search" />
				</div>
			</div> <!-- #nav_menu -->