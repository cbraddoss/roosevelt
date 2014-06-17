<div id="news-new-article-form" class="create-something-new">
		<span class="news-button"><button class="add-new ss-plus">Add New</button></span>
	</div>
<div class="page-menu">
	<ul>
		<li><span class="ss-filter"></span></li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-type">
				<option value="0">Type Filter</option>
				<option value="unread">Unread</option>
				<option value="mentions">Mentions</option>
				<option value="favorites">Favorites</option>
				<option value="drafts">Drafts</option>
			</select>
		</li>
		<li class="select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select class="filter-author">
				<option value="0">Author Filter</option>
				@if(!empty($userAuthor)) {{ get_user_list_select($userAuthor->first_name.' '.$userAuthor->last_name) }} @else {{ get_user_list_select() }} @endif
			</select>
		</li>
		<li>
			<div class="filter-date" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
				<span>Date Filter:</span>
				<span class="ss-calendar"></span>
			</div>
		</li>
	</ul>
</div>