@extends('layout.main')

@section('page-title')
{{ 'Accounts' }}
@stop

@section('page-content')
<div id="page-title">
	<h2>Accounts</h2>
</div>

<div class="inner-page">
    Search Accounts: <input type="text" />
    <button>+</button>
    
</div>
<div class="inner-page">
    <ul>
        @foreach($accounts as $a)
			<li>{{ convert_title_to_link("accounts", $a->name) }}</li>
        @endforeach
    </ul>
</div>


@stop