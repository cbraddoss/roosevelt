<div class="post-can-manage post-tooltip post-meta">
@if($u->can_manage == 'yes')
	<a class="user-can-manage tooltip-hover ss-key"><span class="tooltip">Can<br />Manage</span></a>
@else
	<span class="user-can-manage tooltip-hover ss-key"><span class="tooltip">Cannot<br />Manage</span></span>
@endif
</div>
<div class="post-user-login post-tooltip post-meta">
@if(user_last_login($u->last_login) != 'No Login Activity')
	<a class="last-login tooltip-hover ss-clock"><span class="tooltip">Last<br />Login</span></a>
	<span class="post-meta-desc">{{ user_last_login($u->last_login) }}</span>
@else
	<span class="last-login tooltip-hover ss-clock"><span class="tooltip">No Last<br />Login :(</span></span>
	<span class="post-meta-desc">{{ user_last_login($u->last_login) }}</span>
@endif
</div>
<div class="post-user-email post-tooltip post-meta">
	<a class="email-address tooltip-hover ss-mail"><span class="tooltip">Email<br />Address</span></a>
	<span class="post-meta-desc">{{ $u->email }}</span>
</div>
<div class="post-user-ip post-tooltip post-meta">
@if(!empty($u->ip_address))
	<a class="ip-address tooltip-hover ss-location"><span class="tooltip">IP<br />Address</span></a>
	<span class="post-meta-desc">{{ $u->ip_address }}</span>
@else
	<span class="ip-address tooltip-hover ss-location"><span class="tooltip">Invalid IP<br />Address</span></span>
	<span class="post-meta-desc">Invalid IP</span>		
@endif
</div>
<div class="post-author post-detail">
	<span><img src="{{ gravatar_url($u->email,30) }}" alt="{{ $u->first_name }} {{ $u->last_name }}" /></span>
</div>
<h3><a href="/admin/users/{{ any_user_path($u->id) }}" class="admin-link userrole-{{ $u->userrole }} status-{{ $u->status }}">{{ $u->first_name }} {{ $u->last_name }}</a></h3>
<div class="post-date post-detail  post-detail-last">
	<span><span class="post-date-text">Created:</span> {{ $u->created_at->format('M d, Y') }}</span>
	<br />
	<span><span class="post-date-text">Updated:</span> {{ $u->updated_at->format('M d, Y') }}</span>
</div>