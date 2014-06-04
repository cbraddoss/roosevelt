@extends('admin.templates')

@section('admin-template-content')
<div class="template-key">
		<h3>Checklist codes:</h3>
		<p>[[START]] = start a section</p>
		<p>[[END]] = end a section</p>
		<p>[[h]] = Header</p>
		<p>[[o]] = Open checkbox</p>
		
		<h3>Example:</h3>
<pre class="php">
[[START]]
[[h]]Design
[[o]]do stuff
[[END]]
[[START]]
[[h]]Coding
[[o]]do stuff
[[END]]
[[START]]
[[h]]Pre-Launch
[[o]]do stuff
[[END]]
[[START]]
[[h]]Launch
[[o]]do stuff
[[END]]
</pre>
	</div>

	<h3>Active Templates:</h3>
	@if($templatesActive->isEmpty())
	<p>No templates. Add some!</p>
	@endif
	@foreach($templatesActive as $active)
		<div id="template-{{ $active->id }}" class="template-item office-post">
			<div class="post-date"><p>{{ ucwords($active->type) }}</p></div>
			<h3>{{ link_to('/admin/templates/'. $active->slug.'/edit/', $active->name, array('class' => 'template-link')) }}</h3>
			<div class="office-post-sub">
				<small>Created: {{ $active->created_at->format('M d, Y') }}</small>
			</div>
			<div id="{{ $active->id }}" class="post-preview">
				<p class="ss-view"></p>
			</div>
		</div>
		<div id="template-output-{{ $active->id }}" class="template-output">
			<div class="page-cover">
			</div>
			<div class="template-preview">
			<div class="close-template-preview">X Close</div>
				<h3>TEMPLATE: {{ $active->name }}</h3>
				<h4><a href="#">Sample Account</a></h4>
				{{ $active->convertCode($active->items) }}
			</div>
		</div>
	@endforeach

	<h3>Inactive Templates:</h3>
	@if($templatesActive->isEmpty())
	<p>No inactive templates.</p>
	@endif
	@foreach($templatesInactive as $inactive)
		<div id="template-{{ $inactive->id }}" class="template-item office-post">
			<div class="post-date"><p>{{ ucwords($inactive->type) }}</p></div>
			<h3>{{ link_to('/admin/templates/'. $inactive->slug.'/edit/', $inactive->name, array('class' => 'template-link')) }}</h3>
			<div class="office-post-sub">
				<small>Created: {{ $inactive->created_at->format('M d, Y') }}</small>
			</div>
			<div id="{{ $inactive->id }}" class="post-preview">
				<p class="ss-view"></p>
			</div>
		</div>
		<div id="template-output-{{ $inactive->id }}" class="template-output">
			<div class="page-cover">
			</div>
			<div class="template-preview">
			<div class="close-template-preview">X Close</div>
				<h3>TEMPLATE: {{ $inactive->name }}</h3>
				<h4><a href="#">Sample Account</a></h4>
				{{ $inactive->convertCode($inactive->items) }}
			</div>
		</div>
	@endforeach
@stop