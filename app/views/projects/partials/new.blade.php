<span class="create-something-title">New Post</span>
<div class="page-cover">
</div>
<div class="project-add-form create-something-form">
<h3>Create new Project:</h3>
{{ Form::open( array('id' => 'add-new', 'files' => true, 'class' => 'add-project', 'url' => '/projects/', 'method' => 'post') ) }}

<div class=""><small>Title projects using: Account Name - Project Type (e.g. Sample Inn - New Website)</small></div>
{{ Form::text('title', null, array('placeholder' => 'Title', 'class' => 'project-title field')) }}

<div class="form-subscribe-buttons">
	<span class="subscribe-button-text">Subscribe a user to this project:</span>
	{{ display_subscribable() }}
</div>
{{ Form::hidden('subscribed', Auth::user()->user_path, array('class' => 'project-subscribed field', 'id' => 'project-subscribed')) }}

{{ Form::textarea('content', null, array('placeholder' => 'Define Project scope (e.g. New website for Sample Inn using attached contract).', 'class' => 'project-content field', 'id' => 'project-content')) }}

{{ Form::label('department', 'Department:') }}
{{ Form::select('department', array('design' => 'Design', 'sem' => 'S.E.M.', 'print' => 'Print', 'development' => 'Development') , 'design') }}

{{ Form::label('period', 'Is this project recurring?') }}
{{ Form::select('period', array('recurring' => 'Yes', 'ending' => 'No') , 'ending') }}

{{ Form::label('end_date', 'Launch Date:') }}
{{ Form::text('end_date', null, array('placeholder' => 'Launch Date', 'class' => 'datepicker project-launch-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}

{{ Form::label('start_date', 'Start Date:') }}
{{ Form::text('start_date', null, array('placeholder' => 'Start Date', 'class' => 'datepicker project-start-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}

{{ Form::label('end_date', 'End Date:') }}
{{ Form::text('end_date', null, array('placeholder' => 'End Date', 'class' => 'datepicker project-end-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}

{{ Form::label('type', 'Select Template:') }}
<select name="type">
{{ get_project_type_select() }}
</select>

{{ Form::label('account_id', 'Select Account:') }}
<select name="account_id">
{{ get_active_account_list() }}
</select>

{{ Form::file('attachment[]',array('multiple', 'class'=>'projects-post-attachment')) }}

{{ Form::label('priority', 'Priority:') }}
{{ Form::select('priority', array('high' => 'High', 'normal' => 'Normal', 'low' => 'Low') , 'normal') }}

{{ Form::submit('Create', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>