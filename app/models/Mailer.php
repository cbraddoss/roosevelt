<?php

class Mailer {

	public function sendTo($user, $subject, $view, $data = [])
    {
        Mail::queue($view, $data, function($message) use($user, $subject)
        {
            $message->to($user->email)
                    ->subject($subject);
        });
    }

     public function welcome(User $user)
    {
        $view = 'emails.welcome';
        $data = [];
        $subject = 'Welcome to Laracasts';

        return $this->sendTo($user, $subject, $view, $data);
    }

    public function cancellation(User $user)
    {
        $view = 'emails.cancel';
        $data = [];
        $subject = 'Sorry to see you go';

        return $this->sendTo($user, $subject, $view, $data);

    }

}