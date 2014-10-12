<li><a id="pagelink-projects" href="/projects" class="link">Open</a></li>
<li><a id="pagelink-projects-date" href="/projects/date/{{ Carbon::now()->format('Y') }}/{{ Carbon::now()->format('F') }}" class="link">Due {{ Carbon::now()->format('F') }}</a></li>
<li><a id="pagelink-projects-{{ Auth::user()->user_path }}" href="/projects/assigned-to/{{ Auth::user()->user_path }}" class="link">Your Projects</a></li>
<li class="right">
	<div id="projects-new-project-form" class="create-something-new">
		<div class="admin-button"><span class="projects-button add-button"><span class="ss-plus"> Add New</span></span></div>
	</div>
</li>