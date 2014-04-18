@extends('layout.main')

@section('page-title')
{{ 'Account - ' . $account->name }}
@stop

@section('page-content')

<style>
    #content .row { padding:5px; margin-bottom:10px; border-bottom: 1px double rgba(32,32,32,0.4); }
    #content .row ul li { border-bottom:0; }
    #content .row span { display:inline-block; width: 200px; font-weight:bold; }
</style>

<div class="inner-page">

    <div class="create-something-new-bg"></div>
    <div id="accounts-new-account-form" class="create-something-new">
        <span class="accounts-button"><button class="add-new">Edit Account</button></span>
    </div>

    <div class="row">
        <span>Status</span>{{ $account->status }}
    </div>
    <div class="row">
        <div><span>Contact E-Mail Address</span>{{ $account->email }}</div>
        <div><span>Address</span>{{ $account->address }}</div>
        <div><span>City</span>{{ $account->city }}</div>
        <div><span>State</span>{{ $account->state }}</div>
        <div><span>ZIP</span>{{ $account->zip }}</div>
        <div><span>Phone Number</span>{{ $account->phone_number }}</div>
        <div><span>Toll Free Number</span>{{ $account->toll_free_number }}</div>
        <div><span>Fax Number</span>{{ $account->fax }}</div>
    </div>
    <div class="row">
        @if (strpos($account->website, 'http://') == NULL)
        <span>Website:</span><a href="http://{{ $account->website }}">http://{{ $account->website }}</a>
        @else
        <span>Website:</span><a href="{{ $account->website }}">{{ $account->website }}</a>
        @endif
    </div>
    <div class="row">
        <div><span>Available Billable Time</span>{{ $account->billable_time }} hours</div>
        <div><span>Billable Time Expire Date</span>{{ $account->billable_expire }}</div>
        <div><span>Billable Time Renew Date</span>{{ $account->billable_renew }}</div>
    </div>
    <div class="row">
        <div><span>Site Designed by IOS</span>{{ $account->site_designed }}</div>
        <div><span>Site Launch Date</span>{{ $account->site_launch_date }}</div>
        <div><span>Hosting Started Date</span>{{ $account->hosting_started }}</div>
        <div><span>Hosting Ended Date</span>{{ $account->hosting_ended }}</div>
        <div><span>Hosting Type</span>{{ $account->hosting_type }}</div>
        <div><span>Hosting Addons</span>{{ $account->hosting_addons }}</div>
    </div>
</div>

<div class="meta">
    Created by 
    @if ( $account->author_id == Auth::user()->id )
        You, 
    @endif
    {{ User::find($account->author_id)->name }} on {{ $account->created_at }}.  Last updated on {{ $account->updated_at }}
</div>
@stop