<span class="create-something-title">Add New</span>
<div class="article-add-form create-something-form">

{{ Form::open( array('id' => 'add-new', 'class' => 'add-article', 'url' => '/news/', 'method' => 'post') ) }}

{{ Form::text('title', null, array('placeholder' => 'Title', 'class' => 'article-title field')) }}

{{ Form::textarea('content', null, array('placeholder' => 'What\'s happening?', 'class' => 'article-content field')) }}

{{ Form::file('attachment') }}

{{ Form::submit('Add Article', array('class' => 'save', 'id' => 'add-new-submit') ) }}

<span id="add-new" class="cancel">Cancel</span>

{{ Form::close() }}

</div>