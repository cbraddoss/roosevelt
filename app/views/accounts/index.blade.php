@extends('layout.main')

@section('page-title')
{{ 'Accounts' }}
@stop

@section('page-content')
<div id="accounts-page" class="inner-page">

	<div class="page-menu">
		<div class="page-menu-arrow"></div>
		<ul>
			<li></li>
			<li></li>
		</ul>
		<div id="accounts-new-account-form" class="create-something-new">
			<span class="accounts-button"><button class="add-new">Add New</button></span>
		</div>
	</div>

    <ul>
        @foreach($accounts as $a)
			<li>{{ link_to('/accounts/'.$a->link, $a->name) }}</li>
        @endforeach
    </ul>
</div>

@stop