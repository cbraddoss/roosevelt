<li><a id="pagelink-profile" href="/profile" class="link">Profile</a></li>
<li><a id="pagelink-to-do-brad-doss" href="/to-do/{{ Auth::user()->user_path }}" class="link">To-Do</a></li>
@if(Auth::user()->userrole == 'admin')
<li><a id="pagelink-admin-templates" href="/admin/templates" class="link">Template Admin</a></li>
<li><a id="pagelink-admin-users" href="/admin/users" class="link">User Admin</a></li>
<li class="right">
	<div id="admin-new-template-form" class="create-something-new">
		<div class="template-button"><span formtype="add-template" formlocation="/admin/templates/create" class="add-new add-button"><span class="ss-plus"></span> Template</span></div>
	</div>
</li>
<li class="right">
	<div id="admin-new-user-form" class="create-something-new">
		<div class="admin-button"><span formtype="add-user" formlocation="/admin/users/create" class="add-new add-button"><span class="ss-plus"></span> User</span></div>
	</div>
</li>
@endif