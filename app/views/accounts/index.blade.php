@extends('layout.main')

@section('page-title')
{{ 'Accounts' }}
@stop

@section('page-content')
<div id="accounts-page" class="inner-page">

<div class="create-something-new-bg"></div>
<div id="accounts-new-account-form" class="create-something-new">
	<span class="accounts-button"><button class="add-new">Add New</button></span>
</div>

    <ul>
        @foreach($accounts as $a)
			<li>{{ link_to('/accounts/'.$a->link, $a->name) }}</li>
        @endforeach
    </ul>
</div>

@stop