@extends('layout.main')

@section('page-title')
{{ 'Billables' }}
@stop

@section('header-menu')
	<div class="page-menu">
		<ul>
			<li>
				<div id="billables-new-billable-form" class="create-something-new">
					<span class="billables-button"><button class="add-new ss-plus">Add New</button></span>
				</div>
			</li>
			<li></li>
		</ul>
	</div>
@stop

@section('page-content')
<div id="billables-page"  class="inner-page">
	
</div>
@stop