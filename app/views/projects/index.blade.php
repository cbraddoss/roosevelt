@extends('layout.main')

@section('page-title')
{{ 'Projects' }}
@stop

@section('page-content')
<div id="projects-page"  class="inner-page">
	<div class="page-menu">
		<ul>
			<li><a href="/projects/" class="link filter-all">All</a></li>
			<li><a href="/projects/assigned/" class="link filter-drafts">Assigned</a></li>
			<li><a href="/projects/priority/" class="link filter-drafts">Priority</a></li>
			<li><a href="/projects/mentions/" class="link filter-mentions">Mentions</a></li>
			<li><a href="/projects/drafts/" class="link filter-drafts">Drafts</a></li>
			<li>
				<select class="filter-author">
					<option value="0">Author Filter</option>
					@if(!empty($userAuthor)) {{ get_user_list_select($userAuthor->first_name.' '.$userAuthor->last_name) }} @else {{ get_user_list_select() }} @endif
				</select>
			</li>
			<li><input type="text" class="datepicker filter-date" value="@if(!empty($date)) {{ $date }} @endif" placeholder="Date Filter" data-date-format="mm-yyyy" data-date-viewmode="months"></li>
		</ul>
		<div id="projects-new-project-form" class="create-something-new">
			<span class="projects-button"><button class="add-new">New Project</button></span>
		</div>
	</div>
	
</div>
@stop