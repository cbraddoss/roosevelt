			<div id="sidebar">
				<div id="todo-welcome">
						<h2><span class="user-image"><img src="images/user-image.png" /></span> Welcome, {{ $user->first_name }}</h2>
					</div>
				<div id="todo-box">
					
					<div id="todo-list">
						<div id="show-tasks-list" class="todo-sub-box">
							<a id="tasks" class="ss-check todo-feed-title" href="#">Your Tasks <span class="todo-num">NUM</span><span class="down-arrow ss-down"></span></a>
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
				<div id="user-menu">
					<a href="/profile/">Profile</a> | @if($user->userrole == 'admin')<a href="/admin/">Admin</a> | @endif<a href="/logout">Logout</a>
				</div>
			</div>