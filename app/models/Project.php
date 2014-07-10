<?php

class Project extends Eloquent {

	protected $fillable = array('title','content','priority','stage','subscribed','assigned_id','template_id','account_id','due_date','attachment');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'projects';

	public function getOpenProjects() {
		$projects = Project::where('status','=','open')
					->orderBy('due_date','ASC')
					->paginate(20);

		return $projects;
	}

	public function getCommentsCount($id) {
		$commentsCount = ProjectComment::where('project_id','=',$id)->count();
		return $commentsCount;
	}

	public function getAttachments($id,$class = 'post-single-attachment') {
		$project = Project::find($id);
		$projectImage = $project->attachment;
		$thumbnails = array();
		if(!empty($projectImage)) {
			foreach(unserialize($projectImage) as $attachment) {
				$getThumbnail = substr_replace($attachment, 'thumbnail-',17,0);
				$thumbnails[] = $getThumbnail;
			}
		}
		$thumbnailsSend = '';
		if(!empty($thumbnails)) {
			foreach($thumbnails as $thumbnail) {
				$attachmentTitle = preg_replace('/(\\/)(uploads)(\\/)(\\d+)(\\/)(\\d+)(\\/)(thumbnail)(-)(\\d+)(-)/is', '', $thumbnail);
				if(strpos($thumbnail, '.pdf')) $thumbnailsSend .= '<span class="right '.$class.' post-pdf-attachment"><a href="' . str_replace('thumbnail-','',$thumbnail) .'" target="_blank" rel="gallery-'.$id.'"><img src="/images/pdficon.png" alt="'.$attachmentTitle.'"><span>'.$attachmentTitle.'</span></a></span>';
				else $thumbnailsSend .= '<span class="right '.$class.'"><a href="'. str_replace('thumbnail-','',$thumbnail) .'" rel="gallery-'.$id.'">'. HTML::image($thumbnail, $attachmentTitle, array('class' => 'post-attachment')).'</a></span>';
			}
		}

		return $thumbnailsSend;
	}

	public function getTypeSelectList($selected = null) {
		$projectTypes = Template::where('type','=','project')->get();
		if($projectTypes != null) {
			$options = '';
			$optionsLast = '';
			foreach($projectTypes as $type) {
				if($type->status == 'inactive') {
					if($selected == $type->slug) $optionsLast .= '<option value="'.$type->slug.'" selected>' . $type->name.' (i)' . '</option>';
					else $optionsLast .= '<option value="'.$type->slug.'">' . $type->name.' (i)' . '</option>';
				}
				else {
					if($selected == $type->slug) $options .= '<option value="'.$type->slug.'" selected>'.($type->status == 'inactive' ? $type->name.' (i)' : $type->name).'</option>';
					else $options .= '<option value="'.$type->slug.'">'.($type->status == 'inactive' ? $type->name.' (i)' : $type->name).'</option>';			
				}
			}
			$options = $options.$optionsLast;
			return $options;
		}
		else return;
	}

	public function getTypeStagesSelectList($type, $selected = null) {
		//$templates = Template::find($typeID);
		$templateSections = array();
		$options = '';
		//foreach($templates as $template){
			$template = Template::where('slug','=',$type)->first();
			$templateTasks = TemplateTask::where('template_id','=',$template->id)->get();
			foreach($templateTasks as $task) {
				$templateSections[] = $task->section;
			}
		//}
		$templateSections = array_unique($templateSections);
		// dd($templateSections);
		foreach($templateSections as $stage) {
			if($selected == convert_stage_to_path($stage)) $options .= '<option value="'.convert_stage_to_path($stage).'" selected>'. $stage .'</option>';
			else $options .= '<option value="'.convert_stage_to_path($stage).'">'. $stage .'</option>';
		}
		return $options;
	}

	public function getProjectStages($selected = null, $pID) {
		$projectTasks = ProjectTask::where('project_id','=',$pID)->get();
		$projectSections = array();
		$options = '';
		$projectStage = array();
		$optionDisabled = '';
		foreach($projectTasks as $task) {
			$projectSections[] = $task->section;
			if($task->checkbox == 'open') $projectStage[$task->section][$task->id] = 'disabled';
			else $projectStage[$task->section][$task->id] = 'enabled';
		}
		$projectSections = array_unique($projectSections);
		// dd($projectStage);
		foreach($projectSections as $stage) {
			if($selected == $stage) $options .= '<option value="'.$stage.'" selected '.$optionDisabled.'>'. $stage .'</option>';
			else $options .= '<option value="'.$stage.'" '.$optionDisabled.'>'. $stage .'</option>';
			if(in_array('disabled',$projectStage[$stage])) $optionDisabled = 'disabled';
			else $optionDisabled = '';
		}
		return $options;
	}

	public function displayChecklist($id) {
		$projectTasks = ProjectTask::where('project_id','=',$id)->get();
		$totalTasks = $projectTasks->count();
		$totalSections = array();
		$totalClosed = 0;
		$projectSections = array();
		$checkboxes = '';
		$sectionDisabled = '';
		$checkboxDisabled = '';
		$headerArrow = '';
		$checklistID = 0;
		$stages = array();
		$stageCount = 0;
		$taskSkipped = array();
		$totalSkipped = array();
		$skippedCount = 0;
		$skippedTaskHeader = '';

		foreach($projectTasks as $task) {
			$projectSections[] = $task->section;
			if($task->checkbox == 'open') {
				$projectStage[$task->section][$task->id] = 'disabled';
			}
			else {
				$projectStage[$task->section][$task->id] = 'enabled';
			}
			// if($task->notes == 'skipped-task') {
			// 	$skippedCount++;
			// 	$taskSkipped[$task->section]['skipped'] = $skippedCount;
			// }
			// else {
			// 	$taskSkipped[$task->section]['active'] = 'active';
			// }
			$totalSections[] = $task->section;
		}
		$totalSections = array_count_values($totalSections);
		// dd(array_count_values($taskSkipped['Code Website']));

		$checkboxes .= '<div class="checklist-box" total-checkboxes="'.$totalTasks.'"><div>';
		foreach($projectTasks as $task) {
			$checklistID++;
			if(in_array($task->section, $stages) !== true) {
				$stages[] = $task->section;
				
				$checkboxes .= '</div>';
				$checkboxes .= '<div class="checklist-section">';
				
				//$totalSkipped = array_count_values($taskSkipped[$task->section]);
				// dd($taskSkipped[$task->section]);
				// if(array_key_exists('skipped',$taskSkipped[$task->section])) $skippedTaskHeader = '<span class="this-task-skipped">('.$taskSkipped[$task->section]['skipped'].' skipped)</span>';
				// else $skippedTaskHeader = '';

				if(in_array('disabled',$projectStage[$task->section])) $headerArrow = 'ss-dropdown';
				else $headerArrow = 'ss-directright section-complete';
				
				$checkboxes .= '<h4 class="checklist-header '.$headerArrow.' '.$sectionDisabled.'"><span class="checklist-stage">'.$task->section.'</span> <span class="checklist-header-progress">[ <span class="header-task-complete">'.$totalClosed.'</span><span>/</span><span class="header-task-total">'.$totalSections[$task->section].'</span> <span>complete</span> ] '.$skippedTaskHeader.'</span></h4>';
				
				if(in_array('disabled',$projectStage[$task->section])) $sectionDisabled = 'section-disabled';
				else $sectionDisabled = '';
				
				$stageCount++;
			}
			if($task->checkbox == 'closed') {
				$checked = 'checked checklist-status="closed"';
				if(Carbon::now()->format('Y') != Carbon::createFromFormat('Y-m-d H:i:s', $task->updated_at)->format('Y')) $taskFinishedYear = ', Y';
				else $taskFinishedYear = '';
				$userFinishedDate = Carbon::createFromFormat('Y-m-d H:i:s', $task->updated_at)->format('M j'.$taskFinishedYear);
				if($task->notes == 'skipped-task') $skippedTask = '<span class="this-task-skipped">(skipped)</span>';
				else $skippedTask = '';
				$userFinished = '<span class="checkbox-user-action">'.$skippedTask.' '.User::find($task->user_finished_id)->first_name.' '.User::find($task->user_finished_id)->last_name.' - '.$userFinishedDate.'</span>';
				$skipTask = '';
			}
			else {
				$checked = 'checklist-status="open"';
				$userFinished = '';
				$skipTask = '<button class="checklist-skip-task form-button" id="project-skip-task-'.$task->id.'" checklist-number="'.$checklistID.'" task-id="'.$task->id.'">Skip</button>';
			}
			$checkboxes .= '<div class="checklist-checkbox-section"><input type="checkbox" class="checklist-checkbox '.$checkboxDisabled.'" id="project-task-'.$task->id.'" checklist-number="'.$checklistID.'" name="project-task-'.$task->id.'" value="'.$task->id.'" '.$checked.' '.$checkboxDisabled.' /><label for="project-task-'.$task->id.'" class="checklist-checkbox-label custom-checkbox">'.$task->content.' '.$userFinished.'</label>'.$skipTask.'</div>';

			// if(in_array('disabled',$projectStage[$task->section])) $checkboxDisabled = 'disabled';
			// else $checkboxDisabled = '';
		}
		$checkboxes .= '</div>';

		return $checkboxes;
	}

	public function displayProgress($id) {
		$projectTasks = ProjectTask::where('project_id','=',$id)->get();
		$totalTasks = $projectTasks->count();
		$progress = '';
		$openTasks = array();
		$countOpen = 0;
		
		foreach($projectTasks as $task) {
			if($task->checkbox == 'open') {
				$openTasks[$task->id] = 'open';
			}
			else {
				$openTasks[$task->id] = 'closed';
				$countOpen++;
			}
		}
		if($totalTasks > 0) {
			$totalProgressWidth = 200/$totalTasks;
			$doneProgressWidth = $totalProgressWidth*$countOpen;
		}
		else {
			$totalProgressWidth = 200;
			$doneProgressWidth = $totalProgressWidth*$countOpen;
		}

			//$(document).find('#header-menu .post-progress .post-progress-progress').css('width',divProgressWidth+totalProgressWidth+'px');

		$progress .= '<div class="post-progress">';
		if($doneProgressWidth == 0) $progress .= '<span class="post-progress-progress-zero"></span>';
		$progress .= '<span class="post-progress-icon ss-check"></span>';
		$progress .= '<div class="post-progress-numbers">';
		$progress .= '<span class="post-progress-complete">'.$countOpen.'</span>';
		$progress .= '<span>/</span>';
		$progress .= '<span class="post-progress-total">'.$totalTasks.'</span>';
		$progress .= '</div>';
		$progress .= '<div class="post-progress-progress" style="width:'.$doneProgressWidth.'px">';

		for ($i=0; $i < $countOpen; $i++) {
			$progress .= '<span class="post-progress-progress-done"></span>';
		}
		
		$progress .= '</div>';
		$progress .= '</div>';

		return $progress;
	}
}