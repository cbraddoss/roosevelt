@extends('layout.main')

@section('page-title')
{{ 'Account - $account' }}
@stop

@section('page-content')

<style>
    #content .row { padding:5px; margin-bottom:10px; border-bottom: 1px double rgba(32,32,32,0.4); }
    #content .row ul li { border-bottom:0; }
    #content .row span { display:inline-block; width: 200px; font-weight:bold; }
</style>

<?php $a = Account::where('name', '=', convert_link_to_title($account))->get()->first(); ?>

<div id="page-title">
	<h2>Account - {{ $a->name }}</h2>
</div>

<div class="inner-page">
    <div class="row">
        <span>Status</span>{{ $a->status }}
    </div>
    <div class="row">
        <div><span>Contact E-Mail Address</span>{{ $a->email }}</div>
        <div><span>Address</span>{{ $a->address }}</div>
        <div><span>City</span>{{ $a->city }}</div>
        <div><span>State</span>{{ $a->state }}</div>
        <div><span>ZIP</span>{{ $a->zip }}</div>
        <div><span>Phone Number</span>{{ $a->phone_number }}</div>
        <div><span>Toll Free Number</span>{{ $a->toll_free_number }}</div>
        <div><span>Fax Number</span>{{ $a->fax }}</div>
    </div>
    <div class="row">
        @if (strpos($a->website, 'http://') == NULL)
        <span>Website:</span><a href="http://{{ $a->website }}">http://{{ $a->website }}</a>
        @else
        <span>Website:</span><a href="{{ $a->website }}">{{ $a->website }}</a>
        @endif
    </div>
    <div class="row">
        <div><span>Available Billable Time</span><input type="text" disabled value="{{ $a->billable_time }}" /> hours</div>
        <div><span>Billable Time Expire Date</span><input type="date" disabled value="{{ $a->billable_expire }}" /></div>
        <div><span>Billable Time Renew Date</span><input type="date" disabled value="{{ $a->billable_renew }}" /></div>
    </div>
    <div class="row">
        <div><span>Site Designed by IOS</span>{{ $a->site_designed }}</div>
        <div><span>Site Launch Date</span>{{ $a->site_launch_date }}</div>
        <div><span>Hosting Started Date</span>{{ $a->hosting_started }}</div>
        <div><span>Hosting Ended Date</span>{{ $a->hosting_ended }}</div>
        <div><span>Hosting Type</span>{{ $a->hosting_type }}</div>
        <div><span>Hosting Addons</span>{{ $a->hosting_addons }}</div>
    </div>
</div>

@stop