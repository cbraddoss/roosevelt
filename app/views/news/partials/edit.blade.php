@extends('layout.main')

@section('page-h1')
{{ 'Company News' }}
@stop

@section('page-h2')
{{ 'Edit ' . $article->title }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<a class="">Last Edit: {{ $article->updated_at->format('F j, Y h:i:s A') }} by {{ User::find($article->edit_id)->first_name.' '.User::find($article->edit_id)->last_name }}</a>
		</li>
	</ul>
</div>
@stop

@section('page-content')
<div id="news-page"  class="inner-page edit-page">
<h2>@yield('page-h2')</h2>

<div class="update-something-form">
{{ Form::open( array('id' => $article->id, 'files' => true, 'class' => 'update-article', 'url' => '/news/article/'.$article->slug, 'method' => 'post') ) }}

{{ Form::hidden('id', $article->id) }}

<div class="new-form-field">
{{ Form::label('title', 'Title:') }}
{{ Form::text('title', $article->title, array('class' => 'article-title field')) }}
</div>

<div class="new-form-field">
<div class="form-textarea-buttons form-action-buttons">
{{ Form::label('content', 'Ping a user:') }}
{{ display_pingable() }}
<!-- <span class="ss-link textarea-button make-link"></span>
<span class="textarea-button make-bold">Bold</span>
<span class="textarea-button make-italic">Italic</span>
<span class="textarea-button-divider"></span> -->
</div>
</div>

<div class="new-form-field">
{{ Form::label('content', 'Content:') }}
{{ Form::textarea('content', $article->content, array('class' => 'article-content field', 'id' => 'article-content')) }}
</div>

<div class="new-form-field">
{{ Form::label('show_on_calendar', 'Show on Calendar:') }}
@if($article->show_on_calendar != '0000-00-00 00:00:00')
{{ Form::text('show_on_calendar', Carbon::createFromFormat('Y-m-d H:i:s', $article->show_on_calendar)->format('m/d/Y'), array('placeholder' => 'Post to Calendar', 'class' => 'datepicker article-calendar-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
@else
{{ Form::text('show_on_calendar', null, array('placeholder' => 'Post to Calendar', 'class' => 'datepicker article-calendar-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}
@endif
</div>

<div class="new-form-field">
{{ Form::label('attachment[]', 'Attach file(s):') }}
{{ Form::file('attachment[]',array('multiple')) }}
</div>

<div class="new-form-field">
{{ Form::label('status', 'Article Status:') }}
<span class="select-dropdown">
<span class="ss-dropdown"></span>
<span class="ss-directup"></span>
{{ Form::select('status', array('published' => 'Publish', 'sticky' => 'Publish as Sticky', 'draft' => 'Save as Draft') , $article->status) }}
</span>
</div>

{{ Form::submit('Save Article', array('class' => 'save form-button', 'id' => 'update-article-submit') ) }}

<a href="/news/article/{{ $article->slug }}" class="form-button cancel">Cancel</a>

{{ Form::close() }}

@if(!empty($article->attachment))
<div class="new-form-field edit-attachments">
<p>Current Attachment(s):</p>
{{ $article->getAttachments($article->id,'post-edit-attachment') }}
</div>
@endif

@if(Auth::user()->userrole == 'admin' || Auth::user()->id == $article->author_id)
{{ Form::open( array('class' => 'delete-article delete-post', 'url' => '/news/article/'.$article->id, 'method' => 'delete', 'id' => $article->id) ) }}

{{ Form::hidden('id', $article->id) }}

{{ Form::submit('Delete Article', array('class' => 'delete form-button') ) }}

{{ Form::close() }}
@endif
</div>
</div>

@stop