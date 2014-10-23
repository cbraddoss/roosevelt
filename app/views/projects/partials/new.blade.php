<div class="project-add-form create-something-form">
<h2>New Project:</h2>
{{ Form::open( array('id' => 'add-new', 'files' => true, 'class' => 'add-project', 'url' => '/projects/', 'method' => 'post') ) }}

<div class="new-form-field">
{{ Form::label('title', 'Title:') }}
{{ Form::text('title', null, array('placeholder' => 'Title project using: Account Name - Project Type (e.g. Sample Inn - New Website)', 'class' => 'project-title field')) }}
</div>

<div class="new-form-field">
{{ Form::label('content', 'Project Scope:') }}
{{ Form::textarea('content', null, array('placeholder' => 'Define project scope (e.g. New website for Sample Inn using attached contract).', 'class' => 'project-content field', 'id' => 'project-content')) }}
</div>

<div class="new-form-field new-form-field-extras">
	<div class="form-subscribe-buttons form-action-buttons">
{{ Form::label('subscribe', 'Subscribe Users:') }}
{{ display_subscribable(Auth::user()->user_path) }}
	</div>
{{ Form::hidden('subscribed', Auth::user()->user_path.' ', array('class' => 'project-subscribed field', 'id' => 'project-subscribed')) }}
</div>

<div class="new-form-field new-form-field-extras">
	<div class="form-account-searchbox">
{{ Form::label('account_name', 'Add Account:') }}
{{ Form::text('account_name', null, array('placeholder' => 'Search Accounts...', 'class' => 'search-accounts field')) }}
{{ Form::hidden('account_id', null, array('class' => 'project-account-id field')) }}
		<div class="accounts-search-ajax"></div>
	</div>
</div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('template_id', 'Project Template:') }}
<div class="select-dropdown">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
	<select name="template_id">
		<option value="">Select Template</option>
{{ $templates }}
	</select>
</div>
{{ Form::hidden('template_name', null, array('class' => 'project-template-name field', 'id' => 'project-template-name')) }}
</div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('period', 'Is this project recurring?') }}
<div class="select-dropdown">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
{{ Form::select('period', array('ending' => 'No', 'recurring' => 'Yes') , 'ending') }}
</div>
</div>

<div class="new-form-field new-form-field-extras">
<!-- <span class="label-launch-date">Launch Date:</span> -->
{{ Form::label('launch_date', 'Launch Date:') }}
{{ Form::text('launch_date', null, array('placeholder' => 'Launch Date', 'class' => 'datepicker project-launch-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
</div>

<div class="new-form-field new-form-field-extras">
<!-- <span class="label-start-date">Start Date:</span> -->
{{ Form::label('start_date', 'Start Date:') }}
{{ Form::text('start_date', Carbon::now()->format('m/d/Y'), array('placeholder' => 'Start Date', 'class' => 'datepicker project-start-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
</div>

<div class="new-form-field new-form-field-extras">
<!-- <span class="label-end-date">End Date:</span> -->
{{ Form::label('recur_cycle', 'Recur Cycle:') }}
<div class="select-dropdown project-recur-cycle">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
	<select id="recur_cycle" name="recur_cycle">
		<option value=''>Select Cycle</option>
		<option value="monthly">Monthly</option>
		<option value="biweekly">Bi-Weekly</option>
		<option value="weekly">Weekly</option>
		<option value="daily">Daily</option>
	</select>
</div>
{{ Form::hidden('end_date', null, array('placeholder' => 'End Date', 'class' => 'datepicker project-end-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
</div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('priority', 'Priority:') }}
<div class="select-dropdown">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
{{ Form::select('priority', array('high' => 'High', 'normal' => 'Normal', 'low' => 'Low') , 'normal') }}
</div>
</div>

<div class="new-form-field new-form-field-extras">
{{ Form::label('attachment', 'Attach File(s):') }}
{{ Form::file('attachment[]',array('multiple', 'class'=>'projects-post-attachment')) }}
</div>

{{ Form::submit('Create Project', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>