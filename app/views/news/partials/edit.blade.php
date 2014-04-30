@extends('layout.main')

@section('page-title')
{{ $article->title }}
@stop


@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')

{{ Form::open( array('id' => 'update-article', 'class' => 'update-article', 'url' => '/news/article/'.$article->slug, 'method' => 'post') ) }}

{{ Form::hidden('id', $article->id) }}

<div class="user-field">
	<span class="article-value title-value">{{ Form::text('title', $article->title, array('class' => 'article-title field')) }}</span>
</div>

<div class="form-textarea-buttons">
	<!-- <span class="ss-link textarea-button make-link"></span>
	<span class="textarea-button make-bold">Bold</span>
	<span class="textarea-button make-italic">Italic</span>
	<span class="textarea-button-divider"></span> -->
	<span class="textarea-button-text">Ping a user:</span>
	{{ display_pingable() }}
</div>

<div class="user-field">
	<span class="article-value content-value">{{ Form::textarea('content', $article->content, array('class' => 'article-content field', 'id' => 'article-content')) }}</span>
</div>
<div class="user-field">
	<span class="article-value show-on-calendar-value">{{ Form::text('show_on_calendar', null, array('placeholder' => 'Post to Calendar', 'class' => 'datepicker article-calendar-date field', 'data-date-format' => 'mm/dd/yyyy', 'data-date-viewmode' => 'days')) }}</span>
</div>
<div class="user-field">
	<span class="article-value attachment-value">{{ Form::file('attachment') }}</span>
</div>
<div class="user-field">
	<span class="article-value status-value">{{ Form::select('status', array('published' => 'Publish', 'sticky' => 'Publish as Sticky', 'draft' => 'Save as Draft') , $article->status) }}</span>
</div>

{{ Form::submit('Save Article', array('class' => 'save', 'id' => 'update-article-submit') ) }}

<a href="/news/article/{{ $article->slug }}" class="button cancel">Cancel</a>

{{ Form::close() }}

@if(Auth::user()->userrole == 'admin' || Auth::user()->id == $article->author_id)
{{ Form::open( array('class' => 'delete-article', 'url' => '/news/article/'.$article->id, 'method' => 'delete', 'id' => $article->id) ) }}

{{ Form::hidden('id', $article->id) }}

<div class="user-field">
{{ Form::submit('Delete Article', array('class' => 'delete') ) }}
</div>
{{ Form::close() }}
@endif

@stop