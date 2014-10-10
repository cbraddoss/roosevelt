<div class="new-form-field">
{{ Form::label('section', 'Task Section:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
</div>

<div class="new-form-field">
{{ Form::label('content', 'Task Description:') }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
</div>

<div class="new-form-field">
	<div class="form-action-buttons post-tooltip">
		<span class="textarea-button form-action-button template-code remove-task ss-hyphen"></span>
		<span class="textarea-button form-action-button template-code add-task ss-plus tooltip-hover"><span class="tooltip">Add Section/Task Below</span></span>
	</div>
</div>