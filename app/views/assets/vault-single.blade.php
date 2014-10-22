@extends('layout.main')

@section('page-h1')
{{ 'Vault' }}
@stop

@section('page-h2')
{{ $vaultAsset->title }}
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
	</ul>
</div>
@stop

@section('page-content')
<div id="assets-page"  class="inner-page">
	<h2>@yield('page-h2')</h2>

	<p>{{ $vaultAsset->username }}</p>
	
		@if(Auth::user()->can_manage == 'yes')
		<span>Edit Me</span>
		@endif
</div>
@stop