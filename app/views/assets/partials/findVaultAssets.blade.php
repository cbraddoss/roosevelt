@foreach($vaults as $vault)
<div id="vault-asset-{{ $vault->id }}" class="office-post vault-post">
	
	@if($vault->type == 'website')
	<div class="post-meta post-tooltip">
		<a class="ss-globe tooltip-hover"><span class="tooltip">Website<br />Login</span></a>
	</div>
	@elseif($vault->type == 'ftp')
	<div class="post-meta post-tooltip">
		<a class="ss-transfer tooltip-hover"><span class="tooltip">FTP<br />Login</span></a>
	</div>
	@elseif($vault->type == 'database')
	<div class="post-meta post-tooltip">
		<a class="ss-database tooltip-hover"><span class="tooltip">Database<br />Login</span></a>
	</div>
	@elseif($vault->type == 'email')
	<div class="post-meta post-tooltip">
		<a class="ss-mail tooltip-hover"><span class="tooltip">Email<br />Login</span></a>
	</div>
	@elseif($vault->type == 'server')
	<div class="post-meta post-tooltip">
		<a class="ss-hdd tooltip-hover"><span class="tooltip">Server<br />Login</span></a>
	</div>
	@elseif($vault->type == 'generic')
	<div class="post-meta post-tooltip">
		<a class="ss-file tooltip-hover"><span class="tooltip">Generic<br />Login</span></a>
	</div>
	@endif

	@if($vault->getAttachments($vault->id))
	<div class="post-attachment post-meta">
		<a class="ss-attach post-icon tooltip-hover"><span class="tooltip">Has<br />Attachment</span></a>
	</div>
	@else
	<div class="post-attachment post-meta">
		<span class="ss-attach post-icon tooltip-hover"><span class="tooltip">No<br />Attachment</span></span>
	</div>		
	@endif
	<h3><a href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a></h3>
	
	<div class="post-tags">
		{{ $vault->displayTags($vault->id, 'vault') }}
	</div>
	<p class="vault-note">{{ display_content($vault->notes, '75') }}</p>
</div>
@endforeach