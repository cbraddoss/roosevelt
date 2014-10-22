@extends('layout.main')

@section('page-h1')
{{ 'Vault' }}
@stop

@section('page-h2')
{{ 'Vault Access:' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('assets.partials.assets-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="assets-page"  class="inner-page">
	<h2>@yield('page-h2')</h2>

	{{ Form::open( array('id' => 'vault-access', 'class' => 'vault-access-form', 'url' => '/assets/vault/access', 'method' => 'post') ) }}
	
	@if(!empty($vault_message))
	<p>{{ $vault_message }}</p>
	@endif
	
	<span class="ss-lock"></span>{{ Form::password('vault_key', array('placeholder' => 'Enter Vault Key', 'class' => 'field')) }}

	{{ Form::close() }}
</div>
@stop