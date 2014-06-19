@extends('layout.main')

@section('page-title')
{{ 'Wiki' }}
@stop

@section('header-menu')
<div class="page-menu">
	<ul>
		<li>
			<div id="wiki-new-wiki-form" class="create-something-new">
				<span class="wiki-button"><button class="add-new ss-plus">Add New</button></span>
			</div>
		</li>
		<li></li>
	</ul>
</div>
@stop

@section('page-content')
<div id="wiki-page"  class="inner-page">
	
</div>
@stop