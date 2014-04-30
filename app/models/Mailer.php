<?php

class Mailer {

	public function sendTo($user, $subject, $view, $data = array())
    {
        Mail::queue($view, $data, function($message) use($user, $subject)
        {
            $message->to($user->email)
                    ->subject($subject);
        });
    }

    // public function article_ping(Article $article) {



    // 	$view = 'emails.ping';
    // 	$data = [];
    // 	$subject = 'IOS Remote Office Ping: ' . $article->title;

    // 	return $this->sendTo($user, $subject, $view, $data);
    // }

 //    public function send_ping_email($newArticle) {
	// 	$parseUsers = $newArticle->mentions;
	// 	$parseUsers = explode(' ',$parseUsers);
	// 	$users = array();
	// 	foreach($parseUsers as $user) {
	// 		if($user == '') unset($user);
	// 		else {
	// 			$users[] = $user;
	// 		}
	// 	}
	// 	foreach($users as $user) {
	// 		$userSend = User::where('user_path','=',$user)->first();
	// 		//dd($userSend);
	// 		$author = User::where('id', '=', $newArticle->author_id)->first();
	// 		$pingDetails = array('title' => $newArticle->title, 'link' => 'http://roosevelt.insideout.com/news/article/'.$newArticle->link, 'author' => $author->first_name . ' ' . $author->last_name, 'created_at' => $newArticle->created_at);
	// 		Mail::send('emails.ping', $pingDetails, function($message) use($userSend) {
	// 			$message->from('office@insideout.com', 'InsideOut Employee Remote Office');
	// 			$message->to($userSend->email, $userSend->first_name . ' ' . $userSend->last_name)->subject('You have been pinged!');
	// 		});
	// 	}
	// }

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