@extends('layout.main')

@section('page-title')
{{ 'Account - $account' }}
@stop

@section('page-content')
<div id="page-title">
	<h2>Account</h2>
</div>

<div class="inner-page">
    <h3>{{ $account }}</h3>
    
    <div class="row">
        URL: <a href="#">url</a><br />
    </div>
    <div class="row">
    Contacts:<br />
        <a href="#">Contact1</a><br />
        <a href="#">Contact2</a><br />
        <a href="#">Contact3</a><br />
    </div>
    <div class="row">
    Projects:<br />
        <a href="#">Project1</a><br />
    </div>
    <div class="row">
    Available Billable Time: <input type="text" disabled value="0.5" /> hours<br />
    Billable Expire Date: <input type="date" disabled value="05/07" /><br />
    Billable Renew Date: <input type="date" disabled value="05/07" /><br />
    </div>
    <div class="row">
    Billables:<br />
        <a href="#">Billable1</a><br />
        <a href="#">Billable2</a><br />
        <a href="#">Billable3</a><br />
        <a href="#">Billable4</a><br />
        <a href="#">Billable5</a><br />
    </div>
</div>

@stop