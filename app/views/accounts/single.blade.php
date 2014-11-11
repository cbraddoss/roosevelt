@extends('layout.main')

@section('page-js')
{{ $mapJS }}
@stop

@section('page-h1')
{{ 'Accounts' }}
@stop

@section('page-h2')
{{ $account->name }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<div class="page-meta post-tooltip">
				@if($account->status == 'active')
					<a class="account-status account-status-active ss-check">{{ ucwords($account->status) }}</a>
				@else
					<span class="account-status account-status-inactive ss-alert">{{ ucwords($account->status) }}</span>
				@endif
			</div>
		</li>
		<li>
			<div class="page-meta post-tooltip">
				<a href="http://{{ $account->website }}" target="_blank" class="account-website ss-globe">{{ $account->website }}</a>
			</div>
		</li>
		@if($account->past_due == 'yes')
		<li class="right">
			<div class="page-meta post-tooltip">
				<a class="account-pastdue ss-alert">90 Past Due!</a>
			</div>
		</li>
		@endif
	</ul>
</div>
@stop

@section('page-content')
<div id="accounts-page"  class="single-page inner-page">
@if($account->past_due == 'yes')
<h2 class="tooltip-hover ss-alert account-past-due"> @yield('page-h2')
<span class="tooltip">Account<br />Past Due!</span></h2>
@else
<h2>@yield('page-h2')</h2>
@endif

<div id="account-{{ $account->id }}" class="accounts-account office-post-single" slug="{{ $account->slug }}">

		{{ Form::open( array('id' => 'add-tag-'.$account->id, 'class' => 'add-new-tag', 'url' => '/tags/newtag/'.$account->id, 'method' => 'post') ) }}
		<div class="post-tags post-tooltip">
			<h3 class="ss-tag">Tags:</h3>
			<div class="tags-added-ajax tags-existing-ajax" formtypeid="{{ $account->id }}" formtype="add-tag-type" formlocation="/accounts/singleviewupdate/{{ $account->id }}/tag_id">{{ $account->displayTags($account->id, 'account') }}</div>
			<span class="tag-addnew tooltip-hover ss-plus add-button"><span class="tooltip">Add New<br />Tag</span></span>
			{{ Form::text('tag_name', null, array('placeholder' => 'Add tags one at a time.', 'class' => 'none addnew-tag search-tags')) }}
			{{ Form::hidden('tag_id', null, array('class' => 'accounts-account-tag-id')) }}
			<div class="tags-search-ajax"></div>
		</div>
		{{ Form::close() }}

		<div class="post-account-contact-info">
			<div class="contact-info-map">
				{{ $mapMap }}
			</div>
			<h3 class="ss-signpost">Contact Info:</h3>
			<div class="contact-info-field email-address">
				<span class="contact-info-icon ss-mail tooltip-hover"><span class="tooltip">Email<br />Address</span></span>
				<span class="contact-info-text"><a href="mailto:{{ $account->email }}">{{ $account->email }}</a></span>
			</div>
			<div class="contact-info-field website-address">
				<span class="contact-info-icon ss-globe tooltip-hover"><span class="tooltip">Website<br />Address</span></span>
				<span class="contact-info-text"><a href="http://{{ $account->website }}">{{ $account->website }}</a></span>
			</div>
			<div class="contact-info-field physical-address">
				<span class="contact-info-icon ss-location tooltip-hover"><span class="tooltip">Physical<br />Address</span></span>
				<div class="contact-info-multi-text">
					<span class="contact-info-text">{{ $account->address }}</span>
					<span class="contact-info-text">{{ $account->city }}, {{ $account->state }}</span>
					<span class="contact-info-text">{{ $account->zip }}</span>
				</div>
				
			</div>
			<div class="contact-info-field phone-number">
				<span class="contact-info-icon ss-phone tooltip-hover"><span class="tooltip">Phone<br />Number</span></span>
				<span class="contact-info-text">{{ $account->phone_number }}</span>
			</div>
			<div class="contact-info-field toll-free-number">
				<span class="contact-info-icon ss-phone tooltip-hover"><span class="tooltip">800<br />Number</span></span>
				@if(empty($account->toll_free_number))
				<span class="contact-info-text"><span class="add-something-form ss-plus">Add one</span></span>
				@else
				<span class="contact-info-text">{{ $account->toll_free_number }}</span>
				@endif
			</div>
			<div class="contact-info-field fax-number">
				<span class="contact-info-icon ss-fax tooltip-hover"><span class="tooltip">Fax<br />Number</span></span>
				@if(empty($account->fax))
				<span class="contact-info-text"><span class="add-something-form ss-plus">Add one</span></span>
				@else
				<span class="contact-info-text">{{ $account->fax }}</span>
				@endif
			</div>
		</div>

		<div class="post-account-billable-time">
			<div><span>Available Billable Time</span>{{ $account->billable_time }} hours</div>
			<div><span>Billable Time Expire Date</span>{{ $account->billable_expire }}</div>
			<div><span>Billable Time Renew Date</span>{{ $account->billable_renew }}</div>
		</div>
		
		<div class="post-account-extras">
			<div><span>Site Designed by IOS</span>{{ $account->site_designed }}</div>
			<div><span>Site Launch Date</span>{{ $account->site_launch_date }}</div>
			<div><span>Hosting Started Date</span>{{ $account->hosting_started }}</div>
			<div><span>Hosting Ended Date</span>{{ $account->hosting_ended }}</div>
			<div><span>Hosting Type</span>{{ $account->hosting_type }}</div>
			<div><span>Hosting Addons</span>{{ $account->hosting_addons }}</div>
		</div>

		<div class="accounts-account-sub office-post-sub">
			<small>Posted by {{ User::find($account->author_id)->first_name.' '.User::find($account->author_id)->last_name }}</small>
			<small>on {{ $account->created_at->format('F') }}</small>
			<small>{{ $account->created_at->format('j, Y') }}</small>
			@if(Auth::user()->id == $account->author_id || Auth::user()->userrole == 'admin')
			<small><a class="edit-account edit-link link" href="/accounts/account/{{ $account->slug }}/edit">Edit</a></small>
			@endif
			@if($account->created_at != $account->updated_at)
			<small class="right">
			Last edit: {{ $account->updated_at->format('F j, Y h:i:s A') }} by {{ User::find($account->edit_id)->first_name.' '.User::find($account->edit_id)->last_name }}
			</small>
			@endif
		</div>
	</div>

	<div id="accounts-account-comment-form" class="create-something-new">
		<div class="accounts-button">
			<span formtype="post-reply" formlocation="/accounts/account/{{ $account->slug }}/comment" class="post-comment add-button">
			<span class="ss-reply"></span> Reply</span>
		</div>
	</div>
	<h3 class="comment-on">Comments on <i>{{ $account->name }}</i>:</h3>
	
	<div id="comments"></div>

</div>
@stop