<div class="update-something-form">
{{ Form::open( array('id' => 'edit-account-contact-info-'.$account->id, 'class' => 'update-something edit-account-contact-info', 'url' => '/accounts/singleviewupdate/'. $account->id.'/contact-info', 'method' => 'post') ) }}

{{ Form::hidden('account-slug',$account->slug) }}

<div class="new-form-field">
{{ Form::label('email', 'Email:') }}
{{ Form::email('email', $account->email, array('class' => 'update-account-email field', 'id' => 'update-account-email')) }}
</div>

<div class="new-form-field">
{{ Form::label('website', 'Website:') }}
{{ Form::text('website', $account->website, array('class' => 'update-account-website field', 'id' => 'update-account-website')) }}
</div>

<div class="new-form-field">
{{ Form::label('street', 'Street:') }}
{{ Form::text('street', $account->address, array('class' => 'update-account-street field', 'id' => 'update-account-street')) }}
</div>

<div class="new-form-field">
{{ Form::label('city', 'City:') }}
{{ Form::text('city', $account->city, array('class' => 'update-account-city field', 'id' => 'update-account-city')) }}
</div>

<div class="new-form-field">
{{ Form::label('state', 'State:') }}
{{ Form::text('state', $account->state, array('class' => 'update-account-state field', 'id' => 'update-account-state')) }}
</div>

<div class="new-form-field">
{{ Form::label('zip', 'Zip:') }}
{{ Form::text('zip', $account->zip, array('class' => 'update-account-zip field', 'id' => 'update-account-zip')) }}
</div>

<div class="new-form-field">
{{ Form::label('phone_number', 'Phone Number:') }}
{{ Form::text('phone_number', $account->phone_number, array('class' => 'update-account-phone-number field', 'id' => 'update-account-phone-number')) }}
</div>

<div class="new-form-field">
{{ Form::label('toll_free_number', 'Toll Free:') }}
{{ Form::text('toll_free_number', $account->toll_free_number, array('class' => 'update-account-toll-free-number field', 'id' => 'update-account-toll-free-number')) }}
</div>

<div class="new-form-field">
{{ Form::label('fax', 'Fax:') }}
{{ Form::text('fax', $account->fax, array('class' => 'update-account-fax field', 'id' => 'update-account-fax')) }}
</div>

{{ Form::submit('Update', array('class' => 'save form-button', 'id' => 'update-account-contact-info') ) }}
<span class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>