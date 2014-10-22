@extends('layout.main')

@section('page-h1')
{{ 'Vault' }}
@stop

@section('page-h2')
{{ 'Vault Assets:' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('assets.partials.assets-menu')
		@if(Auth::user()->can_manage == 'yes')
		<li class="right">
			<div id="vault-new-vault-form" class="create-something-new">
				<div class="vault-button"><span class="add-new add-button"><span class="ss-plus"></span> Add New</span></div>
			</div>
		</li>
		@endif
	</ul>
</div>
@stop

@section('page-content')
<div id="assets-page"  class="inner-page">
	<h2>@yield('page-h2')
	<small class="count-of-total">[{{ count($vaults) }} of {{ $vaultsCount }}]</small></h2>

	@if($vaults->isEmpty())
		<p>No Vault assets found. Please try again.</p>
	@else
		@include('vaults.partials.findVaults')
	@endif
</div>
@stop