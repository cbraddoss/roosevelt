<div class="vault-add-form create-something-form">
<h2>New Vault Asset:</h2>
{{ Form::open( array('id' => 'add-new', 'files' => true, 'class' => 'add-vault-asset', 'url' => '/assets/vault/', 'method' => 'post') ) }}

<div class="new-form-field">
{{ Form::label('title', 'Title:') }}
{{ Form::text('title', null, array('placeholder' => 'Title', 'class' => 'vault-title field')) }}
</div>

<div class="new-form-field new-form-field-extras">
<div class="form-account-searchbox">
{{ Form::label('account_name', 'Add Account:') }}
{{ Form::text('account_name', null, array('placeholder' => 'Search Accounts...', 'class' => 'search-accounts field')) }}
{{ Form::hidden('account_id', null, array('class' => 'vault-asset-account-id field')) }}
<div class="accounts-search-ajax"></div>
</div>
</div>

<div class="new-form-field">
<div class="form-tags-searchbox">
{{ Form::label('tag_name', 'Add Tags:') }}
{{ Form::text('tag_name', null, array('placeholder' => 'Add tags one at a time.', 'class' => 'search-tags vault-tags field')) }}
{{ Form::hidden('tag_id', null, array('class' => 'vault-asset-tag-id field')) }}
<!-- <span class="ss-plus form-button"></span> -->
<div class="tags-search-ajax"></div>
<div class="tags-added-ajax"></div>
</div>
</div>

<div class="new-form-field">
{{ Form::label('type', 'Type:') }}
<div class="select-dropdown">
<span class="ss-dropdown"></span>
<span class="ss-directup"></span>
{{ Form::select('type', array('website' => 'Website','ftp' => 'FTP','database' => 'Database','email' => 'Email','server' => 'Server','generic' => 'Generic') , 'website') }}
</div>
</div>

<div class="new-form-field">
{{ Form::label('url', 'URL:') }}
{{ Form::text('url', null, array('placeholder' => 'URL', 'class' => 'vault-url field vault-field')) }}
</div>

<div class="new-form-field">
{{ Form::label('username', 'Username:') }}
{{ Form::text('username', null, array('placeholder' => 'Username', 'class' => 'vault-username field vault-field')) }}
</div>

<div class="new-form-field">
{{ Form::label('password', 'Password:') }}
{{ Form::text('password', null, array('placeholder' => 'Password', 'class' => 'vault-password field vault-field')) }}
</div>

<div class="new-form-field">
{{ Form::label('database_name', 'Database:') }}
{{ Form::text('database_name', null, array('placeholder' => 'Database Name', 'class' => 'vault-database-name field vault-field vault-hidden')) }}
</div>

<div class="new-form-field">
{{ Form::label('ftp_path', 'FTP Path:') }}
{{ Form::text('ftp_path', null, array('placeholder' => 'FTP Path (if needed)', 'class' => 'vault-ftp-path field vault-field vault-hidden')) }}
</div>

<div class="new-form-field">
{{ Form::label('notes', 'Notes:') }}
{{ Form::textarea('notes', null, array('placeholder' => 'Add additional notes here.', 'class' => 'vault-notes field vault-field')) }}
</div>

<div class="new-form-field">
{{ Form::label('attachment[]', 'Attach File(s):') }}
{{ Form::file('attachment[]', array('multiple', 'class' => 'new-vault-attachment vault-field')) }}
</div>

{{ Form::submit('Add', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>