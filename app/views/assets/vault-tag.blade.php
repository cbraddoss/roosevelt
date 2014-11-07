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
		<li class="right">
			<div id="vault-new-vault-form" class="create-something-new">
				<div class="vault-button"><span class="add-new add-button"><span class="ss-plus"></span> Add New</span></div>
			</div>
		</li>
		<li class="right select-dropdown">
			<span class="ss-dropdown"></span>
			<span class="ss-directup"></span>
			<select filterlink="/assets/vault/tags/" class="filter-this filter-vault-tag tags-filter">
				<option>Tag Filter</option>
				{{ $vaultTagsSelect }}
			</select>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="tags-page"  class="single-page inner-page">
	<h2 class="ss-tag"> @yield('page-h2')
	<small class="count-of-total">[{{ count($vaults) }} of {{ $vaultsCount }}]</small></h2>
	
	@include('assets.partials.findVaultAssets')
	
</div>
@stop