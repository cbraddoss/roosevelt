<?php

class Mailer {

	public function sendTo($view = 'emails.notifications.main', $subject = 'Notification on InsideOut Employee Remote Office', $pingDetails = array(), $userSend = array()) {

        // Mail::send('emails.notifications.main', $pingDetails, function($message) use($userSend, $newArticle) {
        //             $message->from('office@insideout.com', 'InsideOut Employee Remote Office');
        //             $message->to('cbraddoss@gmail.com', 'InsideOut Solutions')->subject($subject);
        //         });


        Mail::send($view, $pingDetails, function($message) use($userSend, $subject)
        {
            $message->to($userSend->email, $userSend->name)
                    ->subject($subject);
        });
    }

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
                $author = User::find($article->author_id);
                $pingDetails = array(
                    'title' => $article->title,
                    'author' => $author->first_name . ' ' . $author->last_name,
                    'link' => URL::to( '/news/article/' . $article->slug ),
                    'created_at' => $article->created_at->format('F j, Y g:i a'),
                    'content' => '<p>You have been pinged by ' . $author->first_name . ' ' . $author->last_name . ' in <b>' . $article->title . '</b></p>
                                  <p>View the post here: <a href="' . URL::to( '/news/article/' . $article->slug ) . '">' . $article->title . '</a></p>
                                  <small>This post was created on ' . $article->created_at->format('F j, Y g:i a') . '</small>',
                    'activity' => '',
                    'tasks' => '',
                    'projects' => '',
                    'billables' => '',
                    'help' => '',
                    );
                
                $view = 'emails.notifications.insideout-ping';
                $subject = 'InsideOut has been pinged in ' . $article->title;

                return $this->sendTo($view, $subject, $pingDetails, $userSend);
            }
            else {
                $findTasks = find_assigned_count('tasks');
                $findProjects = find_assigned_count('projects');
                $findBillables = find_assigned_count('billables');
                $findHelp = find_assigned_count('help');

                $userSend = User::where('user_path','=',$user)->first();
                $author = User::where('id', '=', $article->author_id)->first();
                $pingDetails = array(
                    'title' => $article->title,
                    'author' => $author->first_name . ' ' . $author->last_name,
                    'link' => URL::to( '/news/article/' . $article->slug ),
                    'created_at' => $article->created_at->format('F j, Y g:i a'),
                    'content' => '<p>You have been pinged by ' . $author->first_name . ' ' . $author->last_name . ' in <b>' . $article->title . '</b></p>
                                  <p>View the post here: <a href="http://roosevelt.insideout.com/news/article/' . $article->slug . '">' . $article->title . '</a></p>
                                  <small>This post was created on ' . $article->created_at->format('F j, Y g:i a') . '</small>',
                    'activity' => '<h4>Your Current Activity:</h4>
                                   <ul>
                                   <li><a href="http://roosevelt.insideout.com/tasks/">' . $findTasks . ' Tasks</a></li>
                                   <li><a href="http://roosevelt.insideout.com/projects/">' . $findProjects . ' Projects</a></li>
                                   <li><a href="http://roosevelt.insideout.com/billables/">' . $findBillables . ' Billables</a></li>
                                   <li><a href="http://roosevelt.insideout.com/help/">' . $findHelp . ' Help</a></li>
                                   </ul>',
                    'activity' => '',
                    'tasks' => '',
                    'projects' => '',
                    'billables' => '',
                    'help' => '',
                    );

                $view = 'emails.notifications.employee-ping';
                $subject = 'You have been pinged in ' . $article->title;

                return $this->sendTo($view, $subject, $pingDetails, $userSend);
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