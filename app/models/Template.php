<?php

class Template extends Eloquent {

	protected $fillable = array('name','items','type');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'templates';

	public function getActiveTemplates($id = null) {
		$projectTemplates = Template::where('type','=','project')
							->where('status','=','active')
							->get();
		if($projectTemplates != null) {
			$options = '';
			foreach($projectTemplates as $pTemplate) {
				if($id == $pTemplate->id) $options .= '<option value="'.$pTemplate->id.'" selected>'. $pTemplate->name .'</option>';
				else $options .= '<option value="'.$pTemplate->id.'">'. $pTemplate->name .'</option>';
			}
			return $options;
		}
		else return;
	}

	public function displayChecklist($id) {
		$templateTasks = TemplateTask::where('template_id','=',$id)->get();
		$totalTasks = $templateTasks->count();
		$totalClosed = 0;
		$templateSections = array();
		$checkboxes = '';
		$sectionDisabled = '';
		$checkboxDisabled = '';
		$headerArrow = '';
		$checklistID = 0;
		$stages = array();
		$stageCount = 0;
		if($templateTasks->isEmpty()) {
			return 'Nothing here';
		}
		else {
			$checkboxes .= '<div class="checklist-box" total-checkboxes="'.$totalTasks.'"><div>';
			foreach($templateTasks as $task) {
				$checklistID++;
				if(in_array($task->section, $stages) !== true) {
					$stages[] = $task->section;
					
					$checkboxes .= '</div>';
					$checkboxes .= '<div class="checklist-section">';
					
					$checkboxes .= '<h4 class="checklist-header ss-dropdown "><span class="checklist-stage">'.$task->section.'</span></h4>';
					
					$stageCount++;
				}
				$checkboxes .= '<div class="checklist-checkbox-section"><input type="checkbox" class="checklist-checkbox" id="template-task-'.$task->id.'" name="template-task-'.$task->id.'" value="'.$task->id.'" /><label for="template-task-'.$task->id.'" class="checklist-checkbox-label custom-checkbox">'.$task->content.'</label></div>';

			}
			$checkboxes .= '</div>';

			return $checkboxes;
		}
	}
}