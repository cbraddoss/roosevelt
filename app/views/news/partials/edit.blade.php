@extends('layout.main')

@section('page-title')
{{ $article->title }}
@stop


@section('page-content')
<div id="news-page"  class="inner-page">

@include('news.partials.sub-menu')

{{ Form::open( array('id' => 'update-article', 'class' => 'update-article', 'url' => '/news/article/'.convert_link_to_title($article->title), 'method' => 'post') ) }}

{{ Form::hidden('id', $article->id) }}

<div class="user-field">
	<span class="article-value title-value">{{ Form::text('title', $article->title, array('class' => 'article-title field')) }}</span>
</div>

<div class="user-field">
	<span class="article-value title-value">{{ Form::textarea('content', $article->content, array('class' => 'article-content field', 'id' => 'article-content')) }}</span>
</div>


<div class="user-field">
	<span class="article-title attachment">{{ Form::label('attachment', 'Attachment:' ) }}</span>
	<span class="article-value title-value">{{ Form::file('attachment') }}</span>
</div>

{{ Form::submit('Save Article', array('class' => 'save', 'id' => 'update-article-submit') ) }}

<a href="/news/article/{{ $article->link }}" class="button cancel">Cancel</a>

{{ Form::close() }}
@stop