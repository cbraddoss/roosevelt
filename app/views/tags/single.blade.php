@extends('layout.main')

@section('page-h1')
{{ 'Tags' }}
@stop

@section('page-h2')
{{ 'Tag: ' . ucwords($tag->name) }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('tags.partials.tags-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="tags-page"  class="single-page inner-page">
	<h2 class="ss-tag"> @yield('page-h2')</h2>
	
	@if(!$accounts->isEmpty())
	<h3>Accounts:</h3>
	@include('accounts.partials.findAccounts')
	@endif

	@if(!$projects->isEmpty())
	<h3>Projects:</h3>
	@include('projects.partials.findProjects')
	@endif
	
	@if(!$articles->isEmpty())
	<h3>Articles:</h3>
	@include('news.partials.findArticles')
	@endif
	
	<h3>Vault:</h3>
	@include('assets.partials.findVaultAssets')
	
</div>
@stop