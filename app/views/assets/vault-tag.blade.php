@extends('layout.main')

@section('page-h1')
{{ 'Vault' }}
@stop

@section('page-h2')
{{ 'Tag: ' . ucwords($tag->name) }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('assets.partials.assets-menu')
		@include('assets.partials.vault-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="assets-page"  class="inner-page">
	<h2 class="ss-tag"> @yield('page-h2')
	<small class="count-of-total">[{{ count($vaults) }} of {{ $vaultsCount }}]</small></h2>
	
	@if($vaults->isEmpty())
			<div class="vault-asset">
				<h3>No vault assets found tagged with <i>{{ ucwords($tag->name) }}</i>.</h3>
				<p></p>
			</div>
	@endif

	@include('assets.partials.findVaultAssets')
	
</div>
@stop