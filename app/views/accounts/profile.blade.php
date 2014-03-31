@extends('layout.main')

@section('page-title')
{{ 'Account - $account' }}
@stop

@section('page-content')

<style>
    #content .row { padding:5px; margin-bottom:10px; border-bottom: 1px double rgba(32,32,32,0.4); }
    #content .row ul li { border-bottom:0; }
    #content .row span { display:inline-block; width: 200px; }
</style>

<div id="page-title">
	<h2>Account</h2>
</div>

<div class="inner-page">
    <h3>{{ $account }}</h3>
    
    <div class="row">
        <span>Website:</span><input type="text" disabled value="#" /> <a href="#">View</a>
    </div>
    <div class="row">
        <div>Contacts:</div>
        <ul>
            <li><a href="#">Contact1</a></li>
            <li><a href="#">Contact2</a></li>
            <li><a href="#">Contact3</a></li>
        </ul>
    </div>
    <div class="row">
        <div>Projects:</div>
        <ul>
            <li><a href="#">Project1</a></li>
        </ul>
    </div>
    <div class="row">
        <div><span>Available Billable Time:</span><input type="text" disabled value="0.5" /> hours</div>
        <div><span>Billable Time Expire Date:</span><input type="date" disabled value="05/07" /></div>
        <div><span>Billable Time Renew Date:</span><input type="date" disabled value="05/07" /></div>
    </div>
    <div class="row">
        <div>Billables:</div>
        <ul>
            <li><a href="#">Billable1</a></li>
            <li><a href="#">Billable2</a></li>
            <li><a href="#">Billable3</a></li>
            <li><a href="#">Billable4</a></li>
            <li><a href="#">Billable5</a></li>
        </ul>
    </div>
</div>

@stop