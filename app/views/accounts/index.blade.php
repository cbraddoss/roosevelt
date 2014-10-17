@extends('layout.main')

@section('page-h1')
{{ 'Accounts' }}
@stop

@section('page-h2')
{{ 'All Active Accounts' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('accounts.partials.accounts-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="accounts-page" class="inner-page">
	<h2>@yield('page-h2')
	<small class="count-of-total">[{{ count($accounts) }} of {{ $accountsCount }}]</small></h2>

	@include('accounts.partials.findAccounts')

</div>

@stop