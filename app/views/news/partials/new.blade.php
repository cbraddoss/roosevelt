<span class="create-something-title">New Post</span>
<div class="page-cover">
</div>
<div class="article-add-form create-something-form">

{{ Form::open( array('id' => 'add-new', 'files' => true, 'class' => 'add-article', 'url' => '/news/', 'method' => 'post') ) }}

{{ Form::text('title', null, array('placeholder' => 'Title', 'class' => 'article-title field')) }}

<div class="form-textarea-buttons">
	<!-- <span class="ss-link textarea-button make-link"></span>
	<span class="textarea-button make-bold">Bold</span>
	<span class="textarea-button make-italic">Italic</span>
	<span class="textarea-button-divider"></span> -->
	<span class="textarea-button-text">Ping a user:</span>
	{{ display_pingable() }}
</div>

{{ Form::textarea('content', null, array('placeholder' => 'What\'s happening?', 'class' => 'article-content field', 'id' => 'article-content')) }}

{{ Form::text('show_on_calendar', null, array('placeholder' => 'Post to Calendar', 'class' => 'datepicker article-calendar-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}

{{ Form::file('attachment[]',array('multiple', 'class'=>'new-article-attachment')) }}

{{ Form::select('status', array('published' => 'Publish', 'sticky' => 'Publish as Sticky', 'draft' => 'Save as Draft') , 'published') }}

{{ Form::submit('Publish', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>