@extends('layout.main')

@section('page-h1')
{{ 'Accounts' }}
@stop

@section('page-h2')
{{ 'All Accounts' }}
@stop

@section('header-menu')
	<div class="page-menu">
		<ul>
			<li><a id="pagelink-accounts" href="/accounts" class="link">All</a></li>
			<li><a id="pagelink-accounts-recent" href="/accounts/recent" class="link">Recent</a></li>
			<li class="right">
				<div id="accounts-new-account-form" class="create-something-new">
					<div class="account-button"><span class="add-new add-button"><span class="ss-plus"></span> Account</span></div>
				</div>
			</li>
		</ul>
		
	</div>
@stop

@section('page-content')
<div id="accounts-page" class="inner-page">
	<h2>@yield('page-h2')</h2>
    @foreach($accounts as $a)
	<div id="account-{{ $a->id }}" class="account-entry office-post">
		<h3>{{ link_to('/accounts/'.$a->link, $a->name) }}</h3>
		<div class="post activity">
			<p class="ss-users"><a></a></p>
		</div>

	</div>
    @endforeach

</div>

@stop