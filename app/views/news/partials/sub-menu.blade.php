<div class="page-menu">
		<ul>
			<li><a href="/news/" class="link filter-all">All</a></li>
			<li><a href="/news/unread/" class="link filter-unread">Unread</a></li>
			<li><a href="/news/favorites/" class="link filter-favorites">Favorites</a></li>
			<li><a href="/news/mentions/" class="link filter-mentions">Mentions</a></li>
			<li><a href="/news/drafts/" class="link filter-drafts">Drafts</a></li>
			<li>
				<select class="filter-author">
					<option value="0">Author Filter</option>
					@if(!empty($userAuthor)) {{ get_user_list_select($userAuthor->first_name.' '.$userAuthor->last_name) }} @else {{ get_user_list_select() }} @endif
				</select>
			</li>
			<li><input type="text" class="datepicker filter-date" value="@if(!empty($date)) {{ $date }} @endif" placeholder="Date Filter" data-date-format="mm-yyyy" data-date-viewmode="months"></li>
		</ul>
		@if(strpos(current_page(), 'news/article'))
		<div id="news-post-comment-form" class="create-something-new">
			<span class="news-button"><button class="post-comment">Reply</button></span>
		</div>
		@else
		<div id="news-new-article-form" class="create-something-new">
			<span class="news-button"><button class="add-new">New Post</button></span>
		</div>
		@endif
	</div>
