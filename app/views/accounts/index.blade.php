@extends('layout.main')

@section('page-title')
{{ 'Accounts' }}
@stop

@section('page-content')
<div id="page-title">
	<h2>Accounts</h2>
</div>

<div class="inner-page">
    Search Accounts: <form><input type="text" /></form>
</div>
<div class="inner-page">
    <ul>
        <li><a href="/accounts/account1">Account1</a></li>
        <li><a href="/accounts/account2">Account2</a></li>
        <li><a href="/accounts/account3">Account3</a></li>
        <li><a href="/accounts/account4">Account4</a></li>
        <li><a href="/accounts/account5">Account5</a></li>
        <li><a href="/accounts/account6">Account6</a></li>
        <li><a href="/accounts/account7">Account7</a></li>
        <li><a href="/accounts/account8">Account8</a></li>
        <li><a href="/accounts/account9">Account9</a></li>
        <li><a href="/accounts/account10">Account10</a></li>
        <li><a href="/accounts/account11">Account11</a></li>
        <li><a href="/accounts/account12">Account12</a></li>
        <li><a href="/accounts/account13">Account13</a></li>
        <li><a href="/accounts/account14">Account14</a></li>
        <li><a href="/accounts/account15">Account15</a></li>
    </ul>
</div>


@stop