@foreach($vaults as $vault)
<div id="vault-asset-{{ $vault->id }}" class="office-post">
	
	@if($vault->type == 'website')
	<h3 class="ss-globe tooltip-hover">
		<a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a>
		
	</h3>
	@elseif($vault->type == 'ftp')
	<h3 class="ss-transfer tooltip-hover">
		<a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a>
		
	</h3>
	@elseif($vault->type == 'database')
	<h3 class="ss-database tooltip-hover">
		<a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a>
		
	</h3>
	@elseif($vault->type == 'email')
	<h3 class="ss-mail tooltip-hover">
		<a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a>
		
	</h3>
	@elseif($vault->type == 'server')
	<h3 class="ss-hdd tooltip-hover">
		<a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a>
		
	</h3>
	@elseif($vault->type == 'generic')
	<h3 class="ss-file tooltip-hover">
		<a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a>
		
	</h3>
	@endif
	<div class="post-tags">
		{{ $vault->displayTags($vault->tag_id) }}
	</div>
</div>
@endforeach