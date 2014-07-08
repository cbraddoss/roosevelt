<div class="new-form-field">
{{ Form::label('section', 'Task:') }}
{{ Form::text('section[]', null, array('placeholder' => 'Section', 'class' => 'field template-section')) }}
{{ Form::text('content[]', null, array('placeholder' => 'Task description', 'class' => 'field template-content')) }}
<div class="new-form-field remove-task">
	<div class="form-textarea-buttons">
		<span class="textarea-button template-code ss-hyphen"></span>
	</div>
</div>
</div>