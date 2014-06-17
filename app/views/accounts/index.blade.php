@extends('layout.main')

@section('page-title')
{{ 'Accounts' }}
@stop

@section('page-content')
<div id="accounts-page" class="inner-page">
	<div id="accounts-new-account-form" class="create-something-new">
		<span class="accounts-button"><button class="add-new ss-plus">Add New</button></span>
	</div>
	<div class="page-menu">
		<ul>
			<li></li>
			<li></li>
		</ul>
		
	</div>

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