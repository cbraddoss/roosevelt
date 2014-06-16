<div class="page-menu">
		<span class="menu-start ss-action"></span>
		<ul>
			<li>
				<select class="filter-status">
					<option value="0">Status Filter</option>
					@if(!empty($open)) <option value="open" selected>Open</option> @else <option value="open">Open</option> @endif
					@if(!empty($closed)) <option value="closed" selected>Closed</option> @else <option value="closed">Closed</option> @endif
					@if(!empty($archived)) <option value="archived" selected>Archived</option> @else <option value="archived">Archived</option> @endif
				</select>
			</li>
			<li>
				<select class="filter-type">
					<option value="0">Type Filter</option>
					@if(!empty($type)) {{ get_project_type_select($type) }} @else {{ get_project_type_select() }} @endif
				</select>
			</li>
			<li>
				<select class="filter-priority">
					<option value="0">Priority Filter</option>
					@if(!empty($low)) <option value="low" selected>Low</option> @else <option value="low">Low</option> @endif
					@if(!empty($normal)) <option value="normal" selected>Normal</option> @else <option value="normal">Normal</option> @endif
					@if(!empty($high)) <option value="high" selected>High</option> @else <option value="high">High</option> @endif
				</select>
			</li>
			<li>
				<select class="filter-user">
					<option value="0">User Filter</option>
					@if(!empty($user)) {{ get_user_list_select($user->first_name.' '.$user->last_name) }} @else {{ get_user_list_select() }} @endif
				</select>
			</li>
			<li>
				<select class="filter-stage">
					<option value="0">Stage Filter</option>
					@if(!empty($stage)) {{ get_project_stage_select($stage) }} @else {{ get_project_stage_select() }} @endif
				</select>
			</li>
			<li><input type="text" class="datepicker filter-date" value="@if(!empty($date)) {{ $date }} @endif" placeholder="Due Date Filter" data-date-format="mm-yyyy" data-date-viewmode="months"></li>
		</ul>
		@if(strpos(current_page(), 'projects/post'))
		<div id="projects-post-comment-form" class="create-something-new">
			<span class="projects-button"><button class="post-comment">Reply</button></span>
		</div>
		@else
		<div id="projects-new-project-form" class="create-something-new">
			<span class="projects-button"><button class="add-new">New Project</button></span>
		</div>
		@endif
	</div>