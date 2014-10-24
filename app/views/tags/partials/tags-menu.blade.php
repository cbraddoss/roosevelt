<li><a id="pagelink-tags" href="/tags" class="link">All Tags</a></li>
<li><a id="pagelink-tags-recent" href="/tags/recent" class="link">Recent</a></li>
<li class="right select-dropdown">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
	<select class="filter-letter tags-filter">
		<option>Letter Filter</option>
		{{ $tagSelect }}
	</select>
</li>
<li class="right select-dropdown">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
	<select class="filter-tag-type tags-filter">
		<option>Type Filter</option>
		@if(!empty($type) && $type == 'account')
		<option value="account" selected>Accounts</option>
		@else
		<option value="account">Accounts</option>
		@endif

		@if(!empty($type) && $type == 'project')
		<option value="project" selected>Projects</option>
		@else
		<option value="project">Projects</option>
		@endif

		@if(!empty($type) && $type == 'billables')
		<option value="billables" selected>Billables</option>
		@else
		<option value="billables">Billables</option>
		@endif

		@if(!empty($type) && $type == 'articles')
		<option value="articles" selected>News</option>
		@else
		<option value="articles">News</option>
		@endif

		@if(!empty($type) && $type == 'help')
		<option value="help" selected>Help</option>
		@else
		<option value="help">Help</option>
		@endif

		@if(!empty($type) && $type == 'invoice')
		<option value="invoice" selected>Invoices</option>
		@else
		<option value="invoice">Invoices</option>
		@endif

		@if(!empty($type) && $type == 'vault')
		<option value="vault" selected>Vault</option>
		@else
		<option value="vault">Vault</option>
		@endif
		
		@if(!empty($type) && $type == 'asset')
		<option value="asset" selected>Assets</option>
		@else
		<option value="asset">Assets</option>
		@endif
		<!-- <option value="personal">Personal</option> -->
	</select>
</li>