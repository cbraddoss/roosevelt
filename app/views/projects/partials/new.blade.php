<span class="create-something-title">New Post</span>
<div class="page-cover">
</div>
<div class="project-add-form create-something-form">
<h3>Create new Project:</h3>
{{ Form::open( array('id' => 'add-new', 'files' => true, 'class' => 'add-project', 'url' => '/projects/', 'method' => 'post') ) }}

{{ Form::text('title', null, array('placeholder' => 'Title project using: Account Name - Project Type (e.g. Sample Inn - New Website)', 'class' => 'project-title field')) }}

{{ Form::textarea('content', null, array('placeholder' => 'Define project scope (e.g. New website for Sample Inn using attached contract).', 'class' => 'project-content field', 'id' => 'project-content')) }}

<div class="form-subscribe-buttons">
	<span class="subscribe-button-text">Subscribe users:</span>
	{{ display_subscribable(Auth::user()->user_path) }}
</div>
{{ Form::hidden('subscribed', Auth::user()->user_path.' ', array('class' => 'project-subscribed field', 'id' => 'project-subscribed')) }}

<select name="department">
	<option value="">Select Department</option>
	<option value="design">Design</option>
	<option value="sem">S.E.M.</option>
	<option value="print">Print</option>
	<option value="development">Development</option>
</select>

<select name="type">
	<option value="">Select Template</option>
	{{ get_template_list_select() }}
</select>

<select name="account_id">
	<option value="">Select Account</option>
	{{ get_active_account_list() }}
</select>

{{ Form::label('priority', 'Priority:') }}
{{ Form::select('priority', array('high' => 'High', 'normal' => 'Normal', 'low' => 'Low') , 'normal') }}

{{ Form::label('period', 'Is this project recurring?') }}
{{ Form::select('period', array('ending' => 'No', 'recurring' => 'Yes') , 'ending') }}

<span class="label-launch-date">Launch Date:</span>
{{ Form::text('end_date', null, array('placeholder' => 'Launch Date', 'class' => 'datepicker project-launch-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}

<span class="label-start-date">Start Date:</span>
{{ Form::text('start_date', Carbon::now()->format('m/d/Y'), array('placeholder' => 'Start Date', 'class' => 'datepicker project-start-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}

<span class="label-end-date">End Date:</span>
{{ Form::text('end_date', null, array('placeholder' => 'End Date', 'class' => 'datepicker project-end-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}

{{ Form::file('attachment[]',array('multiple', 'class'=>'projects-post-attachment')) }}

{{ Form::submit('Create', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>