<?php

class Mailer {

    public function projectNewSubEmail(Project $project) {
        $parseUsers = $project->subscribed;
        $parseUsers = explode(' ',$parseUsers);

        $users = array();
        foreach($parseUsers as $pUser) {
            if($pUser == '') unset($pUser);
            else {
                $users[] = $pUser;
            }
        }

        foreach($users as $eUser) {
            $findTasks = find_assigned_count('tasks','email');
            $findProjects = find_assigned_count('projects','email');
            $findBillables = find_assigned_count('billables','email');
            $findHelp = find_assigned_count('help','email');

            $userSend = User::where('user_path','=',$eUser)->first();
            $author = User::where('id', '=', $project->author_id)->first();
            $pingDetails = array(
                'title' => $project->title,
                'author' => $author->first_name . ' ' . $author->last_name,
                'launch_date' => Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->format('F j, Y'),
                'link' => URL::to( '/projects/post/' . $project->slug ),
                'created_at' => $project->created_at->format('F j, Y g:i a'),
                'tasks' => $findTasks,
                'projects' => $findProjects,
                'billables' => $findBillables,
                'help' => $findHelp,
                );

            $view = 'emails.notifications.project-new-sub';
            $subject = 'You have been subscribed to a project: ' . $project->title;

            Mail::later(10, $view, $pingDetails, function($message) use($userSend, $subject)
            {
                $message->to($userSend->email, $userSend->first_name.' '.$userSend->last_name)
                        ->subject($subject);
            });
        }
    }

    public function projectListUserChangeEmail(Project $project, $currentUser) {

        $findTasks = find_assigned_count('tasks','email');
        $findProjects = find_assigned_count('projects','email');
        $findBillables = find_assigned_count('billables','email');
        $findHelp = find_assigned_count('help','email');

        $userSend = User::find($project->assigned_id);
        // dd($userSend);
        $author = User::find($project->author_id);
        $currentUser = User::find($currentUser);
        $pingDetails = array(
            'title' => $project->title,
            'link' => URL::to( '/projects/post/' . $project->slug ),
            'current_user' => $currentUser->first_name . ' ' . $currentUser->last_name,
            'stage' => $project->stage,
            'due_date' => Carbon::createFromFormat('Y-m-d H:i:s', $project->due_date)->format('F j, Y'),
            'launch_date' => Carbon::createFromFormat('Y-m-d H:i:s', $project->end_date)->format('F j, Y'),
            'created_at' => $project->created_at->format('F j, Y g:i a'),
            'tasks' => $findTasks,
            'projects' => $findProjects,
            'billables' => $findBillables,
            'help' => $findHelp,
            );

        $view = 'emails.notifications.project-user-assigned';
        $subject = 'You have been assigned to a project: ' . $project->title;

        Mail::later(10, $view, $pingDetails, function($message) use($userSend, $subject)
        {
            $message->to($userSend->email, $userSend->first_name.' '.$userSend->last_name)
                    ->subject($subject);
        });
    }

    public function articlePingEmail(Article $article, $previousMentions = '') {
        $parseUsers = $article->mentions;
        $parseUsers = explode(' ',$parseUsers);

        $parseOldUsers = $previousMentions;
        $parseOldUsers = explode(' ', $parseOldUsers);

        $users = array();
        foreach($parseUsers as $pUser) {
            if($pUser == '') unset($pUser);
            elseif(in_array($pUser, $parseOldUsers)) unset($pUser);
            else {
                $users[] = $pUser;
            }
        }

        foreach($users as $eUser) {
            if($eUser == 'insideout') {
                $userSend = array(
                    'email' => 'cbraddoss@gmail.com',
                    'name' => 'InsideOut Solutions'
                    );
                $userObject = new stdClass();
                foreach ($userSend as $key => $value)
                {
                    $userObject->$key = $value;
                }
                $userSend = $userObject;
                $author = User::find($article->author_id);
                $pingDetails = array(
                    'title' => $article->title,
                    'author' => $author->first_name . ' ' . $author->last_name,
                    'link' => URL::to( '/news/article/' . $article->slug ),
                    'created_at' => $article->created_at->format('F j, Y g:i a'),
                    );
                
                $view = 'emails.notifications.insideout-ping';
                $subject = 'InsideOut has been pinged in ' . $article->title;

                Mail::later(20, $view, $pingDetails, function($message) use($userSend, $subject)
                {
                    $message->to($userSend->email, $userSend->name)
                            ->subject($subject);
                });
            }
            else {
                $findTasks = find_assigned_count('tasks','email');
                $findProjects = find_assigned_count('projects','email');
                $findBillables = find_assigned_count('billables','email');
                $findHelp = find_assigned_count('help','email');

                $userSend = User::where('user_path','=',$eUser)->first();
                $author = User::where('id', '=', $article->author_id)->first();
                $pingDetails = array(
                    'title' => $article->title,
                    'author' => $author->first_name . ' ' . $author->last_name,
                    'link' => URL::to( '/news/article/' . $article->slug ),
                    'created_at' => $article->created_at->format('F j, Y g:i a'),
                    'tasks' => $findTasks,
                    'projects' => $findProjects,
                    'billables' => $findBillables,
                    'help' => $findHelp,
                    );

                $view = 'emails.notifications.employee-ping';
                $subject = 'You have been pinged in ' . $article->title;

                Mail::later(10, $view, $pingDetails, function($message) use($userSend, $subject)
                {
                    $message->to($userSend->email, $userSend->first_name.' '.$userSend->last_name)
                            ->subject($subject);
                });
            }
        }
    }
    function articleCommentPingEmail(ArticleComment $newArticleComment, $previousMentions = '') {
        $parseUsers = $newArticleComment->mentions;
        $parseUsers = explode(' ',$parseUsers);

        $parseOldUsers = $previousMentions;
        $parseOldUsers = explode(' ', $parseOldUsers);

        $users = array();
        foreach($parseUsers as $pUser) {
            if($pUser == '') unset($pUser);
            elseif(in_array($pUser, $parseOldUsers)) unset($pUser);
            else {
                $users[] = $pUser;
            }
        }

        $articleWithComment = Article::find($newArticleComment->article_id);
        $authorComment = User::find($newArticleComment->author_id);
        $authorArticle = User::find($articleWithComment->author_id);
        $commentOfComment = ArticleComment::find($newArticleComment->reply_to_id);
        if($commentOfComment) {
            $authorCommentOnComment = User::find($commentOfComment->author_id);
        }
        else {
            $authorCommentOnComment = false;
            
        }

        if($authorCommentOnComment != false) {
            // send email to comment author
            if($authorCommentOnComment->id != $authorComment->id) {

                $findTasks = find_assigned_count('tasks','email');
                $findProjects = find_assigned_count('projects','email');
                $findBillables = find_assigned_count('billables','email');
                $findHelp = find_assigned_count('help','email');

                $pingCommentAuthorDetails = array(
                    'title' => $articleWithComment->title,
                    'author' => $authorComment->first_name . ' ' . $authorComment->last_name,
                    'link' => URL::to( '/news/article/' . $articleWithComment->slug.'?comment=new#comment-'.$newArticleComment->id ),
                    'created_at' => $newArticleComment->created_at->format('F j, Y g:i a'),
                    'tasks' => $findTasks,
                    'projects' => $findProjects,
                    'billables' => $findBillables,
                    'help' => $findHelp,
                );

                $view = 'emails.notifications.comment-comment';
                $subject = 'Your comment on, '.$articleWithComment->title.', has a new reply.';

                Mail::later(10, $view, $pingCommentAuthorDetails, function($message) use($authorCommentOnComment, $subject)
                {
                    $message->to($authorCommentOnComment->email, $authorCommentOnComment->first_name.' '.$authorCommentOnComment->last_name)
                            ->subject($subject);
                });
            }

            // send email to article author
            if($authorCommentOnComment->id != $authorArticle->id) {

                $findTasks = find_assigned_count('tasks','email');
                $findProjects = find_assigned_count('projects','email');
                $findBillables = find_assigned_count('billables','email');
                $findHelp = find_assigned_count('help','email');

                $pingAuthorDetails = array(
                    'title' => $articleWithComment->title,
                    'author' => $authorComment->first_name . ' ' . $authorComment->last_name,
                    'link' => URL::to( '/news/article/' . $articleWithComment->slug.'?comment=new#comment-'.$newArticleComment->id ),
                    'created_at' => $newArticleComment->created_at->format('F j, Y g:i a'),
                    'tasks' => $findTasks,
                    'projects' => $findProjects,
                    'billables' => $findBillables,
                    'help' => $findHelp,
                );

                $view = 'emails.notifications.article-comment';
                $subject = 'Your article, '.$articleWithComment->title.', has a new reply.';

                Mail::later(10, $view, $pingAuthorDetails, function($message) use($authorArticle, $subject)
                {
                    $message->to($authorArticle->email, $authorArticle->first_name.' '.$authorArticle->last_name)
                            ->subject($subject);
                });
            }
        }
        else {
            // send email to article author
            if($authorComment->id != $authorArticle->id) {

                $findTasks = find_assigned_count('tasks','email');
                $findProjects = find_assigned_count('projects','email');
                $findBillables = find_assigned_count('billables','email');
                $findHelp = find_assigned_count('help','email');

                $pingAuthorDetails = array(
                    'title' => $articleWithComment->title,
                    'author' => $authorComment->first_name . ' ' . $authorComment->last_name,
                    'link' => URL::to( '/news/article/' . $articleWithComment->slug.'?comment=new#comment-'.$newArticleComment->id ),
                    'created_at' => $newArticleComment->created_at->format('F j, Y g:i a'),
                    'tasks' => $findTasks,
                    'projects' => $findProjects,
                    'billables' => $findBillables,
                    'help' => $findHelp,
                );

                $view = 'emails.notifications.article-comment';
                $subject = 'Your article, '.$articleWithComment->title.', has a new reply.';

                Mail::later(10, $view, $pingAuthorDetails, function($message) use($authorArticle, $subject)
                {
                    $message->to($authorArticle->email, $authorArticle->first_name.' '.$authorArticle->last_name)
                            ->subject($subject);
                });
            }
        }

        // send email(s) to pinged users
        foreach($users as $user) {
            if($user == 'insideout') {
                 $userSend = array(
                    'email' => 'cbraddoss@gmail.com',
                    'name' => 'InsideOut Solutions'
                    );
                $userObject = new stdClass();
                foreach ($userSend as $key => $value)
                {
                    $userObject->$key = $value;
                }
                $userSend = $userObject;

                $pingDetails = array(
                    'title' => $articleWithComment->title,
                    'author' => $authorComment->first_name . ' ' . $authorComment->last_name,
                    'link' => URL::to( '/news/article/' . $articleWithComment->slug.'?comment=new#comment-'.$newArticleComment->id ),
                    'created_at' => $newArticleComment->created_at->format('F j, Y g:i a'),
                    );
                
                $view = 'emails.notifications.insideout-ping';
                $subject = 'InsideOut has been pinged in ' . $articleWithComment->title;

                Mail::later(20, $view, $pingDetails, function($message) use($userSend, $subject)
                {
                    $message->to($userSend->email, $userSend->name)
                            ->subject($subject);
                });
            }
            else {
                $findTasks = find_assigned_count('tasks','email');
                $findProjects = find_assigned_count('projects','email');
                $findBillables = find_assigned_count('billables','email');
                $findHelp = find_assigned_count('help','email');

                $pingDetails = array(
                    'title' => $articleWithComment->title,
                    'author' => $authorComment->first_name . ' ' . $authorComment->last_name,
                    'link' => URL::to( '/news/article/' . $articleWithComment->slug.'?comment=new#comment-'.$newArticleComment->id ),
                    'created_at' => $newArticleComment->created_at->format('F j, Y g:i a'),
                    'tasks' => $findTasks,
                    'projects' => $findProjects,
                    'billables' => $findBillables,
                    'help' => $findHelp,
                    );

                $view = 'emails.notifications.employee-ping';
                $subject = 'You have been pinged in ' . $articleWithComment->title;
                $userSend = User::where('user_path','=',$user)->first();

                Mail::later(10, $view, $pingDetails, function($message) use($userSend, $subject)
                {
                    $message->to($userSend->email, $userSend->first_name.' '.$userSend->last_name)
                            ->subject($subject);
                });
            }
        }
    }
}