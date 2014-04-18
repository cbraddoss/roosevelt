<span class="create-something-title">Add New</span>
<div class="article-add-form create-something-form">

{{ Form::open( array('id' => 'add-new', 'class' => 'add-article', 'url' => '/news/', 'method' => 'post') ) }}

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

{{ Form::label('attachment', 'Attachment:' ) }}
{{ Form::file('attachment') }}

{{ Form::submit('Add Article', array('class' => 'save', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel">Cancel</span>

{{ Form::close() }}

</div>