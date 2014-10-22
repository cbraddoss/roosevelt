@foreach($vaults as $vault)
	@if($vault->type == 'website')
	<span class="ss-globe"><a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a></span>
	@elseif($vault->type == 'ftp')
	<span class="ss-file"><a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a></span>
	@elseif($vault->type == 'database')
	<span class="ss-database"><a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a></span>
	@elseif($vault->type == 'email')
	<span class="ss-mail"><a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a></span>
	@elseif($vault->type == 'server')
	<span class="ss-harddrive"><a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a></span>
	@elseif($vault->type == 'generic')
	<span class="ss-record"><a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a></span>
	@endif
@endforeach