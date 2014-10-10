@extends('admin.templates')

@section('admin-template-content')
	
	<div class="office-notice">
		<h4>Notice:</h4>
		<span>Adding sections to a checklist is not currently supported.</span><br />
		<span>Only editing current section titles and current task content is supported.</span><br />
		<span>If new tasks need to be added (rather than changed), please mark the template as 'Inactive' first, modify the name (add -old or something), then create a new template with the original name and new checklist items.</span>
	</div>

	<h2>Active Templates:</h2>
	@if($templatesActive->isEmpty())
	<p>No templates. Add some!</p>
	@endif
	@foreach($templatesActive as $active)
		<div id="template-{{ $active->id }}" class="template-post template-active office-post">
			<div class="post-type post-meta post-tooltip">
				@if($active->type == 'project')
				<a class="ss-list tooltip-hover"><span class="tooltip">Project<br />Template</span></a>
				<span class="post-meta-desc">{{ ucwords($active->type) }}</span>
				@elseif($active->type == 'billable')
				<a class="ss-dollarsign tooltip-hover"><span class="tooltip">Billable<br />Template</span></a>
				<span class="post-meta-desc">{{ ucwords($active->type) }}</span>
				@elseif($active->type == 'invoice')
				<a class="ss-file tooltip-hover"><span class="tooltip">Invoice<br />Template</span></a>
				<span class="post-meta-desc">{{ ucwords($active->type) }}</span>
				@elseif($active->type == 'help')
				<a class="ss-help tooltip-hover"><span class="tooltip">Help<br />Template</span></a>
				<span class="post-meta-desc">{{ ucwords($active->type) }}</span>
				@else
				<span class="ss-ban tooltip-hover"><span class="tooltip">What is this?</span></span>
				<span class="post-meta-desc">{{ ucwords($active->type) }}</span>
				@endif
			</div>
			<h3>{{ link_to('/admin/templates/'. $active->slug.'/edit/', $active->name, array('class' => 'template-link')) }}</h3>
			<div class="post-date post-detail">
				<span><span class="post-date-text">Created:</span> {{ $active->created_at->format('M d, Y') }}</span>
			</div>
		</div>
	@endforeach

	<h2>Inactive Templates:</h2>
	@if($templatesActive->isEmpty())
	<p>No inactive templates.</p>
	@endif
	@foreach($templatesInactive as $inactive)
		<div id="template-{{ $inactive->id }}" class="template-post template-inactive office-post">
			<div class="post-type post-meta post-tooltip">
				@if($active->type == 'project')
				<span class="ss-list tooltip-hover"><span class="tooltip">Inactive<br />Template</span></span>
				<span class="post-meta-desc">{{ ucwords($active->type) }}</span>
				@elseif($active->type == 'billable')
				<span class="ss-dollarsign tooltip-hover"><span class="tooltip">Inactive<br />Template</span></span>
				<span class="post-meta-desc">{{ ucwords($active->type) }}</span>
				@elseif($active->type == 'invoice')
				<span class="ss-file tooltip-hover"><span class="tooltip">Inactive<br />Template</span></span>
				<span class="post-meta-desc">{{ ucwords($active->type) }}</span>
				@elseif($active->type == 'help')
				<span class="ss-help tooltip-hover"><span class="tooltip">Inactive<br />Template</span></span>
				<span class="post-meta-desc">{{ ucwords($active->type) }}</span>
				@else
				<span class="ss-ban tooltip-hover"><span class="tooltip">What is this?</span></span>
				<span class="post-meta-desc">{{ ucwords($active->type) }}</span>
				@endif
			</div>
			<h3>{{ link_to('/admin/templates/'. $active->slug.'/edit/', $active->name, array('class' => 'template-link')) }}</h3>
			<div class="post-date post-detail">
				<span><span class="post-date-text">Created:</span> {{ $active->created_at->format('M d, Y') }}</span>
			</div>
		</div>
	@endforeach
@stop