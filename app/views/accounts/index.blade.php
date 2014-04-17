@extends('layout.main')

@section('page-title')
{{ 'Accounts' }}
@stop

@section('page-content')
<div class="inner-page">
    Search Accounts: <input type="text" />
    
    <div><a href="/account-new/">Create a New Account</a></div>
    
</div>
<div class="inner-page">
    <ul>
        @foreach($accounts as $a)
			<li>{{ $a->link) }}</li>
        @endforeach
    </ul>
</div>

@stop