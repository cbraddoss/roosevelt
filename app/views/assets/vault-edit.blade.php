@extends('layout.main')

@section('page-h1')
{{ 'Vault' }}
@stop

@section('page-h2')
{{ 'Edit: ' . $vaultAsset->title }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<a class="">Last Edit: {{ $vaultAsset->updated_at->format('F j, Y h:i:s A') }} by {{ User::find($vaultAsset->edit_id)->first_name.' '.User::find($vaultAsset->edit_id)->last_name }}</a>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="assets-page"  class="inner-page edit-page">
<h2>@yield('page-h2')</h2>

<div class="update-something-form">
{{ Form::open( array('id' => $vaultAsset->id, 'files' => true, 'class' => 'update-vault-asset', 'url' => '/assets/vault/asset/'.$vaultAsset->slug, 'method' => 'post') ) }}

{{ Form::hidden('id', $vaultAsset->id) }}

<div class="new-form-field">
{{ Form::label('title', 'Title:') }}
{{ Form::text('title', $vaultAsset->title, array('class' => 'vaultAsset-title field')) }}
</div>

<div class="new-form-field new-form-field-extras">
<div class="form-account-searchbox">
{{ Form::label('account_name', 'Change Account:') }}
{{ Form::text('account_name', Account::find($vaultAsset->account_id)->name, array('placeholder' => 'Search Accounts...', 'class' => 'search-accounts field')) }}
{{ Form::hidden('account_id', $vaultAsset->account_id, array('class' => 'vault-asset-account-id field')) }}
<div class="accounts-search-ajax"></div>
</div>
</div>

<div class="new-form-field">
@if($vaultAsset->type == 'ftp' || $vaultAsset->type == 'database'  || $vaultAsset->type == 'server')
{{ Form::label('url', 'Server:') }}
@else
{{ Form::label('url', 'URL:') }}
@endif
{{ Form::text('url', $vaultAsset->url, array('class' => 'vaultAsset-url field')) }}
</div>

<div class="new-form-field">
{{ Form::label('username', 'Username:') }}
{{ Form::text('username', $vaultAsset->username, array('class' => 'vaultAsset-username field')) }}
</div>

<div class="new-form-field">
{{ Form::label('password', 'Password:') }}
{{ Form::text('password', null, array('placeholder' => 'New Password', 'class' => 'vaultAsset-password field')) }}
</div>

@if($vaultAsset->type == 'database')
<div class="new-form-field">
{{ Form::label('database_name', 'Database Name:') }}
{{ Form::text('database_name', $vaultAsset->database_name, array('class' => 'vaultAsset-database_name field')) }}
</div>
@endif

@if($vaultAsset->type == 'ftp')
<div class="new-form-field">
{{ Form::label('ftp_path', 'FTP Path:') }}
{{ Form::text('ftp_path', $vaultAsset->ftp_path, array('placeholder' => 'Optional', 'class' => 'vaultAsset-ftp_path field')) }}
</div>
@endif

<div class="new-form-field">
{{ Form::label('notes', 'Notes:') }}
{{ Form::textarea('notes', $vaultAsset->notes, array('placeholder' => 'Add additional notes here.', 'class' => 'vaultAsset-notes field')) }}
</div>

<div class="new-form-field">
{{ Form::label('attachment[]', 'Attach file(s):') }}
{{ Form::file('attachment[]',array('multiple')) }}
</div>

{{ Form::submit('Save Vault Asset', array('class' => 'save form-button', 'id' => 'update-vault-asset-submit') ) }}

<a href="/assets/vault/asset/{{ $vaultAsset->slug }}" class="form-button cancel">Cancel</a>

{{ Form::close() }}


@if(!empty($vaultAsset->attachment))
<div class="new-form-field edit-attachments">
<p>Current Attachment(s):</p>
{{ $vaultAsset->getAttachments($vaultAsset->id,'post-edit-attachment edit-this-attachment') }}
</div>
@endif

@if(Auth::user()->userrole == 'admin' || Auth::user()->id == $vaultAsset->author_id)
{{ Form::open( array('class' => 'delete-vault-asset delete-post', 'url' => '/assets/vault/asset/'.$vaultAsset->id, 'method' => 'delete', 'id' => $vaultAsset->id) ) }}

{{ Form::hidden('id', $vaultAsset->id) }}

{{ Form::submit('Delete Vault Asset', array('class' => 'delete form-button') ) }}

{{ Form::close() }}
@endif

</div>
</div>
@stop