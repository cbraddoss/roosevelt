<li class="right">
	<div id="vault-new-vault-form" class="create-something-new">
		<div class="vault-button"><span formtype="add-vault-asset" formlocation="/assets/vault/create" class="add-new add-button"><span class="ss-plus"></span> Add New</span></div>
	</div>
</li>
<li class="right">
	<div filterlink="/assets/vault/date/" class="filter-this-date filter-date vault-filter add-button" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
		<span class="ss-calendar"></span>
		<span> Date Filter</span>
	</div>
</li>
<li class="right filter-show this-filter-show">
	<span class="show-this-filter ss-navigatedown add-button"> Filters</span>
</li>
<li class="page-menu-sub">
	<ul>
		<li class="right select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select filterlink="/assets/vault/tags/" class="filter-this filter-vault-tag tags-filter">
				<option>Tag Filter</option>
				{{ $vaultTagsSelect }}
			</select>
		</li>
		<li class="right select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select filterlink="/assets/vault/type/" class="filter-this filter-vault-type type-filter">
				<option>Type Filter</option>
				@if(!empty($type) && $type == 'website')
				<option value="website" selected>Website</option>
				@else
				<option value="website">Website</option>
				@endif
				@if(!empty($type) && $type == 'ftp')
				<option value="ftp" selected>FTP</option>
				@else
				<option value="ftp">FTP</option>
				@endif
				@if(!empty($type) && $type == 'database')
				<option value="database" selected>Database</option>
				@else
				<option value="database">Database</option>
				@endif
				@if(!empty($type) && $type == 'email')
				<option value="email" selected>Email</option>
				@else
				<option value="email">Email</option>
				@endif
				@if(!empty($type) && $type == 'server')
				<option value="server" selected>Server</option>
				@else
				<option value="server">Server</option>
				@endif
				@if(!empty($type) && $type == 'generic')
				<option value="generic" selected>Generic</option>
				@else
				<option value="generic">Generic</option>
				@endif
			</select>
		</li>
	</ul>
</li>