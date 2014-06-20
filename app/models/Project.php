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
}