@extends('admin.templates')

@section('admin-template-content')
	
	<div class="office-notice">
		<h4>Notice:</h4>
		<span>Changing a template checklist is not currently supported.</span><br />
		<span>If a checklist needs updated or edited, please mark the template as 'Inactive' first, modify the name (add -old or something), then create a new template with the original name and new checklist items.</span>
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
		</div>
		<hr class="global-hrule" />
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
		</div>
		<hr class="global-hrule" />
	@endforeach
@stop