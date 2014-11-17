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
			<div class="edit-account-contact-info" accountvalue="{{ $account->id }}"><small class="right ss-settings tooltip-hover"><span class="tooltip">Edit<br />Contact Info</span></small></div>
			<div class="contact-info-map">
				{{ $mapMap }}
			</div>
			<h3 class="ss-signpost">Contact Info:</h3>
			<div class="contact-info-fields">
				<div class="contact-info-field email-address">
					<span class="contact-info-icon ss-mail tooltip-hover"><span class="tooltip">Email<br />Address</span></span>
					<span class="contact-info-text" accountdetail="email" accountvalue="{{ $account->email }}"><a href="mailto:{{ $account->email }}">{{ $account->email }}</a></span>
				</div>
				<div class="contact-info-field website-address">
					<span class="contact-info-icon ss-globe tooltip-hover"><span class="tooltip">Website<br />Address</span></span>
					<span class="contact-info-text" accountdetail="website" accountvalue="{{ $account->website }}"><a href="http://{{ $account->website }}">{{ $account->website }}</a></span>
				</div>
				<div class="contact-info-field physical-address">
					<span class="contact-info-icon ss-location tooltip-hover"><span class="tooltip">Physical<br />Address</span></span>
					<div class="contact-info-multi-text">
						<span class="contact-info-text" accountdetail="street" accountvalue="{{ $account->address }}">{{ $account->address }}</span><br />
						<span class="contact-info-text" accountdetail="city" accountvalue="{{ $account->city }}">{{ $account->city }}</span>,
						<span class="contact-info-text" accountdetail="state" accountvalue="{{ $account->state }}">{{ $account->state }}</span><br />
						<span class="contact-info-text" accountdetail="zip" accountvalue="{{ $account->zip }}">{{ $account->zip }}</span>
					</div>
					
				</div>
				<div class="contact-info-field phone-number">
					<span class="contact-info-icon ss-phone tooltip-hover"><span class="tooltip">Phone<br />Number</span></span>
					@if(empty($account->phone_number))
					<span class="contact-info-text"><span accountdetail="phone_number" class="add-something-form ss-plus">Add number</span></span>
					@else
					<span class="contact-info-text" accountdetail="phone_number" accountvalue="{{ $account->phone_number }}">{{ $account->phone_number }}</span>
					@endif
				</div>
				<div class="contact-info-field toll-free-number">
					<span class="contact-info-icon ss-phone tooltip-hover"><span class="tooltip">800<br />Number</span></span>
					@if(empty($account->toll_free_number))
					<span class="contact-info-text"><span accountdetail="toll_free_number" class="add-something-form ss-plus">Add number</span></span>
					@else
					<span class="contact-info-text" accountdetail="toll_free_number" accountvalue="{{ $account->toll_free_number }}">{{ $account->toll_free_number }}</span>
					@endif
				</div>
				<div class="contact-info-field fax-number">
					<span class="contact-info-icon ss-fax tooltip-hover"><span class="tooltip">Fax<br />Number</span></span>
					@if(empty($account->fax))
					<span class="contact-info-text"><span accountdetail="fax" class="add-something-form ss-plus">Add number</span></span>
					@else
					<span class="contact-info-text" accountdetail="fax" accountvalue="{{ $account->fax }}">{{ $account->fax }}</span>
					@endif
				</div>
			</div>
		</div>

		<div class="post-account-billable-time">
			<h3 class="ss-clock">Billable Time:</h3>
			<div class="account-billable-time-available">
				<span class="account-billable-time-available-label account-billable-time-label">Available:</span>
				<span class="account-billable-time-available-text">{{ $account->billable_time }} hours</span>
			</div>
			<div class="account-billable-time-expire">
				<span class="account-billable-time-expire-label account-billable-time-label">Expire Date:</span>
				<span class="account-billable-time-expire-text">{{ $account->billable_expire }}</span>
			</div>
			<div class="account-billable-time-renew">
				<span class="account-billable-time-renew-label account-billable-time-label">Renew Date:</span>
				<span class="account-billable-time-renew-text">{{ $account->billable_renew }}</span>
			</div>
		</div>
		
		<div class="post-account-extras">
			<div class="account-extras">
				<span class="account-extras-label">Site Designed by IOS?</span>
				<span class="account-extras-text">{{ $account->site_designed }}</span>
			</div>
			<div class="account-extras">
				<span class="account-extras-label">Site Launch Date:</span>
				<span class="account-extras-text">{{ $account->site_launch_date }}</span>
			</div>
			<div class="account-extras">
				<span class="account-extras-label">Hosting Started Date:</span>
				<span class="account-extras-text">{{ $account->hosting_started }}</span>
			</div>
			<div class="account-extras">
				<span class="account-extras-label">Hosting Ended Date:</span>
				<span class="account-extras-text">{{ $account->hosting_ended }}</span>
			</div>
			<div class="account-extras">
				<span class="account-extras-label">Hosting Type:</span>
				<span class="account-extras-text">{{ $account->hosting_type }}</span>
			</div>
			<div class="account-extras">
				<span class="account-extras-label">Hosting Addons:</span>
				<span class="account-extras-text">{{ $account->hosting_addons }}</span>
			</div>
		</div>

		<div class="post-account-relationships">
			<h3 class="ss-list">Projects</h3>
			<div class="account-relationship account-projects">
				<ul>
					@if($projects->isEmpty())
					<li>No projects found for {{$account->name}}</li>
					@else
					@foreach($projects as $project)
					<li><a class="account-project-link" href="/projects/post/{{ $project->slug }}">{{ $project->title }}</a></li>
					@endforeach
					@endif
				</ul>
			</div>
		</div>
		<div class="post-account-relationships">
			<h3 class="ss-dollarsign">Billables</h3>
			<div class="account-relationship account-billables">
				<ul>
					@if(empty($billables))
					<li>No billables found for {{$account->name}}</li>
					@else
					@foreach($billables as $billable)
					<li><a class="account-billable-link" href="/billables/post/{{ $billable->slug }}">{{ $billable->title }}</a></li>
					@endforeach
					@endif
				</ul>
			</div>
		</div>
		<div class="post-account-relationships">
			<h3 class="ss-file">Invoices</h3>
			<div class="account-relationship account-invoices">
				<ul>
					@if(empty($invoices))
					<li>No invoices found for {{$account->name}}</li>
					@else
					@foreach($invoices as $invoice)
					<li><a class="account-invoice-link" href="/invoices/post/{{ $invoice->slug }}">{{ $invoice->title }}</a></li>
					@endforeach
					@endif
				</ul>
			</div>
		</div>
		<div class="post-account-relationships">
			<h3 class="ss-help">Help</h3>
			<div class="account-relationship account-help">
				<ul>
					@if(empty($helps))
					<li>No help posts found for {{$account->name}}</li>
					@else
					@foreach($helps as $help)
					<li><a class="account-help-link" href="/help/post/{{ $help->slug }}">{{ $help->title }}</a></li>
					@endforeach
					@endif
				</ul>
			</div>
		</div>
		<div class="post-account-relationships">
			<h3 class="ss-key">Vault Assets</h3>
			<div class="account-relationship account-vault-asset">
				<ul>
					@if($vaults->isEmpty())
					<li>No vault assets found for {{$account->name}}</li>
					@else
					@foreach($vaults as $vault)
					<li><a class="account-vault-asset-link" href="/assets/vault/asset/{{ $vault->slug }}">{{ $vault->title }}</a></li>
					@endforeach
					@endif
				</ul>
			</div>
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