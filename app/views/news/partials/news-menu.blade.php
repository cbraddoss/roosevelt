<li><a id="pagelink-news" href="/news" class="link">All</a></li>
<li><a id="pagelink-news-unread" href="/news/unread" class="link">Unread</a></li>
<li><a id="pagelink-news-favorites" href="/news/favorites" class="link">Favorites</a></li>
<li><a id="pagelink-news-mentions" href="/news/mentions" class="link">Mentions</a></li>
<li><a id="pagelink-news-drafts" href="/news/drafts" class="link">Drafts</a></li>
<li class="right">
	<div id="news-new-article-form" class="create-something-new">
		<span class="news-button"><span formtype="add-article" formlocation="/news/create" class="add-button ss-plus"> Add New</button></span>
	</div>
</li>
<li class="right">
	<div filterlink="/news/date/" class="filter-this-date filter-date news-filter add-button" data-date="{{ Carbon::now()->format('m-Y') }}" data-date-format="mm-yyyy" data-date-viewmode="months">
		<span class="ss-calendar"></span>
		<span> Date Filter</span>
	</div>
</li>
<li class="right filter-show this-filter-show">
	<span class="show-this-filter ss-navigatedown add-button"> Filters</span>
</li>
<li class="page-menu-sub">
	<ul>
		<li class="sub-ident ss-users"><span ></span></li>
		<li class="select-dropdown right">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select filterlink="/news/author/" class="filter-this filter-author news-filter">
				<option value="0">Author Filter</option>
				@if(!empty($userAuthor)) {{ get_user_list_select($userAuthor->first_name.' '.$userAuthor->last_name) }} @else {{ get_user_list_select() }} @endif
			</select>
		</li>
		<li class="sub-ident ss-tag"><span></span></li>
		<li class="right select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select filterlink="/news/tag/" class="filter-this filter-vault-tag tags-filter">
				<option>Tag Filter</option>
				{{ $articleTagsSelect }}
			</select>
		</li>
	</ul>
</li>