@extends('layout.main')

@section('page-h1')
{{ 'Vault' }}
@stop

@section('page-h2')
{{ $vaultAsset->title }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		@include('assets.partials.assets-menu')
	</ul>
</div>
@stop

@section('page-content')
<div id="assets-page"  class="inner-page">
<a href="/assets/vault/" class="ss-reply back-to-vault-home">Back to Vault Home</a>
<h2>@yield('page-h2')</h2>

<div id="vault-{{ $vaultAsset->id }}" class="vault-asset office-post-single" slug="{{ $vaultAsset->slug }}">
	
{{ Form::open( array('id' => 'add-tag-'.$vaultAsset->id, 'class' => 'add-new-tag', 'url' => '/tags/newtag/'.$vaultAsset->id, 'method' => 'post') ) }}
<div class="post-tags post-tooltip">

<div class="tags-added-ajax tags-existing-ajax" formtypeid="{{ $vaultAsset->id }}" formtype="add-tag-type" formlocation="/assets/vault/singleviewupdate/{{ $vaultAsset->id }}/tag_id">{{ $vaultAsset->displayTags($vaultAsset->id, 'vault') }}</div>
<span class="tag-addnew tooltip-hover ss-plus add-button"><span class="tooltip">Add New<br />Tag</span></span>
{{ Form::text('tag_name', null, array('placeholder' => 'Add tags one at a time.', 'class' => 'none addnew-tag search-tags')) }}
{{ Form::hidden('tag_id', null, array('class' => 'vault-asset-tag-id')) }}
<div class="tags-search-ajax"></div>

</div>
{{ Form::close() }}

<div class="new-form-field">
@if($vaultAsset->type == 'ftp' || $vaultAsset->type == 'database'  || $vaultAsset->type == 'server')
<label>Server:</label>
@else
<label>URL:</label>
@endif
<input class="show-me-input vault-url" value="{{ $vaultAsset->url }}" />
</div>

<div class="new-form-field">
<label>Username:</label>
<input class="show-me-input vault-username" value="{{ $vaultAsset->username }}" />
</div>

<div class="new-form-field">
<label>Password:</label>
<input class="show-me-input vault-password" value="************" />
<span value="password" class="ss-view show-me tooltip-hover"><span class="tooltip">Show<br />Password</span></span>
</div>

@if(!empty($vaultAsset->database_name))
<div class="new-form-field">
<label>Database Name:</label>
<input class="show-me-input vault-database-name" value="{{ $vaultAsset->database_name }}" />
</div>
@endif

@if(!empty($vaultAsset->ftp_path))
<div class="new-form-field">
<label>FTP Path:</label>
<input class="show-me-input vault-ftp-path" value="{{ $vaultAsset->ftp_path }}" />
</div>
@endif

@if(!empty($vaultAsset->notes))
<div class="new-form-field">
<label>Notes:</label>
<span class="office-notice vault-note">{{ $vaultAsset->notes }}</span>
</div>
@endif
@if(!empty($vaultAsset->attachment))
<span>{{ $vaultAsset->getAttachments($vaultAsset->id) }}</span>
@endif
	<div class="vault-asset-sub office-post-sub">
		<small>Created by {{ User::find($vaultAsset->author_id)->first_name.' '.User::find($vaultAsset->author_id)->last_name }}</small>
		<small>on {{ $vaultAsset->created_at->format('F j, Y') }}</small>
		
		@if(Auth::user()->id == $vaultAsset->author_id || Auth::user()->can_manage == 'yes')
		<small><a class="edit-vault-asset edit-link link" href="/assets/vault/asset/{{ $vaultAsset->slug }}/edit">Edit</a></small>
		@endif
		<small class="right">
		Last edit: {{ $vaultAsset->updated_at->format('F j, Y h:i:s A') }} by {{ User::find($vaultAsset->edit_id)->first_name.' '.User::find($vaultAsset->edit_id)->last_name }}
		</small>
	</div>
	</div>
</div>
@stop