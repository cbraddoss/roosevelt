<div class="article-add-form create-something-form">
<h2>News Post:</h2>
{{ Form::open( array('id' => 'add-new', 'files' => true, 'class' => 'add-article', 'url' => '/news/', 'method' => 'post') ) }}

<div class="new-form-field">
{{ Form::label('title', 'Title:') }}
{{ Form::text('title', null, array('placeholder' => 'Title', 'class' => 'article-title field')) }}
</div>

<div class="new-form-field">
	<div class="form-textarea-buttons form-action-buttons">
{{ display_pingable() }}
<!-- <span class="ss-link textarea-button make-link"></span>
<span class="textarea-button make-bold">Bold</span>
<span class="textarea-button make-italic">Italic</span>
<span class="textarea-button-divider"></span> -->
	</div>
</div>

<div class="new-form-field">
{{ Form::label('content', 'Article Contents:') }}
{{ Form::textarea('content', null, array('placeholder' => 'What\'s happening?', 'class' => 'article-content field', 'id' => 'article-content')) }}
</div>

<div class="new-form-field">
<div class="form-tags-searchbox">
{{ Form::label('tag_name', 'Add Tags:') }}
{{ Form::text('tag_name', null, array('placeholder' => 'Add tags one at a time.', 'class' => 'search-tags vault-tags field')) }}
{{ Form::hidden('tag_id', null, array('class' => 'vault-asset-tag-id field')) }}
<div class="tags-search-ajax"></div>
<div class="tags-added-ajax"></div>
</div>
</div>

<div class="new-form-field">
{{ Form::label('show_on_calendar', 'Show on Calendar:') }}
{{ Form::text('show_on_calendar', null, array('placeholder' => 'Post to Calendar', 'class' => 'datepicker future-dates article-calendar-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
</div>

<div class="new-form-field">
{{ Form::label('attachment[]', 'Attach File(s):') }}
{{ Form::file('attachment[]',array('multiple', 'class'=>'new-article-attachment')) }}
</div>

<div class="new-form-field">
{{ Form::label('status', 'Article Status:') }}
<div class="select-dropdown">
	<span class="ss-dropdown"></span>
	<span class="ss-directup"></span>
	{{ Form::select('status', array('published' => 'Publish', 'sticky' => 'Publish as Sticky', 'draft' => 'Save as Draft') , 'published') }}
</div>
</div>

{{ Form::submit('Publish', array('class' => 'save form-button', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel form-button">Cancel</span>

{{ Form::close() }}

</div>