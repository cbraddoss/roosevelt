<?php

class Mailer {

	// public function sendTo($view, $subject = 'Notification on InsideOut Employee Remote Office', $pingDetails = array(), $userSend = array()) {

 //        // Mail::send('emails.notifications.main', $pingDetails, function($message) use($userSend, $newArticle) {
 //        //             $message->from('office@insideout.com', 'InsideOut Employee Remote Office');
 //        //             $message->to('cbraddoss@gmail.com', 'InsideOut Solutions')->subject($subject);
 //        //         });


 //        Mail::send($view, $pingDetails, function($message) use($userSend, $subject)
 //        {
 //            $message->to($userSend->email, $userSend->name)
 //                    ->subject($subject);
 //        });
 //    }

    // public function article_ping(Article $article) {
    // 	$view = 'emails.ping';
    // 	$data = [];
    // 	$subject = 'IOS Remote Office Ping: ' . $article->title;
    // 	return $this->sendTo($user, $subject, $view, $data);
    // }

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
                //return $this->sendTo($view, $subject, $pingDetails, $userSend);
            }
            else {
                $findTasks = find_assigned_count('tasks');
                $findProjects = find_assigned_count('projects');
                $findBillables = find_assigned_count('billables');
                $findHelp = find_assigned_count('help');

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
                    $message->to($userSend->email, $userSend->name)
                            ->subject($subject);
                });
                //return $this->sendTo($view, $subject, $pingDetails, $userSend);
            }
        }
    }

    //  public function welcome(User $user)
    // {
    //     $view = 'emails.welcome';
    //     $data = [];
    //     $subject = 'Welcome to Laracasts';

    //     return $this->sendTo($user, $subject, $view, $data);
    // }

    // public function cancellation(User $user)
    // {
    //     $view = 'emails.cancel';
    //     $data = [];
    //     $subject = 'Sorry to see you go';

    //     return $this->sendTo($user, $subject, $view, $data);

    // }

}