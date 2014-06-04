<?php

class Template extends Eloquent {

	protected $fillable = array('name','items','type');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'templates';

	public function convertCode($items) {
		// $newItemsH = strpos($items, '[[h]]');
		// if($newItemsH !== false) $newItems = preg_replace('/\[\[h\]\](.*)/i','<h3 class="checklist-header ss-dropdown">$1</h3>', $items);
		// $newItemsO = strpos($newItems, '[[o]]');
		// if($newItemsO !== false) $newItems = preg_replace('/\[\[o\]\](.*)/i','<input type="checkbox" class="checklist-checkbox" value="$1" />$1', $newItems);
		// $newItemsS = strpos($newItems, '[[START]]');
		// if($newItemsS !== false) $newItems = str_replace('[[START]]','', $newItems);
		// $newItemsE = strpos($newItems, '[[END]]');
		// if($newItemsE !== false) $newItems = str_replace('[[END]]','', $newItems);
		$newItems = explode("\n",$items);
		$checklist = '';
		$checkNum = 1;
		foreach($newItems as $item) {
			$item = trim($item);
			if($item == '[[START]]') $checklist .= '<div class="checklist-section">';
			$newItemsH = strpos($item, '[[h]]');
			if($newItemsH !== false) {
				$checklistParse = str_replace('[[h]]','', $item);
				$checklistParse = '<h3 id="'.$checklistParse.'" class="checklist-header ss-dropdown">' . $checklistParse . '</h3>';
				$checklist .= $checklistParse;
			}
			$newItemsO = strpos($item, '[[o]]');
			if($newItemsO !== false) {
				$checklistParse = str_replace('[[o]]','', $item);
				$checklistParse = '<div class="checklist-checkbox-section"><input type="checkbox" class="checklist-checkbox" id="checklist-checkbox-'.$checkNum.'" name="checklist-checkbox-'.$checkNum.'" value="' . $checklistParse . '" /><label for="checklist-checkbox-'.$checkNum.'" class="checklist-checkbox-label custom-checkbox">'.$checklistParse.'</label></div>';
				$checklist .= $checklistParse;
			}
			if($item == '[[END]]') $checklist .= '</div>';
			$checkNum++;
		}
		//dd($newItems);

		return $checklist;
	}
}