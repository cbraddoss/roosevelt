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

	<h3>Current Templates:</h3>

	@foreach($templates as $template)
		<div id="template-{{ $template->id }}" class="template-item office-post">
			<div class="post-date"><p>{{ ucwords($template->type) }}</p></div>
			<h3>{{ link_to('/admin/templates/'. $template->slug.'/edit/', $template->name, array('class' => 'template-link')) }}</h3>
			<div class="office-post-sub">
				<small>Created: {{ $template->created_at->format('M d, Y') }}</small>
			</div>
			<div class="office-post-sub">
				<small>Last Update: {{ $template->updated_at->format('M d, Y') }}</small>
			</div>
		</div>
	@endforeach
@stop