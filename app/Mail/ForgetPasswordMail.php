<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    public $resetcode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username,$resetcode)
    {
        $this->username = $username;
        $this->resetcode = $resetcode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.auth.forget_password_mail')->with(['username'=>$this->username, 'resetcode'=>$this->resetcode]);
    }
}
